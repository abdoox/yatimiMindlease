@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')
     <a  style="margin : 30px;"  href="utilisateur/create" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter utilisateur </span></a>
        <section class="content-header">
            <h1>
            Utilisateurs
                
            </h1>
            
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
 <!--<a href="utilisateur/pdf2" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Generer fichier PDF</span></a>-->


						   <a href="utilisateur/excel2" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Générer fichier excel</span></a>
						

                                                   
                                                </div>


	<div class="box-body" style="overflow:auto;">
                            <table id="pageTable" class="table table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <!--<th>Image</th>-->
                                        <th>Nom</th>
                                        <th>Prénom</th>
					<th>Email</th>
					<th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($users as $beneficiaire)
                                    <tr>
                                        <td>
                                            {{ $beneficiaire->id }}
                                        </td>
										<!--
										<td>
											<a href="/uploads/{{$beneficiaire->image}}" target="_blank">
											  <img src="/uploads/{{$beneficiaire->image}}" style="
												  max-height: 50px;
												  width: 50px;
												  border-radius: 3px;">
											</a>
                                        </td>
                                        -->
										<td>
										{{$beneficiaire->lastname}}
                                        </td>
										<td>
									{{$beneficiaire->firstname}}
					</td>
					<td>
					{{$beneficiaire->email}}
					
					</td>
                                        <td>
                                            <a href="utilisateur/edit/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
					    <a href="notification/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class='fa fa-bell'></i></a>
					    <a href="utilisateur/delete/{{ $beneficiaire->id }}" onclick="return confirm('Supprimer cet utilisateur ?')" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

                                                 

           
@endsection
@section('after_scripts')
<!--
    <script src="{{ asset('js/script.js') }}"></script>
-->
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
    <script type="text/javascript">

    jQuery(document).ready(function($) {
    //$(document).ready( function () {
        $('#pageTable').DataTable();
    });
    </script>
@endsection
