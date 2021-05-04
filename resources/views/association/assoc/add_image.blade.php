@extends('backpack::layoutAssoc')
@section('before_styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection
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
                        <div class="box-header">Ajouter une image</div>
                        <div class="box-body">
                            <form method="POST" action="/association/image/store"  enctype="multipart/form-data">
                                {{ csrf_field() }}
								
								<div class="row">
									<div class="form-group col-xs-12">
										<label>Image</label>
		<input type="file" name="image" accept="video/mp4,video/x-m4v,video/*,image/*, audio/*" required class="form-control"/>
										
									</div>
								</div>
								
								<input type ="hidden" name="id" value="{{$id}}">
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                <a href="/association/beneficiaire/edit/{{$id}}}" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
@section('after_scripts')
@endsection
