@extends('backpack::layout')

@section('title', 'Prise en charge')

@section('content')


        <section class="content-header">





            <h1>
            Prise en charge 
                
            </h1>
<ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Prise en charge</li>
            </ol>

        </section>

 <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">Modifier un parrainage</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/prise_en_charge/update"  enctype="multipart/form-data">
				{{ csrf_field() }}
					<div class="row">

                                                <div class="form-group col-xs-4">
                                                                                <label>Identifiant du bénéficiaire</label>
                                        <input type="number" name="beneficiaire_id"  value="{{$beneficiaireUser->beneficiaire_id}}"  min="1" required class="form-control">
                                                                        </div>

					


                                                <div class="form-group col-xs-4">
                                                                                <label>Email du parrain</label>
                                        <input type="email" value="{{$email}}" name="email"  required class="form-control">
                                                                        </div>


                                                <div class="form-group col-xs-4">
                                                                                <label>Montant</label>
                                        <input type="number" min="250" value="{{$beneficiaireUser->montant}}" name="montant"  required class="form-control">
                                                                        </div>
	
                                                                
	 <div class="form-group col-xs-4">
                                                                                <label>Statut</label>
                                        <select name="status" class="form-control" required>
						
						@if($beneficiaireUser->status =="validé")
    <option selected value="validé">Validé</option>
    <option value="terminé">Terminé</option>

    @else

        <option  value="validé">Validé</option>
    <option selected value="terminé">Terminé</option>
       @endif

                                             </select>
									</div>


		<div class="form-group col-xs-4">
                                                                                <label>Type</label>
                                        <select name="type" class="form-control" required>

						@if($beneficiaireUser->type =="0")
                                               <!-- <option value="None" required >-- Select --</option>-->
                                               
                                                <option value="0" selected >Complète</option>
                                                <option value="1">Partagée</option>
						
						@else
						 <option  value="0">Complète</option>
   						 <option selected value="1">Partagé</option>

						@endif
                                             </select>
                                                                        </div>

<input type="hidden" name="id" value="{{$id}}">


				
			<!--		<div class="inner_div" style="padding:10px">-->
						  <div class="form-group col-xs-4">
                                                                                <label>Date du prochain paiement</label>
                                                                                <div class="input-group date">
                                                                                  <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                  </div>
                                                                                <!-- <input required type="date" id="death_date" min="{{ now()->toDateString('Y-m-d') }}" name="date_fin"
                                    value="{{ \Carbon\Carbon::parse($beneficiaireUser->date_fin)->toDateString()}}"
				    >-->
									<input  type="date" id="death_date" required name="date_fin"
                                    value="{{ \Carbon\Carbon::parse($beneficiaireUser->date_fin)->toDateString()}}"
                                    >

	<!--</div>	-->							   </div></div></div>
                                   <button type="submit" class="btn btn-success">Enregistrer</button>
</div>
</div>
</div>
</form>							


</section>
@endsection
