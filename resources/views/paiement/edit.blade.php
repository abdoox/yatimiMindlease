@extends('backpack::layout')
@section('before_styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection
@section('title', 'Bénéficiaires')

@section('content')

        <section class="content-header">
            <h1>
            Paiements
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Paiements</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">Modifier un paiement</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/paiement/update"  enctype="multipart/form-data">
                                {{ csrf_field() }}
								<div class="row">



							

                                    <div class="form-group col-xs-4">
										<label>transaction</label>
                                        <input type="text" name="transaction_id" value="{{$paiement->transaction_id}}" required class="form-control">
									</div>
					

						
									<div class="form-group col-xs-4">
										<label>email</label>
									<input type="text" name="email" value="{{$paiement->email}}" required class="form-control">	
									</div>

    <div class="form-group col-xs-4">
                                                                                <label>Image</label>
                                                                                 <a href="{{url('uploads/paiements/'.$paiement->image)}}">
                                                                                        <img src="{{url('uploads/paiements/'.$paiement->image)}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                                                <input type="file"  name="image" value="" id="image" class="form-control">
                                    </div>                                    
								<div class="form-group col-xs-4">
                                                                                <label>montant</label>
                                        <input type="number" name="montant" value="{{$paiement->montant}}" min="0" required class="form-control">
									</div>
					
								<div class="form-group col-xs-4">
                                                                                <label>partner transaction</label>
                                        <input type="text" name="partner_transactionid" value="{{$paiement->partner_transactionid}}" required class="form-control">
									</div>


					<div class="form-group col-xs-4">
                                                                                <label>statut</label>
                                        <select name="status" class="form-control" required>

                                              

                                                @if($paiement->status == 'approved')



                                                <option disabled  value> -- Select -- </option>
                                                <option selected value="approved">approuvé</option>
                                                <option value="inprogress">en cours</option>


                                                @else
                                                        <option disabled  value> -- Select -- </option>
                                                <option  value="approved">approuvé</option>
                                                <option selected value="inprogress">en cours</option>
                                                @endif

                                             </select>
                                                                        </div>



						<div class="form-group col-xs-4">
                                                                                <label>type</label>
                                        <select name="type" class="form-control" required>

                                               <!-- <option value="None" required >-- Select --</option>-->

                                                @if($paiement->type == 'facture')



                                                <option disabled  value> -- Select -- </option>
                                                <option selected value="facture">facture</option>
                                                <option value="carte">carte</option>


                                                @else
                                                        <option disabled  value> -- Select -- </option>
                                                <option  value="facture">facture</option>
                                                <option selected value="carte">carte</option>
                                                @endif

                                             </select>
                                                                        </div>



</div>
	

	<!--<div class="form-group col-xs-4">
                                                                                <label>date paiement</label>
                                                                                <div class="input-group date">
                                                                                  <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                  </div>
        <input type="date" id="death_date" name="date_paiement"
value="{{$paiement->date_paiement}}"                               max="{{ now()->toDateString('Y-m-d') }}"    required
                                    >

                                                                                </div>
                                                                        </div>
</div>-->
								 <input type ="hidden" name="id" value="{{$paiement->id}}">
                                <button type="submit" style="margin:15px;" class="btn btn-success">Enregistrer</button>
                                <a href="/admin/paiement" style="margin:15px;" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
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

