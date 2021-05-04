@extends('backpack::layoutAssoc')
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


<!--		<section class="content" >
		<div class="box" style="padding:25px;">
 
                                                                <div class="row">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Nom :</label> <label>*</label>

                                                                                        <input type="text" name="nameResponsable" required class="form-control">
                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Prénom :</label> <label>*</label>

                                                                                        <input type="text" name="prenom_respo" value=""  required class="form-control">
                                                                                </div>
									</div>
 <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Téléphone :</label> <label>*</label>

                                                                                        <input type="text" pattern="(06|07)[0-9]{8}" class="form-control" id="phone" required name="telephone_respo" >

                                                                                </div>
                                                                        </div>
 <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Email :</label> <label>*</label>

                                                                                        <input type="email" name="email_respo" value=""  required class="form-control">
                                                                                </div>
                                                                        </div>
 <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Numéro CIN :</label> <label>*</label>

                                                                                        <input type="text" name="cin_respo" value="" required class="form-control">
                                                                                </div>
                                                                        </div>
 <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Image CIN :</label> <label>*</label>

                                                                                        <input type="file" accept='image/*' name="image_cin_respo" value="" id="image_cin_respo" required class="form-control">
                                                                                </div>
                                                                        </div>
 
 <div class="form-group col-xs-6">
                                                                                <label>Ville : </label> <label>*</label>
                                                                                <select required id="ville" name="ville_respo" class="form-control">
                                                                                        <option selected value="" disabled > - </option>
                                                                                        @foreach($villes as $ville)
                                                                                        <option value="{{$ville->id}}">{{$ville->label}}</option>
                                                                                        @endforeach
                                                                                </select>
                                                                        </div>

<div class="form-group col-xs-6">
                                                                                <label>Poste dans l'association : </label> <label>*</label>
                                                                                <select required id="postee" name="poste_respo" class="form-control">
                                                                                        <option selected value="" disabled > - </option>
                                                                                        @foreach($postes as $poste)
                                                                                        <option value="{{$poste->id}}">{{$poste->label}}</option>
                                                                                        @endforeach
                                                                                </select>
                                                                        </div>





                                                                </div>

	


</div>
		</section>
-->

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
			

                            <form method="POST" action="/association/beneficiaire/store"  enctype="multipart/form-data">
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
                                                                                <label>Acte de naissance</label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="acte_naissance" value="" id="acte_naissance" required class="form-control">
                                                                        </div>

 <div class="form-group col-xs-4">
                                                                                <label>CIN tuteur</label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="cin" value="" id="cin" required class="form-control">
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
                                        <!--<select onchange="showMe(this);" name="type" class="form-control" required>-->
                                        <select id="type" name="type" class="form-control" required>
					       <!-- <option value="None" required >-- Select --</option>-->
						<option disabled selected value=""> -- Select -- </option>
                                                <option value="0">Père décedé</option>
                                                <option value="1">Parents décedés</option>

                                             </select>
									</div>
									<div class="form-group col-xs-4">
										<label>Nombre de frères et soeurs</label> <label>*</label>
										<input type="number" id="brothers_number" name="brothers_number" required class="form-control">
									</div>

			 <div id="acte_naissance_freres_div" style="display: none;" class="form-group col-xs-4">
                                                                                <label>Acte de naissance frères/sœurs </label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="acte_naissance_freres" value="" id="acte_naissance_freres" required class="form-control">
                                                                        </div>
