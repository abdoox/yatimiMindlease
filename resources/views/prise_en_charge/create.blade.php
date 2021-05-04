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
                        <div class="box-header">Ajouter un parrainage</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/prise_en_charge/store"  enctype="multipart/form-data">
                                {{ csrf_field() }}
							       <div class="row">

						<div class="form-group col-xs-4">
                                                                                <label>Identifiant du bénéficiaire</label> <label>*</label>
                                        <input type="number" name="beneficiaire_id" min="1" required class="form-control">
									</div>


						
						<div class="form-group col-xs-4">
                                                                                <label>Email du parrain</label>  <label>*</label>
                                        <input type="email" name="email"  required class="form-control">
									</div>


						<div class="form-group col-xs-4">
                                                                                <label>Montant</label>  <label>*</label>
                                        <input type="number" min="250"  name="montant"  required class="form-control">
									</div>



				









<!--
                                                                        <div class="form-group col-xs-4">
                                                                                <label>Identifiant du bénéficiaire</label>


                                                                                 <input required type="number"  min="1" name="beneficiaire_id"
                                    value=""
                                    >                                                                           </div>


                                                                        <div class="form-group col-xs-4">
                                                                                <label>email du parrain</label>

                                                                                <div class="input-group">
                                                                                  <input required type="text"  name="email"
        type=email                            value=""
                                    >
                                                                               </div> </div>

                                <div class="form-group col-xs-4">
                                                                                <label>Montant</label>



                                                                                 <input required   name="montant"
             type=number min="250"                       value=""
                                    >                                                                           </div>

	-->	
         <div class="form-group col-xs-4">
                                                                                <label>Type</label>  <label>*</label>
                                        <select name="type" class="form-control" required>

                                               <!-- <option value="None" required >-- Select --</option>-->
                                                <option disabled selected value> -- Select -- </option>
 <option value="0">complète</option>
                                                <option value="1">partagée</option>

                                             </select>
                                                                        </div>


  
				<!-- class="row">-->

				

                                        <div class="inner_div" style="padding:10px">
                                                  <div class="form-group col-xs-4">
                                                                                <label>Date du prochain paiement</label>  <label>*</label>
                                                                                <div class="input-group date">
                                                                                  <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                  </div>
<input required type="date" id="death_date" min="{{ now()->toDateString('Y-m-d') }}" name="date_fin"
                                    value="dd-mm-yyyy"
                                    >
</div></div></div>
	    </div>                
	<p style="margin:15px;" > <strong>( * ) : champ obligatoire. </strong></p>				   
                                   <button type="submit" class="btn btn-success">Enregistrer</button>
</div>
</div>
</div>
</form> 
<!--</div></div>-->

</section>
@endsection                                 			                                                        
