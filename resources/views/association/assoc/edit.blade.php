@extends('backpack::layoutAssoc')

@section('title', 'Bénéficiaires')

@section('content')
    
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
                        <div class="box-header">Modifier un bénéficiaire</div>
                        <div class="box-body">
                            <form method="POST" action="/association/beneficiaire/update"  enctype="multipart/form-data">
                                {{ csrf_field() }}
								<div class="row">
									<div class="form-group col-xs-4">
										<label>Date de naissance</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
										  <input type="date" id="death_date" name="birthday"
value="{{$beneficiaire->birthday}}"                               max="{{ now()->toDateString('Y-m-d') }}"    required
                                    >
									</div>
									</div>
									<div class="form-group col-xs-4">
										<label>Genre</label>
		
										<div class="input-group">
										@if($beneficiaire->sex == 'F')
										  <label class="radio-inline"><input type="radio" value="F" name="sex" checked>F</label>
										  <label class="radio-inline"><input type="radio" value="M" name="sex">M</label>
										@else
										  <label class="radio-inline"><input type="radio" value="F" name="sex" >F</label>
										  <label class="radio-inline"><input type="radio" value="M" name="sex" checked>M</label>
										@endif
										</div>
									</div>



<div class="form-group col-xs-4">
                                                                                <label>type</label>
                                        <select name="type" class="form-control" required>

                                                                           <option disabled selected value> -- Select -- </option>
   
	@if($beneficiaire->type == '0')
    <option selected value="0">Père décedé</option>
    <option value="1">Parents décedés</option>

    @else

	    <option value="0">Père décedé</option>
    <option selected value="1">Parents décedés</option>

	@endif
	    </select>

 </div>




									<div class="form-group col-xs-4">
										<label>Nombre de frères et soeurs</label>
										<input type="text" name="brothers_number" value="{{$beneficiaire->brothers_number}}" required class="form-control">
									</div>
								
							
<div class="form-group col-xs-4">

         <label>État de santé</label>

        <div class="input-group">

		@if($beneficiaire->handicape == '0')
           <label class="radio-inline"><input type="radio" value="0" name="handicape"  onclick="show1();" checked>Normal</label>

           <label class="radio-inline"><input type="radio" value="1" name="handicape"  onclick="show2();">Handicapé</label>
						    
		@else
			<label class="radio-inline"><input type="radio" value="0" name="handicape" onclick="show1();">Normal</label>

           <label class="radio-inline"><input type="radio" value="1" name="handicape" checked onclick="show2();">Handicapé</label>
		@endif
				</div>

    </div>
	@if($beneficiaire->handicape == '1')
<div id="div1" style="padding : 10px" class="row">
         <hr><div class="form-group col-xs-4">
                                                                                <label>Nom de maladie</label>

                                                                                <input type="text" name="nommaladie" value="{{$beneficiaireHandicape->handicape_title}}"  class="form-control">
                                                                        </div>
        <div class="form-group col-xs-4">
                                                                                <label>Description</label>

                                                                                <input type="text" name="descriptionmaladie" value="{{$beneficiaireHandicape->description}}"  class="form-control">
                                                                        </div>
        <div class="form-group col-xs-4">
                                                                                <label>prix médicaments</label>

                                                                                <input type="number" min="0" name="prixmedicaments" value="{{$beneficiaireHandicape->price}}"  class="form-control">
                                                                        </div>



		</div>
	@endif
</div>

	<div class="row">
									<div class="form-group col-xs-4">
										<label>Téléphone mère</label>
										<input type="text" name="mother_phone" value="{{$beneficiaire->mother_phone}}" required class="form-control">
									</div>
									<div class="form-group col-xs-4">
										<label>Date naissance père</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
	<input type="date" id="death_date" name="father_birthday"
value="{{$beneficiaire->father_birthday}}"                               max="{{ now()->toDateString('Y-m-d') }}"    required
                                    >

										</div>
									</div>
									<div class="form-group col-xs-4">
										<label>Date decès père</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
	<input type="date" id="death_date" name="death_date"
value="{{$beneficiaire->death_date}}"                               max="{{ now()->toDateString('Y-m-d') }}"    required
                                    >

										</div>
									</div>
			


	 <div class="form-group col-xs-4">
                                                                                <label>Date decès mère</label>
                                                                                <div class="input-group date">
                                                                                  <div class="input-group-addon">

                 <i class="fa fa-calendar"></i>

           </div>

           <input type="date" id="death_date" name="mother_death_date"
