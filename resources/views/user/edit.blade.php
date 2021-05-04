@extends('backpack::layout')
@section('before_styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />
@endsection
@section('title', 'Bénéficiaires')

@section('content')

        <section class="content-header">
            <h1>
            Utilisateurs
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Utilisateurs</li>
            </ol>
        </section>
        <section class="content">
           <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">Modifier un utilisateur</div>
                        <div class="box-body">
                            <form method="POST" action="/admin/utilisateur/update"  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                                               <div class="row">


<div class="form-group col-xs-4">
                                                                                <label>Email</label>

                                                                                <div class="input-group">
                                                                                <input required   name="email"
                       value="{{$user->email}}"   class="form-control"         type="email"
                                    >
                                                                               </div>

</div>
<div class="form-group col-xs-4">
                                                                                <label>Password</label>

                                                                                <div class="input-group">
                                                                                  <input   name="password"
class="form-control"                         value="" type="password"
                                    >
                                                                                </div>

</div>

                                                                               <div class="form-group col-xs-4">
                                                                                <label>Lastname</label>

                                                                                <div class="input-group">
										  <input class="form-control" required type="text" value="{{$user->lastname}}" name="lastname" >
                                                                                </div>
</div>
<div class="form-group col-xs-4">
                                                                                <label>Firstname</label>

                                                                                <div class="input-group">
                                                                                  <input class="form-control" required type="text"  name="firstname" value="{{$user->firstname}}"
                                    >
                                                                                </div>

</div>
                                    <div class="form-group col-xs-4">
                                                                                <label>city</label>
                                        <select name="city" class="form-control" required>

<!-- <option value="None" required >-- Select --</option>-->
                                                <option disabled selected value> -- Select -- </option>
                                                <option value="0">rabat</option>
                                                <option value="1">casablanca</option>
  </select>
                                                                        </div>

 <div class="form-group col-xs-4">
                                                                                <label>type</label>
                                        <select name="type" class="form-control" required>
			@if($user->type == '1')
                                               <!-- <option value="None" required >-- Select --</option>-->
                                                <option disabled value> -- Select -- </option>
                                                <option selected value="1">Sans Emploi</option>
						<option value="2">Employé</option>
			@else
<option disabled  value> -- Select -- </option>
                                                <option value="1">Sans Emploi</option>
                                                <option selected value="2">Employé</option>

@endif	
  </select>
                                                                        </div>
<input type ="hidden" name="id" value="{{$user->id}}">


</div>

<button type="submit" class="btn btn-success">Enregistrer</button>
</div></form>

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
 </script>
@endsection


