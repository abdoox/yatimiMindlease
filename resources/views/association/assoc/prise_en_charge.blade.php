@extends('backpack::layoutAssoc')

@section('title', 'Prise en charge')

@section('content')


<a  style="margin : 20px;"  href="association/prise_en_charge/excel" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Exporter Excel</span></a>
<!--<a  style="margin : 20px;"  href="prise_en_charge/pdf" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Exporter PDF</span></a>
-->	<section class="content-header">
            <h1>
            Prise en charge
            
            </h1>
            
        </section>
	

<section class="content">
	    
	<div class="row">
           
                <div class="col-xs-12">
                    <div class="box">


        <p  style="font-size:20px;padding:25px;">Le nombre des parrainages actifs est  <strong>{{$nbr}}</strong>.</p>
                        <div class="box-body" style="overflow:auto;" >
                            <table id="pageTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID parrain</th>
					<th>ID bénéficiaire</th>
					<th>Bénéficiaire</th>
					<th>Âge</th>
					<th>Sexe</th>
					<th>État de santé</th>
					<th>Date de création d'orphelin</th>
                                        <th>Montant</th>
                                        <th>Net pour association</th>
                                        <th>Date de prise en charge</th>
                                        <th>Prochain paiement</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($entries as $entry)
                                    <tr>
                                        <td>
                                          p-  {{ $entry->user_id}}
					</td>
					<td>
					@if ($entry->handicape == 1) oh @else o @endif - {{$entry->beneficiaire_id}}



					</td>
                                                                                <td>
                                            {{ $entry->last_name }} {{ $entry->first_name }}

</td>
						     <td>{{ $entry->age }}
						@if ($entry->age == 0 || $entry->age == 1 ) an @else ans @endif
</td>
							<td> @if ($entry->sex == 'F') Fille @else Garçon @endif </td>
							<td>@if ($entry->handicape == 1) Handicapé @else Normal @endif </td>	     
							<td>                                                                                 {{ \Carbon\Carbon::parse($entry->createdAt)->format('d-m-Y')}}</td>

					<td>
					
                                            {{ $entry->montant }}
                                        </td>
                                        <td>	
                                            {{ $entry->montant * 0.86 }}
                                        </td>
					<td>
					{{ \Carbon\Carbon::parse($entry->created_at)->format('d-m-Y')}}

                                            <!--{{ $entry->created_at }}-->
                                        </td>
                                        <td>
                                                                                 {{ \Carbon\Carbon::parse($entry->date_fin)->format('d-m-Y')}}
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
@section('adminlte_js')
    <script src="{{ asset('js/script.js') }}"></script>
@endsection