value="{{$beneficiaire->mother_death_date}}"                               max="{{ now()->toDateString('Y-m-d') }}"   
                                    >
                                                                </div>
                                    </div>





					</div>
								<div class="row">
									<div class="form-group col-xs-4">
										<label>Poids</label>
		
										<input type="text" name="weight" value="{{$beneficiaire->weight}}" required class="form-control">
									</div>
									<div class="form-group col-xs-4">
										<label>Taille</label>
		
										<input type="text" name="length" value="{{$beneficiaire->length}}" required class="form-control">
									</div>
									<div class="form-group col-xs-4">
										<label>Dernière note d'école</label>
		
										<input type="text" name="Last_school_note" value="{{$beneficiaire->Last_school_note}}" required class="form-control">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-xs-6">
										<label>Image</label>
										<a href="{{url('uploads/'.$beneficiaire->image)}}">
											<img src="{{url('uploads/'.$beneficiaire->image)}}" style="
													  max-height: 50px;
													  width: 50px;
													  border-radius: 3px;">
									    </a>
										<input type="file" name="image" value="" id="image" class="form-control">
									</div>

		

	
								</div>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Nom (fr) :</label>
											@php
												$b_last_name_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_last_name_fr = true
												@endphp
											<input type="text" name="last_name_fr" value="{{ $translate->last_name }}" required class="form-control">
											@endif @endforeach
											@if(!$b_last_name_fr)
												<input type="text" name="last_name_fr" value=""   required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Nom (ar) :</label>
											@php
												$b_last_name_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_last_name_ar = true
												@endphp
												<input type="text" name="last_name_ar" value="{{ $translate->last_name}}"  dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_last_name_ar)
												<input type="text" name="last_name_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Prénom (fr) :</label>
											@php
												$b_first_name_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_first_name_fr = true
												@endphp
												<input type="text" name="first_name_fr" value="{{ $translate->first_name }}"  required class="form-control">
											@endif @endforeach
											@if(!$b_first_name_fr)
												<input type="text" name="first_name_fr" value=""   required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Prénom (ar) :</label>
											@php
												$b_first_name_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_first_name_ar = true
												@endphp
												<input type="text" name="first_name_ar" value="{{ $translate->first_name }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_first_name_ar)
												<input type="text" name="first_name_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Nom du père  (fr) :</label>
											@php
												$b_father_name_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_father_name_fr = true
												@endphp
												<input type="text" name="father_name_fr" value="{{ $translate->father_name }}" required class="form-control">
											@endif @endforeach
											@if(!$b_father_name_fr)
												<input type="text" name="father_name_fr" value=""   required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Nom du père  (ar) :</label>
											@php
												$b_father_name_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_father_name_ar = true
												@endphp
												<input type="text" name="father_name_ar" value="{{ $translate->father_name }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_father_name_ar)
												<input type="text" name="father_name_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Nom de la mère  (fr) :</label>
											@php
												$b_mother_name_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_mother_name_fr = true
												@endphp
												<input type="text" name="mother_name_fr" value="{{ $translate->mother_name }}" required class="form-control">
											@endif @endforeach
											@if(!$b_mother_name_fr)
												<input type="text" name="mother_name_fr" value=""   required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Nom de la mère  (ar) :</label>
											@php
												$b_mother_name_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_mother_name_ar = true
												@endphp
												<input type="text" name="mother_name_ar" value="{{ $translate->mother_name }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_mother_name_ar)
												<input type="text" name="mother_name_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Loisir(fr) :</label>
											@php
												$b_leisure_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_leisure_fr = true
												@endphp
												<input type="text" name="leisure_fr" value="{{ $translate->leisure }}" required class="form-control">
											@endif @endforeach
											@if(!$b_leisure_fr)
												<input type="text" name="leisure_fr" value=""   required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Loisir (ar) :</label>
											@php
												$b_leisure_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_leisure_ar = true
												@endphp
												<input type="text" name="leisure_ar" value="{{ $translate->leisure }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_leisure_ar)
												<input type="text" name="leisure_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Adresse (fr) :</label>
											@php
												$b_address_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_address_fr = true
												@endphp
												<input type="text" name="address_fr" value="{{ $translate->address }}" required class="form-control">
											@endif @endforeach
											@if(!$b_address_fr)
												<input type="text" name="address_fr" value=""   required class="form-control">
											@endif										
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Adresse (ar) :</label>
			
											@php
												$b_address_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_address_ar = true
												@endphp
												<input type="text" name="address_ar" value="{{ $translate->address }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_address_ar)
												<input type="text" name="address_ar" value=""  dir="rtl" required class="form-control">
											@endif										
										</div>
										
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Biographie (fr) :</label>
											@php
												$b_biography_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_biography_fr = true
												@endphp
												<textarea type="textarea" name="biography_fr" value="{{ $translate->biography }}"required class="form-control">{{ $translate->biography }}</textarea>
											@endif @endforeach
											@if(!$b_biography_fr)
												<textarea type="textarea" name="biography_fr" value=""  required class="form-control"></textarea>
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Biographie (ar) :</label>
											@php
												$b_biography_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_biography_ar = true
												@endphp
												<textarea type="textarea" name="biography_ar" value="{{ $translate->biography }}" dir="rtl" required class="form-control">{{ $translate->biography }}</textarea>
												
											@endif @endforeach
											@if(!$b_biography_ar)
												<textarea type="textarea" name="biography_ar" value="" dir="rtl" required class="form-control"></textarea>
												
											@endif
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Niveau scolaire (fr) :</label>
											@php
												$b_school_level_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_school_level_fr = true
												@endphp
												<input type="text" name="school_level_fr" value="{{ $translate->school_level }}" required class="form-control">
											@endif @endforeach
											@if(!$b_school_level_fr)
												<input type="text" name="school_level_fr" value=""   required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Niveau scolaire (ar) :</label>
											@php
												$b_school_level_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_school_level_ar = true
												@endphp
												<input type="text" name="school_level_ar" value="{{ $translate->school_level }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_school_level_ar)
												<input type="text" name="school_level_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								</div>
																																							
											
											
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Rêver (fr) :</label>
											@php
												$b_dream_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_dream_fr = true
												@endphp
												<input type="text" name="dream_fr" value="{{ $translate->dream }}" required class="form-control">
											@endif @endforeach
											@if(!$b_dream_fr)
												<input type="text" name="dream_fr" value=""  required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Rêver (ar) :</label>
											@php
												$b_dream_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_dream_ar = true
												@endphp
												<input type="text" name="dream_ar" value="{{ $translate->dream }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_dream_ar)
												<input type="text" name="dream_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Age (fr) :</label>
											@php
												$b_age_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_age_fr = true
												@endphp
												<input type="text" name="age_fr" value="{{ $translate->age }}" required class="form-control">
											@endif @endforeach
											@if(!$b_age_fr)
												<input type="text" name="age_fr" value="" required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Age (ar) :</label>
											@php
												$b_age_ar = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_age_ar = true
												@endphp
												<input type="text" name="age_ar" value="{{ $translate->age }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_age_ar)
												<input type="text" name="age_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Dernière école (fr) :</label>
											@php
												$b_dream_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_dream_fr = true
												@endphp
												<input type="text" name="last_school_name_fr" value="{{ $translate->last_school_name }}" required class="form-control">
											@endif @endforeach
											@if(!$b_dream_fr)
												<input type="text" name="last_school_name_fr" value="" required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Dernière école (ar) :</label>
											@php
												$b_dream_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 2)
												@php
													$b_dream_fr = true
												@endphp
												<input type="text" name="last_school_name_ar" value="{{ $translate->last_school_name }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_dream_fr)
												<input type="text" name="last_school_name_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Type logement (fr) :</label>
											@php
												$b_dream_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)@if($translate->language_id == 1)
												@php
													$b_dream_fr = true
												@endphp
												<input type="text" name="house_type_fr" value="{{ $translate->house_type }}" required class="form-control">
											@endif @endforeach
											@if(!$b_dream_fr)
												<input type="text" name="house_type_fr" value="" required class="form-control">
											@endif
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group ">
											<label>Type logement (ar) :</label>
											@php
												$b_dream_fr = false
											@endphp
											@foreach ($beneficiaire->beneficiaire_translate as $translate)
												@if($translate->language_id == 2)
												@php
													$b_dream_fr = true
												@endphp
												<input type="text" name="house_type_ar" value="{{ $translate->house_type }}" dir="rtl" required class="form-control">
											@endif @endforeach
											@if(!$b_dream_fr)
												<input type="text" name="house_type_ar" value=""  dir="rtl" required class="form-control">
											@endif
										</div>
									</div>
								
																	


 <div class="row">
                                                                        <div class="col-md-6">

         <div class="form-group" style="padding:15px;">
                                                                                        <label>Prix logement :</label>

                 <input value="{{$beneficiaire->house_price}}" type="number" name="house_price" min="0" class="form-control">
                                                                                </div>
									</div>
