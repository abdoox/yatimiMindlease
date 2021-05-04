@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')
     <a  style="margin : 20px;"  href="news/create" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter nouveauté </span></a>
        <section class="content-header">
            <h1>
            Nouveautés
                
            </h1>
            
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">

						   

                        <div class="box-body" style="overflow-x:auto;">
                            <table id="pageTable"  class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>titre</th>
                                        <th>détails</th>
                                        <th>média</th>
                                       
					<th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($news as $beneficiaire)
                                    <tr>
                                        <td style="min-width:100px">
                                            {{ $beneficiaire->title }}
                                        </td>
					
										<td >
			<div style="height: 2.5em; /* adjust to taste */
    overflow: hidden">
{{ $beneficiaire->detail }}
			</div>
		
                                        </td>
										<td>
				


						                                          
                                                                                                                                                           
						 @if ($beneficiaire->type == 'image')
							 <a href="{{url('uploads/'.$beneficiaire->image)}}">
                                                                                        <img src="{{url('uploads/'.$beneficiaire->image)}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
									    </a>
						 @elseif ($beneficiaire->type == 'video')

                                                                                <a href="{{url('uploads/'.$beneficiaire->image)}}">


                                                                <img src="{{url('uploads/videoimage.png')}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
                                                                            </a>
                                                @endif

										
					</td>
                                        <td>
                                            <a href="/admin/news/edit/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
					    <!--<a onclick="" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>-->
					    <a href="/admin/news/delete/{{ $beneficiaire->id }}" onclick="return confirm('Are you sure you want to delete?')" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
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
