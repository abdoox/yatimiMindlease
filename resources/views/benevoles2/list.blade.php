@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')
     
      

                          
                                      
	
                                        
                                       
                                        
     <section class="content-header">
            <h1>
            Bénévoles pour les activités  (Non inscrits)

                        </h1>
            
        </section>


        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box"  >


                        <div class="box-body" style="overflow:auto;">
                            <table id="pageTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <!--<th>Prénom</th>-->
                                        <th>Activité</th>
                                        <th>Temps libre</th>
                                 
					<th>téléphone</th>
					                                        <th>ville</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($activities2 as $beneficiaire)
                                    <tr>
                                       <!-- <td>
                                            {{ $beneficiaire->lastname }}
                                        </td>-->
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
                                                                                {{$beneficiaire->nom}}
                                        </td>
                                                                                <td>
                                                                                      <div style="height: 2.5em; /* adjust to taste */
    overflow: hidden">
{{ $beneficiaire->activites }}
                        </div>

                                        </td>


                                        <td>
                                           <!-- <div style="height: 2.5em; /* adjust to taste */
    overflow: hidden">-->
{{ $beneficiaire->freetime }}
                       <!-- </div>-->

                                        </td>
								 <td>
					
                                               

                                       {{ $beneficiaire->phone }}



                                        <td>
                                                {{ $beneficiaire->city }}

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