</div><div class="row">

 <div class="form-group col-xs-4">
                                                                                <label>État de santé</label>  <label>*</label>

        <div class="input-group">
                                                                                  <label class="radio-inline"><input id="normal" type="radio" required value="0" name="handicape" >Normal</label>
                                                                                  <label class="radio-inline"><input id="handicape" type="radio" required value="1" name="handicape" >Handicapé</label>
			
			
		</div>

			<!--<div class="red box">You have selected <strong>red radio button</strong> so i am here</div>
    <div class="green box">You have selected <strong>green radio button</strong> so i am here</div>
    <div class="blue box">You have selected <strong>blue radio button</strong> so i am here</div>-->

    </div>



	<div id="div1" style="display : none; padding : 10px" class="row">
         <hr><div class="form-group col-xs-4">
                                                                                <label>Nom de maladie</label> <label>*</label>

                                                                                <input type="text" id="nommaladie" name="nommaladie" value=""  class="form-control">
                                                                        </div>
        <div class="form-group col-xs-4">
                                                                                <label>Description</label> <label>*</label>

                                                                                <input type="text" id="descriptionmaladie" name="descriptionmaladie" value=""  class="form-control">
                                                                        </div>
        <div class="form-group col-xs-4">
                                                                                <label>prix médicaments</label> <label>*</label>

										<input type="number" min="0" id="prixmedicaments" name="prixmedicaments" value=""  class="form-control">
									</div>

	<div class="form-group col-xs-4">
                                                                                <label>Dossier médical</label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="dossier_medical" value="" id="dossier_medical" required class="form-control">
                                                                        </div>
<div class="form-group col-xs-4">
<label>Ordonnance</label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="ordonnance" value="" id="ordonnance" required class="form-control">
									</div>
<div class="form-group col-xs-4">
<label>Analyses</label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="analyses" value="" id="analyses" required class="form-control">
                                                                        </div>

	
</div></div>	
								<div class="row" >
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

				<div class="form-group col-xs-4">
                                                                                <label>Cértificat du décès du père</label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="certif_deces_pere" value="" id="certif_deces_pere" required class="form-control">
                                                                        </div>




				<div id="decesmere" style="display : none;" class="row">
				    <div  class="form-group col-xs-4"  >
										<label>Date decès mère</label> <label>*</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
										  <input type="date" id="mother_death_date" name="mother_death_date"
                               max="{{ now()->toDateString('Y-m-d') }}"     value="dd-mm-yyyy" 
                                    >
							</div>	</div>
					<div class="form-group col-xs-4" style="margin: 10px;">
                                                                                <label>Cértificat du décès de la mère</label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="certif_deces_mere" value="" id="certif_deces_mere" required class="form-control">
                                                                        </div>
