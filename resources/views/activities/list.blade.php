@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')






     <a  style="margin : 20px;"  href="activities/create" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter activité </span></a>
        <section class="content-header">
            <h1>
            Activités
           
            </h1>
           
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" style="overflow:auto;">
                        <div class="box-header with-border">

						   

                        <div class="box-body" style="overflow-x:auto;" >
                            <table id="pageTable"  class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Activité</th>
                                        <th>Description</th>
                                        <th>image</th>
                                        <th>Actions</th>
					
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($activities as $beneficiaire)
                                    <tr>
                                        <td>
                                            {{ $beneficiaire->titre }}
                                        </td>
					
										<td>
									<div style="height: 2.5em; /* adjust to taste */
    overflow: hidden">
{{ $beneficiaire->description }}
                                </div>        </td>
										<td>
						
								<a href="{{url('uploads/'.$beneficiaire->image)}}">
                                                                                        <img src="{{url('uploads/'.$beneficiaire->image)}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
										
					</td>

			
                                        <td>
                                            <a href="/admin/activities/edit/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
					    <a href="/admin/activities/delete/{{ $beneficiaire->id }}" onclick="return confirm('Supprimer cette activité ?')" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
					    <!--<a href="/admin/activities/benevoles/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-bars"></i> Bénévoles</a>-->
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>	
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

	<script src="{{ asset('js/toastr.min.js') }}"></script>

<script>
        @if(Session::has('message'))

                    toastr.success("{{ Session::get('message') }}");
        @endif
</script>

	<script type="text/javascript">

   

    jQuery(document).ready(function($) {
    //$(document).ready( function () {
        $('#pageTable').DataTable();
    });
    </script>
@endsection
