@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')
<!--<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"/>-->

     <a  style="margin : 20px;"  href="project/create" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter projet </span></a>


<!--  <button type="button" class="btn btn-primary" id="aBtn" onclick="showAlert()">Show Toast</button>-->


        <section class="content-header">
            <h1>
            Projets en phase de réalisation
                
            </h1>
            
	</section>
	 
	
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">

						   

                        <div class="box-body"  style="overflow-x:auto;">
                            <table id="pageTable" class="table table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
					<th>Référence</th>
					<th>Nom</th>
                                        <th>Statut</th>
                                        <th>Demandé</th>
					<th>Collecté</th>
					                                        <th>Pourcentage</th>
					<th>Image</th>
					<th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($projects as $beneficiaire)
                                    <tr>
                                        <td>
                                            {{ $beneficiaire->id }}
                                        </td>
					<td style="display:none;">
					 {{url('uploads/'.$beneficiaire->image)}}
					</td>
										<td>
									{{ $beneficiaire->reference }}
					</td>

					<td>                                               
										
                                                                                @foreach ($beneficiaire->project_translates as $translate)
                                                                                        @if ($translate->language_id == 2)
												{{ $translate->title }}
														
												@endif
												@php
												$name_project = $translate->title;
												@endphp
                                                                                        @endforeach

                                                                                        |

                                                                                 @foreach ($beneficiaire->project_translates as $translate)
                                                                                        @if ($translate->language_id == 1)
                                                                                                {{ $translate->title }}
                                                                                        @endif
                                                                                        @endforeach


											</td>
					<p style="display:none" id="nomprojet">{{$name_project}}</p>

										<td>
										{{ $beneficiaire->status }}
					</td>

			<td>
                                                                                {{ $beneficiaire->needed }}
					</td>

				<td>
                                                                                {{ $beneficiaire->collected }}
					</td>
					 <td>
							@if ($beneficiaire->collected  >= $beneficiaire->needed) 100%
							@else
												{{ round($beneficiaire->collected  / $beneficiaire->needed,2) * 100 }} %
							@endif
                                        </td>

					<td>
			
			<!--<a href="{{url('uploads/'.$beneficiaire->image)}}">
                                                                                        <img src="{{url('uploads/'.$beneficiaire->image)}}" style="
                                                                                                          max-height: 50px;
                                                                                                          width: 50px;
                                                                                                          border-radius: 3px;">
									    </a>-->
				<div id="{{$beneficiaire->id}}"><a  class="btn btn-xs btn-default" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-eye"></i>
				

</a>
			</div>
					</td>
                                        <td>
                                            <a href="/admin/project/edit/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
					    <a href="/admin/project/delete/{{ $beneficiaire->id }}" onclick="return confirm('Supprimer le projet ?')" class="btn btn-xs btn-default"><i class="fa fa-trash"></i></a>
					    <div id="{{'a'.$beneficiaire->id }}"><a href="/admin/project/benevoles/{{ $beneficiaire->id }}" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-xs btn-default"><i class="fa fa-bars"></i></a></div>
				 	   <!-- <a href="/admin/project/benevoles/{{ $beneficiaire->id }}" class="btn btn-xs btn-default"><i class="fa fa-bars"></i></a>-->
					</td>
				    

                                    @endforeach
                                </tbody>
			    </table>

<div class="modal fade" id="myModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<h4  class="modal-title" style="  text-align: center;
"><p id="titleProject"></p></h4>
        </div>
      
	<div class="modal-body">
        <img id="imageprojet"   class="img-responsive"               style="text-align: center;
                                                                       vertical-align: middle;
                                                                        display: flex;
                                                                        flex-direction: column;
                                                                        justify-content: center;
                                                                        align-items: center;
                                                                        text-align: center;
									max-height: 50vh;
									border-radius: 10px;
                                                                                                          width: 60vw;
                                                                                                          position: relative;

                                                                        
                                                                                           
                                                                                           ">
       </div>
       </div>
       </div>
       </div>