</div>

                                    </div>

							
								<div class="row">
						

									<div class="col-md-4">
                                                                                
                                                                                        <label>Âge</label> <label>*</label>
                                                                                        <input type="number" id="age" name="age"  class="form-control">
                                                                                
                                                                                </div>

									<div class="form-group col-xs-4">
										<label>Poids</label> <label>*</label>

										<input type="text" name="weight" value="" required class="form-control">
									</div>
									<div class="form-group col-xs-4">
										<label>Taille</label> <label>*</label>

										<input type="text" name="length" value="" required class="form-control">
									</div>
									<!--<div class="form-group col-xs-4">
										<label>Dernière note d'école</label> <label>*</label>

										<input type="text" name="Last_school_note" value="" required class="form-control">
									</div>

									 <div class="form-group col-xs-4">
                                                                                <label>Cértificat de scolarité</label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="certif_scolarite" value="" id="certif_scolarite" required class="form-control">
                                                                        </div>
									<div class="form-group col-xs-4">
                                                                                <label>Dernier bulletin</label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="dernier_bulletin" value="" id="dernier_bulletin" required class="form-control">
                                                                        </div>-->
								</div>
								<div class="row">
									<div class="form-group col-xs-4">
										<label>Photo</label> <label>*</label>
										<input type="file" accept='image/*' name="image" value="" id="image" required class="form-control">
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

								<div class="row">
									<div class="form-group col-xs-6">
                                                                                <label>Niveau scolaire : </label> <label>*</label>
                                                                                <select required id="niveau_scolaire" name="niveau_scolaire" class="form-control">
                                                                                        <option selected value="" disabled > --- </option>
                                                                                        @foreach($niveau_scolaire as $niveau)
                                                                                        <option value="{{$niveau->id}}">{{$niveau->label}}</option>
                                                                                        @endforeach
                                                                                </select>
									</div>

									<div id="last_school_note_div" style="display:none;" class="form-group col-xs-6">
                                                                                <label>Dernière note d'école</label> <label>*</label>

                                                                                <input type="number" step="0.01" min="0" max="20" id="last_school_note" name="Last_school_note" value=""  class="form-control">
                                                                        </div>

                                                                         <div id="certif_scolarite_div" style="display:none;" class="form-group col-xs-6">
                                                                                <label>Cértificat de scolarité</label> <label>*</label>
                                                                        <input type="file" accept='image/*,application/pdf' name="certif_scolarite" value="" id="certif_scolarite"  class="form-control">
                                                                        </div>
                                                                        <div id="dernier_bulletin_div" style="display:none;" class="form-group col-xs-6">
                                                                                <label>Dernier bulletin</label> <label>*</label>
                                                                        <input type="file" accept='image/*,application/pdf' name="dernier_bulletin" value="" id="dernier_bulletin" class="form-control">
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
									<div style="display:none;" class="col-md-6" id="derniere_ecole_fr_div">
										<div class="form-group">
											<label>Dernière école (fr) :</label> <label>*</label>
											<input type="text" name="last_school_name_fr" value="" id="derniere_ecole_fr" class="form-control">
										</div>
									</div>

									<div style="display:none;" id="derniere_ecole_ar_div" class="col-md-6">
										<div class="form-group ">
											<label>Dernière école (ar) :</label> <label>*</label>
											<input type="text" name="last_school_name_ar" value="" dir="rtl" id="derniere_ecole_ar" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
						  <div class="form-group col-xs-6">
                                                                                <label>Type logement : </label> <label>*</label>
                                                                                <select required id="logement" name="logement" class="form-control">
                                                                                        <option selected value="" disabled> --- </option>
                                                                                        @foreach($logements as $logement)
                                                                                        <option value="{{$logement->id}}">{{$logement->label}}</option>
                                                                                        @endforeach
                                                                                </select>
                                                                        </div>

								
                               
									<div class="col-md-6" id = "prix_logement" style="display : none;">
										<div class="form-group">
											<label>Prix logement :</label>
											<input type="number" id="prix_logement_input" name="house_price"  class="form-control">
										</div>

										</div>
							 <div class="form-group col-xs-6">
                                                                                <label>Contrat justificatif du type de logement : </label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="contrat_logement" value="" id="contrat_logement" required class="form-control">
                                                                        </div>

				 <div class="form-group col-xs-6">
                                                                                <label>Cértificat de résidence : </label> <label>*</label>
                                                                                <input type="file" accept='image/*,application/pdf' name="certif_residence" value="" id="certif_residence" required class="form-control">
                                                                        </div>


								</div>
					<p> <strong>( * ) : champ obligatoire. </strong></p>
                                <!--<button type="submit" class="btn btn-success">Enregistrer</button>
                                <a href="/beneficiairesAssoc" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
			    </form>-->
			
                        </div>
                    </div>
                </div>
	    </div>

<section class="content-header">
            <h1>
            Informations responsable association
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Bénéficiaires</li>
            </ol>
        </section>

 <div class="box" style="padding:25px;">

                                                                <div class="row">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Nom :</label> <label>*</label>

                                                                                        <input type="text" name="nom_respo" required class="form-control">
                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Prénom :</label> <label>*</label>

                                                                                        <input type="text" name="prenom_respo" value=""  required class="form-control">
                                                                                </div>
                                                                        </div>
 <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Téléphone :</label> <label>*</label>

                                                                                        <input type="text" pattern="(06|07)[0-9]{8}" class="form-control" id="phone" required name="telephone_respo" >

                                                                                </div>
                                                                        </div>
 <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Email :</label> <label>*</label>

                                                                                        <input type="email" name="email_respo" value=""  required class="form-control">
                                                                                </div>
                                                                        </div>
 <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Numéro CIN :</label> <label>*</label>

                                                                                        <input type="text" name="cin_respo" value="" required class="form-control">
                                                                                </div>
                                                                        </div>
 <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Image CIN :</label> <label>*</label>

                                                                                        <input type="file" accept='image/*' name="image_cin_respo" value="" id="image_cin_respo" required class="form-control">
                                                                                </div>
                                                                        </div>

 <div class="form-group col-xs-6">
                                                                                <label>Ville : </label> <label>*</label>
                                                                                <select required id="ville" name="ville_respo" class="form-control">
                                                                                        <option selected value="" disabled > --- </option>
                                                                                        @foreach($villes as $ville)
                                                                                        <option value="{{$ville->id}}">{{$ville->label}}</option>
                                                                                        @endforeach
                                                                                </select>
                                                                        </div>

