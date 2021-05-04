@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')
     <a  style="margin : 20px;"  href="association/create" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter association </span></a>
        <section class="content-header">
            <h1>
            Associations
               
            </h1>
            
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">

						   

                        <div class="box-body"  style="overflow-x:auto;">
                            <table id="pageTable"  class="table table-bordered table-hover">
                                <thead>
				    <tr>
					<th>ID</th>
					<th>Nom</th>
					<th>Email</th>
					<th>Ville</th>
                                        <th>Adresse</th>
					<th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
				@foreach ($associations as $association)
					
                                    <tr>
                                        <td>
                                                                        {{ $association->id }}
                                        </td>

					
										<td>
									{{ $association->name }}
					</td>


 <td>
                                                                       
                                                                                              {{ $association->email }}
                                                                                                                                                 

					</td>

				<td>
                                            {{ $association->label }}
                                        </td>


										<td>                                                                                                                                                                                     {{ $association->address }}
                                                                                

	</td>
                                        <td>
					    <a href="/admin/association/edit/{{ $association->id }}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
					    <a href="/admin/association/delete/{{$association->id }}" onclick="return confirm('Supprimer cette association ?')" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
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
