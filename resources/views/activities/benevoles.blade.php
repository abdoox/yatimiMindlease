@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')
     
        <section class="content-header">
            <h1>
            Utilisateurs bénévoles pour le projet
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Utilisateurs bénévoles pour le projet</li>
            </ol>
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
 <!--<a href="utilisateur/pdf2" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Generer fichier PDF</span></a>-->

                                                   
                                                </div>


	<div class="box-body" style="overflow:auto;">
                            <table id="pageTable" class="table table-bordered table-hover display responsive nowrap dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <!--<th>Image</th>-->
                                        <th>Nom</th>
                                        <th>Prénom</th>
					<th>Email</th>
					<th>Montant</th>
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
                                            {{$beneficiaire->montant}}
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