<div class="form-group col-xs-6">
                                                                                <label>Poste dans l'association : </label> <label>*</label>
                                                                                <select required id="postee" name="poste_respo" class="form-control">
                                                                                        <option selected value="" disabled > --- </option>
                                                                                        @foreach($postes as $poste)
                                                                                        <option value="{{$poste->id}}">{{$poste->label}}</option>
                                                                                        @endforeach
                                                                                </select>
                                                                        </div>





                                                                </div>




</div>





<button type="submit" class="btn btn-success">Enregistrer</button>
                                <a href="/beneficiairesAssoc" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
                            </form>


        </section>

@endsection
@section('after_scripts')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js" integrity="sha256-JIBDRWRB0n67sjMusTy4xZ9L09V8BINF0nd/UUUOi48=" crossorigin="anonymous"></script>
<script src="{{ asset('js/script.js') }}"></script>

    <script type="text/javascript">






$(function() {
    $('#decesmere').hide(); 
    $('#type').change(function(){
        if($('#type').val() == '1') {
		$('#decesmere').show();
	        $("#mother_death_date").prop('required',true);
	        $("#certif_deces_mere").prop('required',true);
        } else {
		$('#decesmere').hide(); 
		$("#certif_deces_mere").prop('required',false);
                $("#mother_death_date").prop('required',false);
        } 
    });


    $('#logement').change(function(){
        if($('#logement').val() == '1' || $('#logement').val() == '5') {
                $('#prix_logement').show();
                $("#prix_logement_input").prop('required',true);
                //$("#certif_deces_mere").prop('required',true);
        } else {
                $('#prix_logement').hide();
                $("#prix_logement_input").prop('required',false);
                //$("#mother_death_date").prop('required',false);
	}
	console.log("required :" + $("#prix_logement_input").prop('required'));
    });

     $('#niveau_scolaire').change(function(){
        if($('#niveau_scolaire').val() != '1') {
		$('#last_school_note_div').show();
		$('#certif_scolarite_div').show();
		$('#dernier_bulletin_div').show();
		$('#derniere_ecole_fr_div').show();
		$('#derniere_ecole_ar_div').show();

		$("#last_school_note").prop('required',true);
		$("#dernier_bulletin").prop('required',true);
		$("#derniere_ecole_fr").prop('required',true);
		$("#derniere_ecole_ar").prop('required',true);

                //$("#certif_deces_mere").prop('required',true);
        } else {
                $('#last_school_note_div').hide();
                $('#certif_scolarite_div').hide();
                $('#dernier_bulletin_div').hide();
                $('#derniere_ecole_fr_div').hide();
                $('#derniere_ecole_ar_div').hide();

                $("#last_school_note").prop('required',false);
                $("#dernier_bulletin").prop('required',false);
                $("#derniere_ecole_fr").prop('required',false);
                $("#derniere_ecole_ar").prop('required',false);
        }
        console.log("required :" + $("#prix_logement_input").prop('required'));
    });

    
    $('input[type=radio][name=handicape]').change(function() {
	    
	    if (this.value == '1') {

		        $('#div1').show();
	    		    $("#nommaladie").prop('required',true);	
	                    $("#descriptionmaladie").prop('required',true);
	                    $("#prixmedicaments").prop('required',true);
			    $("#dossier_medical").prop('required',true);
	                    $("#ordonnance").prop('required',true);		    
	                    $("#analyses").prop('required',true);
	   
	   
	    }else{
 			$('#div1').hide();
                            $("#nommaladie").prop('required',false);
                            $("#descriptionmaladie").prop('required',false);
                            $("#prixmedicaments").prop('required',false);
                            $("#dossier_medical").prop('required',false);
                            $("#ordonnance").prop('required',false);
                            $("#analyses").prop('required',false);


	    } 
    
    });



});

$("#brothers_number").focusout(function () {
   if ($('#brothers_number').val() != "0") {
     			  
	 		    $('#acte_naissance_freres_div').show();
                            $("#acte_naissance_freres").prop('required',true);
   }else{

			    $('#acte_naissance_freres_div').hide();
                            $("#acte_naissance_freres").prop('required',false);

   }
});




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