</div>

<h3 style="padding:15px;">
                                                                        Baccalauréat / bourses
</h3>
<div class="row" style="padding:15px;">
		<div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Note Baccalauréat : </label>
                                                                                        
                                                                                        
											@if ($beneficiaireSuperieur != null)					
                                                                                        
                                                                                                <input type="number" step="0.01" name="noteBac" max="20.00" min="0.0"  value="{{ $beneficiaireSuperieur->noteBac }}" required class="form-control">
												@endif
											 @if ($beneficiaireSuperieur == null)

                                                                                                <input type="number" step="0.01" max="20.00" min="0.0" name="noteBac" value="" required class="form-control">
                                                                                                @endif


                                                                                                                                                                                                                                                   </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Charges financières des études : </label>
                                                                                                                                                                             
                                                                                        
                                                                                                                                                
                                                                                                @if ($beneficiaireSuperieur != null)

                                                                                                <input 	 name="charges" type="number" value="{{ $beneficiaireSuperieur->charges }}" required class="form-control">
                                                                                                @endif
                                                                                         @if ($beneficiaireSuperieur == null)

                                                                                                <input type="number" min ="0" name="charges" value="" required class="form-control">
                                                                                                @endif

                                                                                       
                                                                                       
                                                                                </div>
                                                                        </div>
									                                                                <p style="padding:15px;  font-weight: bold;  font-size: 13px;">*** Pour préciser les nom de l'école supérieure, veuillez modifier les 2 champs "Dernière école" en arabe et en français ***</p>
								</div>                                                                									                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
                                                                                        
                                                                                        


								<hr>
								<h3 style="padding:15px;">
									Liste des Images et des vidéos
									<a href="/association/create/image/{{$beneficiaire->id}}" class="btn btn-primary ladda-button pull-right" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter un média</span></a>
								</h3> 
								<ul class="list-group" style="padding:15px;">
								@foreach ($beneficiaire->images_beneficiaire as $image)
									<li class="list-group-item">


								@if ($image->type == 'image')
								<a href="{{url('uploads/'.$image->link)}}">
											<img src="{{url('uploads/'.$image->link)}}" style="
													  max-height: 70px;
													  width: 70px;
													  border-radius: 3px;">
									 </a>
                                                 @elseif ($image->type == 'video')

                                                                                <a href="{{url('uploads/'.$image->link)}}">


                                                                <img src="{{url('uploads/videoimage.png')}}" style="
                                                                                                          max-height: 70px;
                                                                                                          width: 70px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
			    
						@elseif ($image->type == 'audio')
                                                                            <a href="{{url('uploads/'.$image->link)}}">


                                                                <img src="{{url('uploads/audioo.png')}}" style="
                                                                                                          max-height: 70px;
                                                                                                          width: 70px;
                                                                                                          border-radius: 3px;">
                                                                            </a>

									    @endif








										<a href="/association/image/delete/{{ $image->id }}" class="btn btn-xs btn-default pull-right"><i class="fa fa-trash"></i> Supprimer</a>
									</li>
									
								@endforeach
								</ul>
								
								
								<hr>
								<h3 style="padding:15px;">
									Liste des activité Wall
									<a href="/association/create/wall/{{$beneficiaire->id}}" class="btn btn-primary ladda-button pull-right" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter une activité</span></a>
								</h3> 
								<ul class="list-group" style="padding:15px;">
								@foreach ($beneficiaire->walls_beneficiaire as $wall)
									<li class="list-group-item">
										<span>{{$wall->title}}</span><br/>
										 @if ($wall->type == 'image')
										<a href="{{url('uploads/'.$wall->image)}}">
										
										<img src="{{url('uploads/'.$wall->image)}}" style="
													  max-height: 70px;
													  width: 70px;
													  border-radius: 3px;">
									    </a>
										@elseif ($wall->type == 'video')

                                                                                <a href="{{url('uploads/'.$wall->image)}}">


                                                                <img src="{{url('uploads/videoimage.png')}}" style="
                                                                                                          max-height: 70px;
                                                                                                          width: 70px;
                                                                                                          border-radius: 3px;">
									    </a>
									    @elseif ($wall->type == 'audio')
									    <a href="{{url('uploads/'.$wall->image)}}">


                                                                <img src="{{url('uploads/audioo.png')}}" style="
                                                                                                          max-height: 70px;
                                                                                                          width: 70px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                @endif
										<a href="/association/wall/delete/{{ $wall->id }}" class="btn btn-xs btn-default pull-right"><i class="fa fa-trash"></i> Supprimer</a>
									</li>
									
								@endforeach
								</ul>
								
								
								<input type ="hidden" name="id" value="{{$beneficiaire->id}}">
                                <button style='margin:15px;' type="submit" class="btn btn-success">Enregistrer</button>
                                <a href="/beneficiairesAssoc" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
@section('adminlte_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script type="text/javascript">
    	var uploadField = document.getElementById("image");
		uploadField.onchange = function() {
		    if(this.files[0].size > 1097152){
		       alert("Image très volumineuse, veuillez choisir une autre image");
		       this.value = "";
		    };
		};

	function show1(){
  document.getElementById('div1').style.display ='none';
}

function show2(){
  document.getElementById('div1').style.display = 'block';
}

    </script>
@endsection
