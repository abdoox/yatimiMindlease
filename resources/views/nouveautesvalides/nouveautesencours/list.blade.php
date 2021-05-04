@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')
     
        <section class="content-header">
            <h1>
            Activités wall en attente
                
            </h1>
          
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">

				<!--		   <a href="beneficiaire/excel3" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Générer fichier excel</span></a>
					

                                                   <a href="beneficiaire/pdf3" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Générer fichier PDF</span></a>-->
                                                </div>

                        <div class="box-body" style="overflow:auto;">
                            <table id="pageTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID bénéficiaire</th>
                                        <th>Média</th>
                                        <th>Nom</th>
					<th>Prénom</th>
					 <th>Âge</th>
                                        
                                        <th>Genre</th>
					<th>État de santé</th>
					<th>Action</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($walls as $beneficiaire)
                                    <tr>
                                        <td>
                                           @if ($beneficiaire->handicape == 0) o @else  oh @endif -{{ $beneficiaire->id }}
                                        </td>
									
										<td>
										
							@if ($beneficiaire->type == "image")
											<a href="/uploads/{{$beneficiaire->image}}" target="_blank">
											  <img src="/uploads/{{$beneficiaire->image}}" style="
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
								{{$beneficiaire->last_name}}
                                        </td>
										<td>
										{{$beneficiaire->first_name}}
					</td>
					 <td>
								      {{$beneficiaire->age}} @if ($beneficiaire->age >= 2) ans @else an @endif
									
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

			@if ($beneficiaire->deleted == 1) Suppression @else Ajout @endif
					</td>
                                        <td>
                                            <a href="/admin/beneficiaire/edit/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-check"></i></a>
                                            <a href="/admin/beneficiaire/delete/{{ $beneficiaire->id }}" onclick="return confirm('Supprimer ce bénéficiaire ?')" class="btn btn-xs btn-default"><i class="fa fa-times-circle"></i></a>
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

                          
                                      
	
                                        
                                       
                                        
                                        
                                       
                                    
                               
			  <section class="content-header">
            <h1>
           Médias en attente

            </h1>

        </section>
	                           
								                                
												                                     
																	                             
																						                                                                                                                                                                      
                    <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">

                                <!--               <a href="beneficiaire/excel3" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Générer fichier excel</span></a>


                                                   <a href="beneficiaire/pdf3" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Générer fichier PDF</span></a>-->
                                                </div>

                        <div class="box-body" style="overflow:auto;">
                            <table id="pageTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID bénéficiaire</th>
                                        <th>Média</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                         <th>Âge</th>

                                        <th>Genre</th>
                                        <th>État de santé</th>
                                        <th>Action</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($images as $beneficiaire)
                                    <tr>
                                        <td>
                                           @if ($beneficiaire->handicape == 0) o @else  oh @endif -{{ $beneficiaire->id }}
                                        </td>

                                                                                <td>

                                                        @if ($beneficiaire->type == "image")
                                                                                        <a href="/uploads/{{$beneficiaire->link}}" target="_blank">
                                                                                          <img src="/uploads/{{$beneficiaire->link}}" style="
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
                                                                {{$beneficiaire->last_name}}
                                        </td>
                                                                                <td>
                                                                                {{$beneficiaire->first_name}}
                                        </td>
                                         <td>
                                                                      {{$beneficiaire->age}} @if ($beneficiaire->age >= 2) ans @else an @endif

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

                        @if ($beneficiaire->deleted == 1) Suppression @else Ajout @endif
                                        </td>
                                        <td>
                                            <a href="/admin/beneficiaire/edit/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-check"></i></a>
                                            <a href="/admin/beneficiaire/delete/{{ $beneficiaire->id }}" onclick="return confirm('Supprimer ce bénéficiaire ?')" class="btn btn-xs btn-default"><i class="fa fa-times-circle"></i></a>
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
