@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')
     <a  style="margin : 20px;"  href="paiement/create" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter paiement </span></a>
	<a  style="margin : 20px;"  href="paiement/pdf" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Exporter PDF </span></a>
	<a  style="margin : 20px;"  href="paiement/excel" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Exporter Excel </span></a>
        <section class="content-header">
            <h1>
            Paiements
            </h1>
            
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">

						   

                        <div class="box-body" style="overflow-x:auto;">
                            <table id="pageTable" style="overflow-x:auto;" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>transaction</th>
                                        <th>montant</th>
					<th>date paiement</th>
					<th>email user</th>
					<th>type</th>
					<th>statut</th>
					<th>image</th>
					<th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($paiements as $beneficiaire)
                                    <tr>
                                        <td>
                                            {{ $beneficiaire->transaction_id }}
					</td>
					<td>
                                            {{ $beneficiaire->montant }}
                                        </td>
					<td>
                                            {{ $beneficiaire->date_paiement }}
					</td>

					<td>
                                            {{ $beneficiaire->email }}
                                        </td>
					
					<td >
			
					     {{ $beneficiaire->type }}
			
					</td>
					
					<td >

                                             {{ $beneficiaire->status }}

                                        </td>
					<td>
						 <a href="{{url('uploads/paiements/'.$beneficiaire->image)}}">
                                                                                        <img src="{{url('uploads/paiements/'.$beneficiaire->image)}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
										
					</td>
                                        <td>
                                            <a href="/admin/paiement/edit/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
					    <a href="/admin/paiement/delete/{{ $beneficiaire->id }}" onclick="return confirm('Supprimer ce paiement ?')" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
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
