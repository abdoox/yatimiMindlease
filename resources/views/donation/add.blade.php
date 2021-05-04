@extends('backpack::layout')
@section('before_styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection
@section('title', 'Bénéficiaires')

@section('content')

        <section class="content-header">
            <h1>
            Donations
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Donations</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">Ajouter une donation</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/donation/store"  enctype="multipart/form-data">
                                {{ csrf_field() }}
								<div class="row">



							

                                    <div class="form-group col-xs-4">
										<label>transaction</label>  <label>*</label>

					<input type="text" name="transaction_id"  required class="form-control">
									</div>

				
					<div class="form-group col-xs-4">
                                                                                <label>montant</label>  <label>*</label>

                                        <input type="number" name="montant"  min = "0" required class="form-control">
									</div>

				<div class="form-group col-xs-4">
                                                                                <label>email</label>  <label>*</label>

                                        <input type="email" name="email"  required class="form-control">
                                                                        </div>

                                                                                   
					 <div class="form-group col-xs-6">
                                                                                <label>projets</label>  <label>*</label>

                                                                                <select name="project_id" class="form-control">
                                                                                        <option value="0"> --- </option>
                                                                                        @foreach($projects as $project)
                                                                                        <option value="{{$project->id}}">{{$project->title}}</option>
                                                                                        @endforeach
                                                                                </select>
                                                                        </div>
                                                                            



</div>
	</div>
        <p style="margin:15px;" > <strong>( * ) : champ obligatoire. </strong></p>								
                                <button type="submit" style="margin:15px;" class="btn btn-success">Enregistrer</button>
                                <a href="/admin/news" style="margin:15px;" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<button style="margin:15px;" type="submit" class="btn btn-success">Enregistrer</button>
                                <a style="margin:15px;" href="/admin/news" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
                            </form>
                        </div>
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
		    if(this.files[0].size > 1097152){
		       alert("Image très volumineuse, veuillez choisir une autre image");
		       this.value = "";
		    };
		};
    </script>
@endsection

