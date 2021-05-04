@extends('backpack::layout')

@section('title', 'Notification')

@section('content')
    
        <section class="content-header">
            <h1>
                Notification
                
            </h1>
            
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
                                    <input type="text" name="email" value="" required class="form-control">
                                    <!--
                                    <select name="user_id" style="width: 100%" class="form-control select2_field " tabindex="-1" aria-hidden="true">
                                        <option value="0">-- A TOUS --</option>
                                         @foreach ($users as $user)
                                            <option value="{{$user->id}}" >{{$user->email}}</option>
                                        @endforeach
                                    </select>
                                    -->
                                </div>
                                <div class="form-group col-xs-12">
                                    <label>Titre</label>
    
                                    <input type="text" name="title" value="" required class="form-control">
                                </div>
                                <div class="form-group col-xs-12">
                                    <label>Description</label>
    
                                    <textarea class="form-control" name="description" required rows="3"></textarea>
                                </div>
                                
                                

                                <button style="margin:15px;" type="submit" class="btn btn-success">Envoyer</button>
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