<div class="modal fade" id="myModal2">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4  class="modal-title" style="  text-align: center;
"><p id="titleProject2"></p></h4>
        </div>

        <div class="modal-body">
        <div id = "benevolesProject"></div>
       </div>
       </div>
       </div>
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

/*
	$('table tbody tr  td').on('click',function(){
    $("#myModal").modal("show");
    $("#txtfname").val($(this).closest('tr').children()[0].textContent);
    $("#txtlname").val($(this).closest('tr').chilren()[1].textContent);
});
 */




    /*jQuery(document).ready(function($) {
    //$(document).ready( function () {
        $('#pageTable').DataTable();
    });*/

    	var projects = {!! json_encode($projects->toArray()) !!};

    	projects.forEach(function (arrayItem) {
	    
	    var x = "#"+arrayItem.id;
	    var titre = document.getElementById('titleProject');
	
		$(x).on('click',function(){
		    $("#myModal").modal("show");
		    document.getElementById("imageprojet").src= $(this).closest('tr').children()[1].textContent;
		    titre.innerHTML =  $(this).closest('tr').children()[3].textContent;		
    			/*$("#txtfname").val($(this).closest('tr').children()[1].textContent);
		    $("#titleProject").val($(this).closest('tr').children()[1].textContent);*/
		});
	    
	    var y = "#a" + arrayItem.id;
	    var titre2 = document.getElementById('titleProject2');
	    $(y).on('click',function(){
                console.log("benevole clicked");		    
	     titre2.innerHTML =  $(this).closest('tr').children()[3].textContent;	
	     $link = '/admin/project/benevoles/'+arrayItem.id;	
	     $.ajax( $link, {
    			type: 'GET',  // http method

    			success : function (data, status, xhr) {

				//console.log(data[0].id);
				$("#benevolesProject").html("");	
				var content = "";
				var length = data.length;

				if(length == 0){
				
				content = "<p style='text-align: center;padding= 20px;'>Pas encore de bénévoles pour ce projet</p>"
				
				}else{

				content = '<div class="box-body" style="overflow:auto;"><table id="pageTable" class="table table-bordered table-hover"><thead><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Montant</th></tr></thead><tbody>';
				//var length = data.length;
				
				for(i=0; i< length ; i++){
					
					content += '<tr><td>'+
                                        data[i].id
                                        +'</td><td>'
					+data[i].lastname+
					'</td><td>'
					+data[i].firstname
					+'</td><td>'+ 
					data[i].email+
					'</td><td>'+
		  			data[i].montant
                                 	'</td></tr>';
				
				}
				
				content += "</tbody></table></div></div></div></div>";

				}
				
				$("#benevolesProject").append(content);
				//$("#benevolesProject").append('</tbody></table></div></div></div></div>');
				$("#myModal2").modal("show");
				content="";
				

    		},
    			error: function (jqXhr, textStatus, errorMessage) {
            		$('p').append('Error' + errorMessage);
    		}
	     });

	       
                titre.innerHTML =  $(this).closest('tr').children()[3].textContent;

	      });	    

	});


//$('.toast').toast('show');
	




    $(document).ready(function () {

     // Attach Button click event listener
    $("#myBtn").click(function(){
														
         // show Modal
         $('#myModal').modal('show');
    });
    });


	function showAlert() {
    alert ("Hello world!");
  }
  


/*
    $('.open-modal').on('click', function() {
  // fade in filter layer and modal
  $('.filter, .modal').fadeIn(200);
});

//---------------------------------------------------------
// close modal
//---------------------------------------------------------

// close modal by clicking the "close" button or background (outside modal)
$('.modal-close, .filter').on('click', function() {
  // fade out filter layer and modal
  $('.filter, .modal').fadeOut(200);
});*/




    </script>


<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <img height="200px" width="200px" src="https://upload.wikimedia.org/wikipedia/commons/f/f9/Phoenicopterus_ruber_in_S%C3%A3o_Paulo_Zoo.jpg" class="rounded mr-2" alt="...">
    <strong class="mr-auto">Bootstrap</strong>
    <small class="text-muted">11 mins ago</small>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
  </div>
  <div class="toast-body">
    Hello, world! This is a toast message.
  </div>
</div>-->
@endsection
