@extends('backpack::layout')
@section('before_styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection
@section('title', 'Bénéficiaires')

@section('content')

        <section class="content-header">
            <h1>
            Associations
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Associations</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">Modifier une association</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/association/update"  enctype="multipart/form-data">
                                {{ csrf_field() }}
								<div class="row">



							

                                    <div class="form-group col-xs-4">
										<label>Email</label>
                                        <input type="text" name="email" value="{{$association->email}}" required class="form-control">
									</div>
									<div class="form-group col-xs-4">
										<label>mot de passe</label>
										<input type="password" name="password" minlength="6"  class="form-control">
									</div>

    <div class="form-group col-xs-6">
                                                                                <label>Téléphone</label>
                                                                               
                                                                                <input type="text"  name="phone" value="{{$association->phone}}" id="phone" class="form-control">
                                                                        </div>



</div>
	</div>
<div class="row" style="padding:15px;">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Nom (fr) :</label>
                                                                                        @php
                                                                                                $b_dream_fr = false
                                                                                        @endphp
                                                                                        @foreach ($association->association_translate as $translate)@if($translate->language_id == 1)
                                                                                                @php
                                                                                                        $b_dream_fr = true
                                                                                                @endphp
                                                                                                <input type="text" name="name_fr" value="{{ $translate->name }}" required class="form-control">
                                                                                        @endif @endforeach
                                                                                        @if(!$b_dream_fr)
                                                                                                <input type="text" name="name_fr" value="" required class="form-control">
                                                                                        @endif
                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Nom (ar) :</label>
                                                                                        @php
                                                                                                $b_dream_fr = false
                                                                                        @endphp
                                                                                        @foreach ($association->association_translate as $translate)
                                                                                                @if($translate->language_id == 2)
                                                                                                @php
                                                                                                        $b_dream_fr = true
                                                                                                @endphp
                                                                                                <input type="text" name="name_ar" value="{{ $translate->name }}" dir="rtl" required class="form-control">
                                                                                        @endif @endforeach
                                                                                        @if(!$b_dream_fr)
                                                                                                <input type="text" name="name_ar" value=""  dir="rtl" required class="form-control">
                                                                                        @endif
                                                                                </div>
                                                                        </div>								
                                    
  <div class="row" style="padding:15px;">
                                                                        <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Adresse (fr) :</label>
                                                                                        @php
                                                                                                $b_dream_fr = false
                                                                                        @endphp
                                                                                        @foreach ($association->association_translate as $translate)@if($translate->language_id == 1)
                                                                                                @php
                                                                                                        $b_dream_fr = true
                                                                                                @endphp
                                                                                                <input type="text" name="address_fr" value="{{ $translate->address }}" required class="form-control">
                                                                                        @endif @endforeach
                                                                                        @if(!$b_dream_fr)
                                                                                                <input type="text" name="address_fr" value="" required class="form-control">
                                                                                        @endif
                                                                                </div>
                                                                        </div>

                                                                        <div class="col-md-6">
                                                                                <div class="form-group ">
                                                                                        <label>Adresse (ar) :</label>
                                                                                        @php
                                                                                                $b_dream_fr = false
                                                                                        @endphp
                                                                                        @foreach ($association->association_translate as $translate)
                                                                                                @if($translate->language_id == 2)
                                                                                                @php
                                                                                                        $b_dream_fr = true
                                                                                                @endphp
                                                                                                <input type="text" name="address_ar" value="{{ $translate->address }}" dir="rtl" required class="form-control">
                                                                                        @endif @endforeach
                                                                                        @if(!$b_dream_fr)
                                                                                                <input type="text" name="address_ar" value=""  dir="rtl" required class="form-control">
                                                                                        @endif
                                                                                </div>
                                                                        </div>
				</div>


	<div class="form-group col-xs-6">
                                                                                <label>Ville</label>
                                                                                <select name="ville" class="form-control">      		
                                                                                        @foreach ($cities as $citys)
                                                                                        <option value="{{$citys->id}}"  @if($association->city_id == $citys->id) selected="selected" @endif>{{$citys->label}}</option>
                                                                                        @endforeach
                                                                                </select>
									</div></div>
	<input type ="hidden" name="id" value="{{$association->id}}">
<button style="margin:15px;" type="submit" class="btn btn-success">Enregistrer</button>
                                <a style="margin:15px;" href="/admin/association" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>





@endsection
@section('after_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js" integrity="sha256-JIBDRWRB0n67sjMusTy4xZ9L09V8BINF0nd/UUUOi48=" crossorigin="anonymous"></script>
<script src="{{ asset('js/script.js') }}"></script>

    <script type="text/javascript">
    	var uploadField = document.getElementById("image");

		uploadField.onchange = function() {
		    if(this.files[0].size > 100097152){
		       alert("Image très volumineuse, veuillez choisir une autre image");
		       this.value = "";
		    };
		};
    </script>
@endsection

