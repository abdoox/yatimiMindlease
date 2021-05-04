@extends('backpack::layout')
@section('before_styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection
@section('title', 'Bénéficiaires')

@section('content')

        <section class="content-header">
            <h1>
            Activités
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Activités</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
			<div class="box-header">
Modifier une activité</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/activities/update"  enctype="multipart/form-data">
                                {{ csrf_field() }}
								<div class="row"  style="text-align: center;
                                                                       vertical-align: middle;
                                                                        display: flex;
                                                                        flex-direction: column;
                                                                        justify-content: center;
                                                                        align-items: center;
                                                                        text-align: center;

                                                                        ">



							

                                    <!--<div class="form-group col-xs-4">
										<label>statut</label>
                                        <select name="status" class="form-control" required>

					      
						<option disabled selected value> -- Select -- </option>
                                                <option value="open">ouvert</option>
                                                <option value="closed">fermé</option>

                                             </select>
									</div>
									<div class="form-group col-xs-4">
										<label>référence</label>
										<input type="text" name="reference" required class="form-control">
									</div>-->

   <input type="hidden" name="id" value="{{$activity->id}}"/> 
<div class="form-group col-xs-6">
                                                                                
                                                                                <a href="{{url('uploads/'.$activity->image)}}">
                                                                                        <img src="{{url('uploads/'.$activity->image)}}" style="
                                                                                                          max-height: 30vh;
                                                                                                          width: 30vw;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                                                <input type="file" accept="image/*" name="image" value="" id="image" class="form-control">
                                                                        </div>


</div>
	</div>
								<!--<div style="padding:10px;" class="row">
									<div class="form-group col-xs-4">
										<label>needed</label>
										<input type="number" name="needed" value="" required class="form-control">
									</div>

<div class="form-group col-xs-4">
                                                                                <label>collected</label>
                                                                                <input type="number" name="collected" value="" required class="form-control">
                                                                        </div>

									<div class="form-group col-xs-4">
										<label>deadline</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
										  <input type="date" id="death_date" name="deadline"
                                  value="dd-mm-yyyy" required
                                    >

                                        </div>

                                    </div>-->


									

                                    
								<div class="row" style="padding:15px;">
									

								<div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Titre (fr) :</label>
                                                                                        @php
                                                                                                $b_title_fr = false
                                                                                        @endphp
                                                                                        @foreach ($activity->activity_translate as $translate)@if($translate->language_id == 1)
                                                                                                @php
                                                                                                        $b_title_fr = true
                                                                                                @endphp
                                                                                        <input type="text" name="title_fr" value="{{ $translate->titre }}" required class="form-control">
                                                                                        @endif @endforeach
                                                                                        @if(!$b_title_fr)
                                                                                                <input type="text" name="title_fr" value=""   required class="form-control">
                                                                                        @endif
                                                                                </div>
                                                                        </div>


									<div class="col-md-6">
                                                                                <div class="form-group">
                                                                                        <label>Titre (ar) :</label>
                                                                                        @php
                                                                                                $b_title_ar = false
                                                                                        @endphp
                                                                                        @foreach ($activity->activity_translate as $translate)@if($translate->language_id == 2)
                                                                                                @php
                                                                                                        $b_title_ar = true
                                                                                                @endphp
                                                                                        <input type="text" name="title_ar" value="{{ $translate->titre }}" required class="form-control">
                                                                                        @endif @endforeach
                                                                                        @if(!$b_title_ar)
                                                                                                <input type="text" name="title_ar" value=""   required class="form-control">
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
                                                                                        @foreach ($activity->activity_translate as $translate)@if($translate->language_id == 1)
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
                                                                                        @foreach ($activity->activity_translate as $translate)@if($translate->language_id == 2)
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

								 <div class="form-group col-xs-4">
                                                                                <label>date</label>
                                                                                <div class="input-group date">
                                                                                  <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                  </div>
                                                                                  <input type="date" id="death_date" name="date"
                                  value="{{$activity->date}}" required
                                    >

                                        </div>



							</div>	
</div>

<hr>
                                                                <h3 style="padding:15px;">
                                                                        Liste des Images et des vidéos
                                                                        <a href="/admin/createActivity/media/{{$activity->id}}" class="btn btn-primary ladda-button pull-right" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter un média</span></a>
                                                                </h3>
                                                                <ul class="list-group">
                                                                @foreach ($activity->activity_media as $image)
                                                                        <li class="list-group-item">

 @if ($image->type == 'image')
                                                         <a href="{{url('uploads/'.$image->url)}}">
                                                                                        <img src="{{url('uploads/'.$image->url)}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                 @elseif ($image->type == 'video')

                                                                                <a href="{{url('uploads/'.$image->url)}}">


                                                                <img src="{{url('uploads/videoimage.png')}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                @endif




                                                                                <a href="/admin/mediaActivity/delete/{{ $image->id }}" class="btn btn-xs btn-default pull-right"><i class="fa fa-trash"></i> Supprimer</a>
                                                                        </li>

                                                                @endforeach
                                                                </ul>
					
                                <button style="margin:15px;" type="submit" class="btn btn-success">Enregistrer</button>
                                <a style="margin:15px;" href="/admin/activities" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
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
    </script>
@endsection

