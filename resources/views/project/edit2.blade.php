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
                        <div class="box-body">
                            <form method="POST" action="/admin/project/update"  enctype="multipart/form-data">
                                {{ csrf_field() }}
								<div class="row">



							

                                    <div class="form-group col-xs-4">
										<label>statut</label>
                                        <select name="status" class="form-control" required>

					       <!-- <option value="None" required >-- Select --</option>-->
						<option disabled selected value> -- Select -- </option>
                                                <option value="open">ouvert</option>
                                                <option value="closed">fermé</option>

                                             </select>
									</div>
									<div class="form-group col-xs-4">
										<label>référence</label>
										<input type="text" name="reference" value="{{$project->reference}}" required class="form-control">
									</div>

    <div class="form-group col-xs-6">
                                                                                <label>Image</label>
                                                                                <a href="{{url('uploads/'.$project->image)}}">
                                                                                        <img src="{{url('uploads/'.$project->image)}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                                                <input type="file" name="image" value="" id="image" class="form-control">
                                                                        </div>



</div>
	</div>
								<div style="padding:10px;" class="row">
									<div class="form-group col-xs-4">
										<label>needed</label>
										<input type="number" name="needed" value="{{$project->needed}}" required class="form-control">
									</div>

<div class="form-group col-xs-4">
                                                                                <label>collected</label>
                                                                                <input type="number" name="collected" value="{{$project->collected}}" required class="form-control">
                                                                        </div>

									<div class="form-group col-xs-4">
										<label>deadline</label>
										<div class="input-group date">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
										  <input type="date" id="death_date" name="deadline"
                                  value="{{$project->deadline}}" required
                                    >

                                       </div></div></div> 
                                    
					
                                <button style="margin:15px;" type="submit" class="btn btn-success">Enregistrer</button>
                                <a style="margin:15px;" href="/admin/project" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
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

