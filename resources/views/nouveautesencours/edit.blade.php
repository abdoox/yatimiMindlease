@extends('backpack::layout')
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
                        <div class="box-header">Ajouter un wall activité</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/nouveauteWalls/update"  enctype="multipart/form-data">
                                {{ csrf_field() }}

                             <div class="row"
                                                                style="text-align: center;
                                                                       vertical-align: middle;
                                                                        display: flex;
                                                                        flex-direction: column;
                                                                        justify-content: center;
                                                                        align-items: center;
                                                                        text-align: center;

                                                                        ">
                                                                        <!--    <div class="form-group col-xs-6">-->
                                                                                <div style="margin : 15px;">
                                                                                <!--<label>Image</label>-->
                                                                                <a href="{{url('uploads/'.$wallsAssoc->image)}}">
                                                                                        <img src="{{url('uploads/'.$wallsAssoc->image)}}" style="
                                                                                                          max-height: 25vh;
                                                                                                          width: 25vw;
                                                                                                          position: relative;

                                                                                                          border-radius: 5px;
                                                                                                          margin:20px;          ">
									    </a>
										<input type="hidden" value="{{$wallsAssoc->image}}" name="url">

										<input type="hidden" value="{{$wallsAssoc->type}}" name="type">
										<input type="hidden" value="{{$wallsAssoc->beneficiaire_id}}" name="id">
										                                                                                <input type="hidden" value="{{$wallsAssoc->id}}" name="idWall">

                                                                                <input type="file" accept="image/*, video/*" name="image"  id="image" class="form-control">
                                                                        </div>
                                                                        </div>
			
					<!--			<div class="row" 

			 style="text-align: center;
                                                                       vertical-align: middle;
                                                                        display: flex;
                                                                        flex-direction: column;
                                                                        justify-content: center;
                                                                        align-items: center;
                                                                        text-align: center;

                                                                        "
>
									
                                    <div class="form-group col-xs-12">
                                        
                                        <a href="{{url('uploads/'.$wallsAssoc->image)}}">
                                                                                        <img src="{{url('uploads/'.$wallsAssoc->image)}}" style="
                                                                                                          max-height: 25vh;
                                                                                                          width: 25vw;
                                                                                                          position: relative;

                                                                                                          border-radius: 5px;
                                                                                                          margin:20px;          ">
									    </a>
				<label>Image</label>
							      <input type="file" accept="image/*, video/*" name="image" value="" id="image" class="form-control" >
                                    </div>
								</div>-->

<div class="row">							<div class="form-group col-xs-12">
                                                                                <label>Title</label>
                                                                                <input type="text" name="title" value="{{$wallsAssoc->title}}" required class="form-control">
                                                                        </div>
                                    <div class="form-group col-xs-12">
					<label>Description</label>
					<textarea name="description"  class="form-control" > {{$wallsAssoc->description}}</textarea>
                                        <!--<input type="text" name="description" value="{{$wallsAssoc->description}}" required class="form-control">-->
                                    </div>
	
							
                                <input type ="hidden" name="language_id" value="2">
                                <button style="margin:15px" type="submit" class="btn btn-success">Enregistrer</button>
                                <a href="/admin/nouveautesencours" class="btn btn-default"><span class="fa fa-ban"></span> Annuler</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
@section('after_scripts')
@endsection
