@extends('backpack::layoutAssoc')

@section('title', 'Bénéficiaires')

@section('content')
   
	  <section class="content-header">
            <h1 style="text-align: center;">
	    {{$beneficiaire->first_name}} {{$beneficiaire->last_name}}
               
            </h1>
            
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                       <div class="box-header with-border">

	
				
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
                                                                                <a href="{{url('uploads/'.$beneficiaire->image)}}">
                                                                                        <img src="{{url('uploads/'.$beneficiaire->image)}}" style="
                                                                                                          max-height: 55vh;
                                                                                                          width: 25vw;
                                                                                                          position: relative;

                                                                                                          border-radius: 5px;
                                                                                                          margin:20px;          ">
                                                                            </a>
				</div>
			</div>
                                                  



			<div class="box-body" style="overflow:auto;"> 
			<h3 style="text-align:center;">Historique des parrainages annulés</h3>
				
                            <table id="pageTable"  class="table table-bordered table-hover"  >
                                <thead>
                                    <tr>
                                        <th>ID parrain</th>
                                        <!--<th>Image</th>-->
                                        <th>Email parrain</th>
					<th>Prénom</th>
					<th>Date de parrainage</th>
					<th>état</th>
					<th>Date d'annulation</th>
					<th>Motif d'annulation</th>
					
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($parrainages as $beneficiaire)
                                    <tr>
                                        <td>
                                            {{ $beneficiaire->user_id }}
					</td>


					<td>{{$beneficiaire->email}}</td>


					 <td>
					    {{ $beneficiaire->firstname }}
						                                            {{ $beneficiaire->lastname }}
                                        </td>

					<td>
                                            {{ $beneficiaire->created_at }}
                                        </td>

					<td>
						{{$beneficiaire->status}}
					</td>
					<td>
                                        @if ($beneficiaire->status != "validé")    {{ $beneficiaire->date_fin }} @else @endif
					</td>
					

					<td>
                                                                                    @if ($beneficiaire->status != "validé")    {{ $beneficiaire->motif }} @else @endif
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
