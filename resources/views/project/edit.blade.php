@extends('backpack::layout')
@section('before_styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection
@section('title', 'Bénéficiaires')

@section('content')

        <section class="content-header">
            <h1>
            Projets
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Projets</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">Modifier un Projet</div>
                        <div class="box-body" style="text-align: center; vertical-align: middle;">
                            <form method="POST" action="/admin/project/update"  enctype="multipart/form-data" id="form">
				{{ csrf_field() }}

												<div class="row" 
								style="text-align: center;
								       vertical-align: middle;
									display: flex;
  									flex-direction: column;
  									justify-content: center;
  									align-items: center;
  									text-align: center;
					
									"> 
									<!--	<div class="form-group col-xs-6">-->
										<div style="margin : 15px;">
                                                                                <!--<label>Image</label>-->
                                                                                <a href="{{url('uploads/'.$project->image)}}">
                                                                                        <img src="{{url('uploads/'.$project->image)}}" style="
                                                                                                          max-height: 25vh;
													  width: 25vw;
													  position: relative;

													  border-radius: 5px;
													  margin:20px;		">
                                                                            </a>
                                                                                <input type="file" accept="image/*" name="image" value="" id="image" class="form-control">
                                                                        </div>
									</div>	
										
								<div class="row">



							

                                    <div class="form-group col-xs-4">
										<label>statut</label>
                                        <select name="status" class="form-control" required>

					       <!-- <option value="None" required >-- Select --</option>-->

						@if($project->status == 'open')
								


						<option disabled  value> -- Select -- </option>
                                                <option selected value="open">ouvert</option>
                                                <option value="closed">fermé</option>
	

						@else
							<option disabled  value> -- Select -- </option>
                                                <option  value="open">ouvert</option>
                                                <option selected value="closed">fermé</option>
						@endif	

                                             </select>
									</div>
									<div class="form-group col-xs-4">
										<label>référence</label>
										<input type="text" name="reference" value="{{$project->reference}}" required class="form-control">
									</div>

<!--    <div class="form-group col-xs-6">
                                                                                <label>Image</label>
                                                                                <a href="{{url('uploads/'.$project->image)}}">
                                                                                        <img src="{{url('uploads/'.$project->image)}}" style="
                                                                                                          max-height: 150px;
                                                                                                          width: 150px;
                                                                                                          border-radius: 5px;">
                                                                            </a>
                                                                                <input type="file" accept="image/*" name="image" value="" id="image" class="form-control">
                                                                        </div>-->



</div>
	</div>
								<div style="padding:10px;" class="row">
									<div class="form-group col-xs-4">
										<label>Demandé</label>
										<input type="number" id="needed" max="999999999" min="1" name="needed" value="{{$project->needed}}" required class="form-control">
									</div>

<div class="form-group col-xs-4">
                                                                                <label>Collecté</label>
                                                                                <input type="number" name="collected" max="999999999" id="collected" value="{{$project->collected}}" required class="form-control">
                                                                        </div>

									<div class="form-group col-xs-4">
										<label>date estimé</label>
										<div class="input-group date">
										  <div class="input-group-addon">
													<i class="fa fa-calendar"></i>
										  </div>
										  <input type="date" id="death_date" name="deadline"
                                  value="{{$project->deadline}}" required
                                    >

				       </div></div></div> 



			<div class="row" style="padding:15px;">


                                                                <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Titre (fr) :</label>
                                                                                        @php
                                                                                                $b_title_fr = false
                                                                                        @endphp
                                                                                        @foreach ($project->project_translates as $translate)@if($translate->language_id == 1)
                                                                                                @php
                                                                                                        $b_title_fr = true
                                                                                                @endphp
                                                                                        <input type="text" name="title_fr" value="{{ $translate->title }}" required class="form-control">
                                                                                        @endif @endforeach
                                                                                        @if(!$b_title_fr)
                                                                                                <input type="text" name="title_fr"    required class="form-control">
                                                                                        @endif
                                                                                </div>
                                                                        </div>


                                                                        <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Titre (ar) :</label>
                                                                                        @php
                                                                                                $b_title_ar = false
                                                                                        @endphp
                                                                                        @foreach ($project->project_translates as $translate)@if($translate->language_id == 2)
                                                                                                @php
                                                                                                        $b_title_ar = true
                                                                                                @endphp
                                                                                        <input type="text" name="title_ar" value="{{ $translate->title }}" required class="form-control">
                                                                                        @endif @endforeach
                                                                                        @if(!$b_title_ar)
                                                                                                <input type="text" name="title_ar"    required class="form-control">
                                                                                        @endif
                                                                                </div>
                                                                        </div>



                                                                </div>	
                                    <div class="row" style="padding:15px;">


                                                                        <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Description (fr) :</label>
                                                                                        @php
                                                                                                $b_description_fr = false
                                                                                        @endphp
                                                                                        @foreach ($project->project_translates as $translate) @if($translate->language_id == 1)
                                                                                                @php
                                                                                                        $b_description_fr = true
                                                                                                        @endphp
                                                                                        <textarea  required class="form-control" name="description_fr" required  cols="50"> {{ $translate->description }}</textarea>

                                                                                        @endif @endforeach
                                                                                        @if(!$b_description_fr)
                                                                                                <textarea  required class="form-control" name="description_fr" required  cols="50"> </textarea>
                                                                                        @endif
                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-6">

                                                                                <div class="form-group">
                                                                                        <label>Description (ar) :</label>
                                                                                        @php
                                                                                                $b_description_ar = false
                                                                                        @endphp
                                                                                        @foreach ($project->project_translates as $translate)@if($translate->language_id == 2)
                                                                                                @php
                                                                                                        $b_description_ar = true
                                                                                                @endphp
                                                                                        <textarea  required class="form-control" name="description_ar"  required  cols="50"> {{ $translate->description }}</textarea>
                                                                                                @endif @endforeach
                                                                                        @if(!$b_description_ar)
                                                                                                <textarea  required class="form-control" name="description_ar" required  cols="50"> </textarea>
                                                                                        @endif
                                                                                </div>
                                                                        </div>
<div class="row" style="padding:15px;">
<div class="form-group col-xs-4">

<label id="textInput">Avancement réel</label>


<div id="seekbar" class="slidecontainer">
  <input type="range" min="0" max="100"  name="advancement" disabled value="{{$project->advancement}}" class="slider" id="myRange">
</div>
</div>			</div>





                                <!--<hr>
                                                                <h3>
                                                                        Liste des Images et des vidéos
                                                                        <a href="/admin/create/media/{{$project->id}}" class="btn btn-primary ladda-button pull-right" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter un média</span></a>
                                                                </h3>
                                                                <ul class="list-group">
                                                                @foreach ($project->project_media as $image)
                                                                        <li class="list-group-item"><a href="{{url('uploads/'.$image->link)}}">
                                                                                        <img src="{{url('uploads/'.$image->link)}}" style="
                                                                                                          max-height: 70px;
                                                                                                          width: 70px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                                                <a href="/admin/media/delete/{{ $image->id }}" class="btn btn-xs btn-default pull-right"><i class="fa fa-trash"></i> Supprimer</a>
                                                                        </li>

                                                                @endforeach
                                                                </ul>


                                                                <hr>
                                                                <h3>
                                                                        Liste des avancements réels du projet
                                                                        <a href="/admin/create/advancement/{{$project->id}}" class="btn btn-primary ladda-button pull-right" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter une activité</span></a>
                                                                </h3>
                                                                <ul class="list-group">
                                                                @foreach ($project->project_advancement as $advancement)
                                                                        <li class="list-group-item"><a href="{{url('uploads/'.$advancement->image)}}">
                                                                                <span>{{$advancement->title}}</span><br/>
                                                                                <img src="{{url('uploads/'.$advancement->image)}}" style="
                                                                                                          max-height: 70px;
                                                                                                          width: 70px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                                                <a href="/admin/advancement/delete/{{ $advancement->id }}" class="btn btn-xs btn-default pull-right"><i class="fa fa-trash"></i> Supprimer</a>
                                                                        </li>

                                                                @endforeach
                                                                </ul>


</section>
-->
<hr>
                                                                <h3 style="padding:15px;">
                                                                        Liste des Images et des vidéos
                                                                        <a href="/admin/create/media/{{$project->id}}" class="btn btn-primary ladda-button pull-right" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter un média</span></a>
                                                                </h3>
                                                                <ul class="list-group">
                                                                @foreach ($project->project_media as $image)
									<li class="list-group-item">

 @if ($image->type == 'image')
                                                         <a href="{{url($image->url)}}">
                                                                                        <img src="{{url($image->url)}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                 @elseif ($image->type == 'video')

                                                                                <a href="{{url($image->url)}}">


                                                                <img src="{{url('uploads/videoimage.png')}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                @endif	
									    
                                                                            
                                                                            
                                                                             
                                                                                <a href="/admin/media/delete/{{ $image->id }}" class="btn btn-xs btn-default pull-right"><i class="fa fa-trash"></i> Supprimer</a>
                                                                        </li>

                                                                @endforeach
                                                                </ul>


                                                                <hr>
                                                                <h3 style="padding:15px;">
                                                                        Liste des avancements
                                                                        <a href="/admin/create/advancement/{{$project->id}}" class="btn btn-primary ladda-button pull-right" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter un avancement</span></a>
                                                                </h3>
                                                                <ul class="list-group">
                                                                @foreach ($project->project_advancement as $wall)
									<li class="list-group-item">

									                                                                                                                                                           
                                                                                
                                                                                
									 @if ($wall->type == 'image')
                                                         <a href="{{url($wall->image)}}">
                                                                                     <span>{{$wall->title}}</span><br/>    <img src="{{url($wall->image)}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                 @elseif ($wall->type == 'video')

                                                                                <a href="{{url($wall->image)}}">
										 <span>{{$wall->title}}</span><br/>

                                                                <img src="{{url('uploads/videoimage.png')}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                @endif
                                                                                <a href="/admin/advancement/delete/{{ $wall->id }}" class="btn btn-xs btn-default pull-right"><i class="fa fa-trash"></i> Supprimer</a>
                                                                        </li>

                                                                @endforeach
                                                                </ul>


                                                                <input type ="hidden" name="id" value="{{$project->id}}">
                                <button type="submit" style="margin:15px;" class="btn btn-success">Enregistrer</button>
                                <a href="/admin/project" style="margin:15px;" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
                            </form>
                        </div>
                  </div> 
                </div>
            </div>
        </section>




@endsection
@section('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js" integrity="sha256-JIBDRWRB0n67sjMusTy4xZ9L09V8BINF0nd/UUUOi48=" crossorigin="anonymous"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>

    <script type="text/javascript">
    	var uploadField = document.getElementById("image");

		uploadField.onchange = function() {
		    if(this.files[0].size > 1097152){
		       alert("Image très volumineuse, veuillez choisir une autre image");
		       this.value = "";
		    };
		};
var slider = document.getElementById("myRange");
var output = document.getElementById("textInput");
output.innerHTML =  "avancement réel : " + slider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
  output.innerHTML = "avancement réel : " + this.value + "%";
}

var form1 = document.getElementById("form");

if(parseInt(form1.collected.value) >= parseInt(form1.needed.value))

	// var element = document.getElementById(seekbar);
{
	console.log(" collected" + form1.collected.value);
	document.getElementById("myRange").disabled = false;
	 document.getElementById("myRange").required = true;
          // Hide

}else{
	console.log("not collected" + form1.collected.value);
	document.getElementById("myRange").disabled = true;
	         document.getElementById("myRange").required = false;
          //element.style.display = 'none';           // Hide
    }
 





    </script>
@endsection

