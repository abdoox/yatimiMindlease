@extends('backpack::layoutAssoc')

@section('title', 'Bénéficiaires')

@section('content')
     <a  style="margin : 20px;"  href="association/beneficiaire/create" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter bénéficiaire </span></a>
        <section class="content-header">
            <h1>
            Bénéficiaires
               
            </h1>
            
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                       <div class="box-header with-border">

						   <a href="association/beneficiaire/excel3" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Générer fichier excel</span></a>

	        <p  style="font-size:20px;padding:25px;">Le nombre des orphelins non parrainés est <strong>{{$nbrNonParraineBen}}</strong>.</p>

	<!--				

                                                   <a href="beneficiaire/pdf" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Générer fichier PDF</span></a>
                                                </div>-->

                        <div class="box-body" style="overflow:auto;"> 
                            <table id="pageTable"  class="table table-bordered table-hover"  >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <!--<th>Image</th>-->
                                        <th>Nom</th>
					<th>Prénom</th>
					<th>Âge</th>
					<th>Ville</th>
					<th>Genre</th>
					<th>État de santé</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($beneficiaires as $beneficiaire)
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
										@foreach ($beneficiaire->beneficiaire_translate as $translate)
											@if($translate->language_id == 2) 
												{{ $translate->last_name }}
											@endif
										@endforeach
                                        </td>
										<td>
										@foreach ($beneficiaire->beneficiaire_translate as $translate)
											@if($translate->language_id == 2) 
												{{ $translate->first_name }}
											@endif
										@endforeach
                                        </td>
					
<td>
                                                                                @foreach ($beneficiaire->beneficiaire_translate as $translate)
                                                                                        


										@if ($translate->language_id == 2)
											
                                                                                                {{ $translate->age }} ans
												@endif	@endforeach </td>


												<td>

											{{$beneficiaire->label}}

										</td>
												<td>
                                                                                
                                                                                @if ($beneficiaire->sex == 'M')
                                                                                               Garçon
										@else Fille	
                                                                                                @endif  </td>

										<td>

                                                                                @if ($beneficiaire->handicape == 1)
                                                                                               Handicapé
                                                                                @else Normal
                                                                                                @endif  </td>





						<td>
                                            <a href="/association/beneficiaire/edit/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                            <a href="/association/beneficiaire/delete/{{ $beneficiaire->id }}"  onclick="return confirm('Supprimer ce bénéficiaire ?')" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
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
