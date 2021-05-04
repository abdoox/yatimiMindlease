@extends('backpack::layout')
@section('before_styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection
@section('title', 'Bénéficiaires')

@section('content')
<!--<style>
    .box{
        color: #fff;
        padding: 20px;
        display: none;
        margin-top: 20px;
    }
    .red{ background: #ff0000; }
    .green{ background: #228B22; }
    .blue{ background: #0000ff; }
</style>-->

        <section class="content-header">
            <h1>
            Bénéficiaires
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Bénéficiaires</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">Ajouter un bénéficiaire</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/beneficiaire/store"  enctype="multipart/form-data">
                                {{ csrf_field() }}
								<div class="row">
									<div class="form-group col-xs-4">
										<label>Date de naissance</label> <label> *</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
										 <input required type="date" id="death_date" max="{{ now()->toDateString('Y-m-d') }}" name="birthday"
                                    value="dd-mm-yyyy"
                                    >										</div>
                                    </div>

									<div class="form-group col-xs-4">
										<label>Genre</label>  <label>*</label>

										<div class="input-group">
										  <label class="radio-inline"><input type="radio" required value="F" name="sex">F</label>
										  <label class="radio-inline"><input type="radio" value="M" name="sex">M</label>
										</div>
                                    </div>

                                    <div class="form-group col-xs-4">
										<label>type</label>  <label>*</label>
                                        <select onchange="showMe(this);" name="type" class="form-control" required>

					       <!-- <option value="None" required >-- Select --</option>-->
						<option disabled selected value=""> -- Select -- </option>
                                                <option value="0">Père décedé</option>
                                                <option value="1">Parents décedés</option>

                                             </select>
									</div>
									<div class="form-group col-xs-4">
										<label>Nombre de frères et soeurs</label> <label>*</label>
										<input type="number" name="brothers_number" required class="form-control">
									</div>

 <div class="form-group col-xs-4">
                                                                                <label>État de santé</label>  <label>*</label>

        <div class="input-group">
                                                                                  <label class="radio-inline"><input type="radio" required value="0" name="handicape" onclick="show1();">Normal</label>
                                                                                  <label class="radio-inline"><input type="radio" required value="1" name="handicape" onclick="show2();">Handicapé</label>
			
			
		</div>

			<!--<div class="red box">You have selected <strong>red radio button</strong> so i am here</div>
    <div class="green box">You have selected <strong>green radio button</strong> so i am here</div>
    <div class="blue box">You have selected <strong>blue radio button</strong> so i am here</div>-->

    </div>

	<div id="div1" style="display : none; padding : 10px" class="row">
         <hr><div class="form-group col-xs-4">
                                                                                <label>Nom de maladie</label> <label>*</label>

                                                                                <input type="text" name="nommaladie" value=""  class="form-control">
                                                                        </div>
        <div class="form-group col-xs-4">
                                                                                <label>Description</label> <label>*</label>

                                                                                <input type="text" name="descriptionmaladie" value=""  class="form-control">
                                                                        </div>
        <div class="form-group col-xs-4">
                                                                                <label>prix médicaments</label> <label>*</label>

                                                                                <input type="number" min="0" name="prixmedicaments" value=""  class="form-control">
                                                                        </div>



                </div>
	

	</div>
	 	
								<div class="row">
									<div class="form-group col-xs-4">
										<label>Téléphone mère</label> <label>*</label>
										<input type="text" name="mother_phone" value="" required class="form-control">
									</div>
									<div class="form-group col-xs-4">
										<label>Date naissance père</label> <label>*</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
										  <input type="date" id="death_date" name="father_birthday"
                                max="{{ now()->toDateString('Y-m-d') }}"    value="dd-mm-yyyy" required
                                    >

                                        </div>

                                    </div>


									<div class="form-group col-xs-4">
										<label>Date decès père</label> <label>*</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
                                          </div>

				    <input type="date" id="death_date" name="death_date"
max="{{ now()->toDateString('Y-m-d') }}"
                                    value="dd-mm-yyyy" required
                                    >
										 <!-- <input type="text" class="form-control pull-right"  name="death_date" required id="datepicker2">-->
										</div>
                                    </div>

				    <div id="decesmere" class="form-group col-xs-4" style="display : none;" >
										<label>Date decès mère</label> <label>*</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
										  <input type="date" id="death_date" name="mother_death_date"
                               max="{{ now()->toDateString('Y-m-d') }}"     value="dd-mm-yyyy" 
                                    >
								</div>
                                    </div>

								</div>
								<div class="row">
									<div class="form-group col-xs-4">
										<label>Poids</label> <label>*</label>

										<input type="text" name="weight" value="" required class="form-control">
									</div>
									<div class="form-group col-xs-4">
										<label>Taille</label> <label>*</label>

										<input type="text" name="length" value="" required class="form-control">
									</div>
									<div class="form-group col-xs-4">
										<label>Dernière note d'école</label> <label>*</label>

										<input type="text" name="Last_school_note" value="" required class="form-control">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-xs-6">
										<label>Photo</label> <label>*</label>
										<input type="file" accept='image/*' name="image" value="" id="image" required class="form-control">
									</div>
									<div class="form-group col-xs-6">
										<label>Association</label> <label>*</label>
										<select required name="association_id" class="form-control">
											<option selected value="" disabled> --- </option>
											@foreach($associations as $association)
											<option value="{{$association->id}}">{{$association->name}}</option>
											@endforeach
										</select>
									</div>
								


	<div class="form-group col-xs-6">
                                                                                <label>Ville</label> <label>*</label>
                                                                                <select required name="city_id" class="form-control">
                                                                                        <option selected value="" disabled> --- </option>
                                                                                        @foreach($cities as $association)
                                                                                        <option value="{{$association->id}}">{{$association->label}}</option>
                                                                                        @endforeach
                                                                                </select>
                                                                        </div>
</div>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Nom (fr) :</label> <label>*</label>

											<input type="text" name="last_name_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Nom (ar) :</label> <label>*</label>

											<input type="text" name="last_name_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Prénom (fr) :</label> <label>*</label>

											<input type="text" name="first_name_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Prénom (ar) :</label> <label>*</label>

											<input type="text" name="first_name_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Nom du père  (fr) :</label> <label>*</label>

											<input type="text" name="father_name_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Nom du père (ar) :</label> <label>*</label>

											<input type="text" name="father_name_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Nom de la mère(fr) :</label> <label>*</label>

											<input type="text" name="mother_name_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Nom de la mère (ar) :</label> <label>*</label>

											<input type="text" name="mother_name_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Loisir(fr) :</label> <label>*</label>

											<input type="text" name="leisure_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Loisir (ar) :</label> <label>*</label>

											<input type="text" name="leisure_ar" value="" required dir="rtl" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Adresse (fr) :</label> <label>*</label>

											<input type="text" name="address_fr" value=""  required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Adresse (ar) :</label> <label>*</label>

											<input type="text" name="address_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Biographie (fr) :</label> <label>*</label>

											<textarea type="textarea" name="biography_fr" value="" required class="form-control"></textarea>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Biographie (ar) :</label> <label>*</label>

											<textarea type="textarea" name="biography_ar" value="" required class="form-control"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Niveau scolaire (fr) :</label> <label>*</label>

											<input type="text" name="school_level_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Niveau scolaire (ar) :</label> <label>*</label>

											<input type="text" name="school_level_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Rêver (fr) :</label> <label>*</label>

											<input type="text" name="dream_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Rêver (ar) :</label> <label>*</label>

											<input type="text" name="dream_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>
								<!--<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Age (fr) :</label>

											<input type="text" name="age_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Age (ar) :</label>

											<input type="text" name="age_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Dernière école (fr) :</label> <label>*</label>
											<input type="text" name="last_school_name_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Dernière école (ar) :</label> <label>*</label>
											<input type="text" name="last_school_name_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Type logement (fr) :</label> <label>*</label>
											<input type="text" name="house_type_fr" value="" required class="form-control">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group ">
											<label>Type logement (ar) :</label> <label>*</label>
											<input type="text" name="house_type_ar" value="" dir="rtl" required class="form-control">
										</div>
									</div>
								</div>
                                <div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Prix logement :</label>
											<input type="number" name="house_price"  class="form-control">
										</div>
									</div>


								</div>
					<p> <strong>( * ) : champ obligatoire. </strong></p>
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                <a href="/admin/beneficiaire" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
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

    <script type="text/javascript">
    	var uploadField = document.getElementById("image");

		uploadField.onchange = function() {
		    if(this.files[0].size > 1097152){
		       alert("Image très volumineuse, veuillez choisir une autre image");
		       this.value = "";
		    };
		};
function showMe(e) {
    var strdisplay = e.options[e.selectedIndex].value;
    var e = document.getElementById("decesmere");
    if(strdisplay == "0") {
	    e.style.display = "none";
		document.getElementById("decesmere").required = false;

    }
    else{
	    document.getElementById("decesmere").required = true;

        e.style.display = "block";
    }
}


function show1(){
	document.getElementById("nommaladie").required = false;
	document.getElementById("descriptionmaladie").required = false;
	document.getElementById("prixmedicaments").required = false;

  document.getElementById('div1').style.display ='none';
}

function show2(){
	document.getElementById("nommaladie").required = true;
        document.getElementById("descriptionmaladie").required = true;
        document.getElementById("prixmedicaments").required = true;

  	document.getElementById('div1').style.display = 'block';
}



	/*$(document).ready(function () {

    $('input[type="radio"]').click(function () {
        if ($(this).attr("value") == "Normal") {
            $(".Box").hide('slow');
        }
        if ($(this).attr("value") == "Handicapé") {
            $(".Box").show('slow');

        }
    });*/

	





    </script>
@endsection

