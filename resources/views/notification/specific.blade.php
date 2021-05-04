@extends('backpack::layout')

@section('title', 'Notification')

@section('content')
    
        <section class="content-header">
            <h1>
                Notification
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Notification</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">Envoie push notification à un utilisateur</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/push/one"  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group col-xs-12">
                                    <label>Email de l'utilisateur</label>
                                    <input type="text" name="email" value="{{$user->email}}" required class="form-control">
                                  
                                </div>
                                <div class="form-group col-xs-12">
                                    <label>Titre</label>
    
                                    <input type="text" name="title" value="" required class="form-control">
                                </div>
                                <div class="form-group col-xs-12">
                                    <label>Description</label>
    
                                    <textarea class="form-control" name="description" required rows="3"></textarea>
                                </div>
                                
                                
                                <button type="submit" class="btn btn-success">Envoyer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
@section('adminlte_js')
    <script src="{{ asset('js/scripts.js') }}"></script>
@endsection
