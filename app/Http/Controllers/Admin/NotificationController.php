<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Storage;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use LaravelFCM\Message\Topics;

use App\Models\Notification;

use App\Models\BeneficiaireUser;
use App\Models\Beneficiairetranslate;
use App\Models\Beneficiaire;

class NotificationController extends Controller
{

	 public function sendTo($id)
    {
        $user = User::find($id);

        return view('notification.specific', compact('user'));
    }
	

	public function indexOne()
    {
    	$users = User::select('id','email')->get();
        
        return view('notification.one', compact('users'));
    }

	public function pushOne(Request $request){
        $desc = $request->description;
        $title = $request->title;
        $email = $request->email;
        
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($desc)
                                ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['title'=>$title,'description' => $request->description]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        if($email === "1") {
            //echo 'email = 1';
            $payment_pending = BeneficiaireUser::where('beneficiaire_user.status','=','validé')
                    ->get();
            foreach ($payment_pending as $payment) {
                $user = User::find($payment->user_id);
                $beneficiaire = Beneficiairetranslate::where('beneficaire_id', '=', $payment->beneficiaire_id)->where('language_id', '=', 2)->first();
                
                $description = $request->description;
                $description = str_replace("beneficiaire", $beneficiaire->first_name, $description);
                $description = str_replace("utilisateur", $user->firstname, $description);
                //$description = sprintf($request->description, $user->first_name);

                $dataBuilder = new PayloadDataBuilder();
                $dataBuilder->addData(['title' => $title, 'description' => $description]);

                $option = $optionBuilder->build();
                $notification = $notificationBuilder->build();
                $data = $dataBuilder->build();
                
                $token = $user->device_token;
                if($token) {
                    $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
                }
                $notif = new Notification;
                $notif->user_id = $user->id;
                $notif->title = $title;
		$notif->description = $description;
		$notif->lu = 0 ;
                $notif->save();
                //echo 'send notification title = ' . $description . PHP_EOL;
                //echo $title . " " . $description . " \n";
                //$this->sendNotification($title, $description, 42, false);
                //$this->sendNotification($title, $description, $payment->user_id, false);
            }
                exit();
        } else if($email === "0") {
            $topic = new Topics();
            $topic->topic('all');
            //var_dump("email is 0" . $email);
            $downstreamResponse = FCM::sendToTopic($topic, $option, $notification, $data);
            //echo 'email = 0';
        } else {
            //echo 'email != 0';
            $emails = explode(";", $email);
            $users = User::whereIn('email', $emails)->get();
            //$users = User::where('email', '=', $email)->get()->toArray();
            /*if($user) {
                $user_id = $user->id;
            } else {
                $user_id = 0;
            }*/
            foreach ($users as $user) {
                $notif = new Notification;
                $notif->user_id = $user->id;
                $notif->title = $title;
		$notif->description = $desc;
		$notif->lu = 0 ;
                //$notification->image = ...
                $notif->save();
                //$user = User::select('device_token')->where('id','=',$user_id)->first();
                $token = $user->device_token;
                if($token) {
                    $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
                }
            }
        }
        $status = TRUE;
        $message = 'invitation sended';
        
        $users = User::select('id','email')->get();
        return view('notification.one', compact('users'));
        
    }

    
}
