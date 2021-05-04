@extends('backpack::layout')

@section('title', 'Prise en charge')

@section('content')

<a  style="margin : 20px;"  href="prise_en_charge/create" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Ajouter parrainage </span></a>
<a  style="margin : 20px;"  href="prise_en_charge/export" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Exporter Excel</span></a>
<a  style="margin : 20px;"  href="prise_en_charge/pdf" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> Exporter PDF</span></a>
	<section class="content-header">
            <h1>
            Prise en charge
            
            </h1>
            
        </section>
	

<section class="content">
	    
	<div class="row">
           
                <div class="col-xs-12">
                    <div class="box">

                        <div class="box-body" style="overflow:auto;" >
                            <table id="pageTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Bénéficiaire</th>
                                        <th>Utilisateur</th>
                                        <th>Email</th>
                                        <th>Tél</th>
                                        <th>Montant</th>
                                        <th>Net pour association</th>
                                        <th>Date de prise en charge</th>
                                        <th>Prochain paiement</th>
					<th>Association</th>
					<th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($entries as $entry)
                                    <tr>
                                        <td>
                                            {{ $entry->id }}
                                        </td>
                                                                                <td>
                                            {{ $entry->last_name }} {{ $entry->first_name }}

</td>
                                                                                <td>
                                             {{ $entry->lastname }} {{ $entry->firstname }}
                                        </td>
                                        <td>
                                            {{ $entry->email }}
                                        </td>
                                        <td>
                                            {{ $entry->adresse }}
                                        </td>
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
                                        <td>
                                            {{ $entry->name }}
					</td>
				<td>
                                            <a href="/admin/prise_en_charge/edit?id={{ $entry->parrainage_id }}" class="btn btn-xs btn-default"><i class="fa fa-pencil"></i></a>
                                          
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
