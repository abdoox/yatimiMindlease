@extends('backpack::layout')

@section('title', 'Bénéficiaires')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ url('/css/circle.css') }}" />
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


<input type="hidden" id="projectsCount" value="{{$results['projectsCount']}}">
<input type="hidden" id="projectsCollectedCount" value="{{$results['projectsCollectedCount']}}">
<input type="hidden" id="projectsClosedCount" value="{{$results['projectsClosedCount']}}">
<input type="hidden" id="projectsNotCollectedCount" value="{{$results['projectsNotCollectedCount']}}">
<input type="hidden" id="beneficiaireCount"value="{{$results['beneficiaireCount']}}">
<input type="hidden" id="beneficiaireGarconCount"value="{{$results['beneficiaireGarconCount']}}">
<input type="hidden" id="beneficiaireFilleCount" value="{{$results['beneficiaireFilleCount']}}">
<input type="hidden" id="garconPercent" value="{{$results['garconPercent']}}">
<input type="hidden" id="fillePercent" value="{{$results['fillePercent']}}">
<input type="hidden" id="beneficiaireParraineCount" value="{{$results['beneficiaireParraineCount']}}">
<input type="hidden" id="beneficiaireNonParraineCount" value="{{$results['beneficiaireNonParraineCount']}}">
<input type="hidden" id="beneficiaireParrainePercent" value="{{$results['beneficiaireParrainePercent']}}">
<input type="hidden" id="beneficiaireNonParrainePercent" value="{{$results['beneficiaireNonParrainePercent']}}">

<input type="hidden" id="paiement" value="{{$results['paiements']['paiement']}}">
<input type="hidden" id="paiement1" value="{{$results['paiements']['paiement1']}}">
<input type="hidden" id="paiement2" value="{{$results['paiements']['paiement2']}}">
<input type="hidden" id="paiement3" value="{{$results['paiements']['paiement3']}}">
<input type="hidden" id="paiement4" value="{{$results['paiements']['paiement4']}}">
<input type="hidden" id="paiement5" value="{{$results['paiements']['paiement5']}}">
<input type="hidden" id="paiement6" value="{{$results['paiements']['paiement6']}}">
<input type="hidden" id="paiement7" value="{{$results['paiements']['paiement7']}}">
<input type="hidden" id="paiement8" value="{{$results['paiements']['paiement8']}}">
<input type="hidden" id="paiement9" value="{{$results['paiements']['paiement9']}}">
<input type="hidden" id="paiement10" value="{{$results['paiements']['paiement10']}}">
<input type="hidden" id="paiement11" value="{{$results['paiements']['paiement11']}}">


<input type="hidden" id="donation" value="{{$results['donations']['donation']}}">
<input type="hidden" id="donation1" value="{{$results['donations']['donation1']}}">
<input type="hidden" id="donation2" value="{{$results['donations']['donation2']}}">
<input type="hidden" id="donation3" value="{{$results['donations']['donation3']}}">
<input type="hidden" id="donation4" value="{{$results['donations']['donation4']}}">
<input type="hidden" id="donation5" value="{{$results['donations']['donation5']}}">
<input type="hidden" id="donation6" value="{{$results['donations']['donation6']}}">
<input type="hidden" id="donation7" value="{{$results['donations']['donation7']}}">
<input type="hidden" id="donation8" value="{{$results['donations']['donation8']}}">
<input type="hidden" id="donation9" value="{{$results['donations']['donation9']}}">
<input type="hidden" id="donation10" value="{{$results['donations']['donation10']}}">
<input type="hidden" id="donation11" value="{{$results['donations']['donation11']}}">



<input type="hidden" id="ville1" value="{{$results['villeBeneficiairesResult'][0]['city']}}">
<input type="hidden" id="ville2" value="{{$results['villeBeneficiairesResult'][1]['city']}}">
<input type="hidden" id="ville3" value="{{$results['villeBeneficiairesResult'][2]['city']}}">
<input type="hidden" id="ville4" value="{{$results['villeBeneficiairesResult'][3]['city']}}">
<input type="hidden" id="ville5" value="{{$results['villeBeneficiairesResult'][4]['city']}}">

<input type="hidden" id="total1" value="{{$results['villeBeneficiairesResult'][0]['total']}}">
<input type="hidden" id="total2" value="{{$results['villeBeneficiairesResult'][1]['total']}}">
<input type="hidden" id="total3" value="{{$results['villeBeneficiairesResult'][2]['total']}}">
<input type="hidden" id="total4" value="{{$results['villeBeneficiairesResult'][3]['total']}}">
<input type="hidden" id="total5" value="{{$results['villeBeneficiairesResult'][4]['total']}}">


	<section class="content-header">
            <h1>
	    
                Utilisateurs
            </h1>
            
	</section>
	  <section class="content">
            <div class="row">
                <div class="col-xs-12">
		
		    <div class="box"  style="overflow:auto;" >

			<div  style="padding:15px" class="row">
<table width="100%"><tr>
<th style="font-weight:normal;">

<div class="row justify-content-center align-items-center" style="padding:40px;"><p  style = "font-size:20px;">nombre d'utilisateurs</p>
<div  style = "font-family:georgia,garamond,serif;font-size:10px;font-style:italic;" id="shiva"><span class="count">{{$results['usersCount']}}</span></div></div>
</th>
<th style="font-weight:normal;">
<div class="row" style="padding:40px;"><p  style = "font-size:20px;">nombre de parrains</p>
<div  style = "font-family:georgia,garamond,serif;font-size:10px;font-style:italic;" id="shiva"><span class="count">{{$results['usersParrainsCount']}}</span></div></div>
</th>
<th style="font-weight:normal;">
<div class="row" style="padding:40px;"><p  style = "font-size:20px;">nombre d'installations</p>
<div  style = "font-family:georgia,garamond,serif;font-size:10px;font-style:italic;" id="shiva"><span class="count">2300</span></div></div>


</th>
</tr></table>

</section>
 <section class="content-header">
            <h1>

                Orphelins
            </h1>
            
        </section>
          <section class="content">

<div class="row">
                <div class="col-xs-12">

                    <div class="box" style="overflow:auto;">

<!--<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
-->
<figure class="highcharts-figure">
  <div id="container"></div>
  
</figure>
<p style="text-align:center;font-size:20px;padding:15px;">Le nombre total des orphelins est <strong>{{$results['beneficiaireCount']}}</strong>, dont <strong>{{$results['beneficiaireParraineCount']}}</strong> sont parrainés et <strong> {{$results['beneficiaireNonParraineCount']}} </strong>non parrainés</p>
		
		</div></div></div>

<!--	 </section>



<section class="content-header">
            <h1>

                Orphelins
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard </a></li>
           		     <li class="active">Dashboard</li>
            </ol>
        </section>
          <section class="content">
-->
<div class="row">
                <div class="col-xs-12">

		    <div class="box" style="overflow:auto;">


<div hidden style="padding:20px;" class="buttons">
  <button id="2000">
  2000
  </button>
  <button id="2004">
  2004
  </button>
  <button id="2008">
  2008
  </button>
  <button id="2012">
  2012
  </button>
  <button id="2016" class="active">
  2016
  </button>
</div>
<div style="padding:20px;" id="containerr"></div>


		</div>
	</div>
</div>


<div class="row">
                <div class="col-xs-12">

                    <div class="box">

<figure class="highcharts-figure">
  <div id="containerrr"></div>
 
</figure>

<p style="text-align:center;font-size:20px;padding:15px;">Le nombre total des garçons est <strong>{{$results['beneficiaireGarconCount']}}</strong> et le nombre total des filles est <strong> {{$results['beneficiaireFilleCount']}}</strong></p>

 </div>
        </div>
</div>

</section>


 <section class="content-header">
            <h1>

                Projets
            </h1>
            
        </section>
          <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div style="overflow:auto;" class="box">

                        <div  style="padding:15px" class="row">
<table width="100%"><tr>
<th style="font-weight:normal;padding:30px;">

<div class="row" style="padding:40px;"><p  style = "font-size:20px;">nombre de projets</p>
<div  style = "font-family:georgia,garamond,serif;font-size:10px;font-style:italic;" id="shiva"><span class="count">{{$results['projectsCount']}}</span></div></div>
</th>
<th style="font-weight:normal;padding:30px;">
<figure class="highcharts-figure">
  <div  id="containerrrr"></div>

</figure>

 </div>
</th>
<th style="font-weight:normal;padding:30px;">
<div class="row" style="padding:25px;"><p  style = "font-size:20px;">nombre d'installations</p>
<div  style = "font-family:georgia,garamond,serif;font-size:10px;font-style:italic;" id="shiva"><span class="count">2300</span></div></div>


</th>
</tr></table>

</section>




 <section class="content-header">
            <h1>

                Paiements
            </h1>
            
        </section>
          <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div style="overflow:auto;" class="box">

                        <div  style="padding:15px" class="row">

<figure class="highcharts-figure">
  <div id="containerrrrr"></div>
  <p style="text-align:center ;font-size:20px;" class="highcharts-description">
    Le total des paiements reçus jusqu'à présent est <strong>{{$results['paiements']['paiementTotal']}} DHS</strong>, et le total des paiements reçus dans les derniers 12 mois est <strong> {{$results['paiements']['paiementYear']}} DHS</strong>.
  </p>
</figure>
</div>		</div></div></div>

</section>




<section class="content-header">
            <h1>

                Donations
            </h1>
            
        </section>
          <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div style="overflow:auto;" class="box">

                        <div  style="padding:15px" class="row">

<figure class="highcharts-figure">
  <div id="containerrrrrr"></div>
  <p style="text-align:center ;font-size:20px;"  class="highcharts-description">
    Le total des donations reçus jusqu'à présent est <strong>{{$results['donations']['donationTotal']}} DHS</strong>,  et le total des donations reçus dans les derniers 12 mois est <strong> {{$results['donations']['donationYear']}} DHS</strong>.

  </p>
</figure>
</div>          </div></div></div>

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

var projectsCount =  $('#projectsCount').val();
var projectsCollectedCount =  $('#projectsCollectedCount').val();
var projectsNotCollectedCount =  $('#projectsNotCollectedCount').val();
var projectsClosedCount =  $('#projectsClosedCount').val();
var beneficiaireCount = $('#beneficiaireCount').val();
var beneficiaireGarconCount = $('#beneficiaireGarconCount').val();
var beneficiaireFilleCount = $('#beneficiaireFilleCount').val();
var garconPercent = $('#garconPercent').val();
var fillePercent = $('#fillePercent').val();
var beneficiaireParraineCount = $('#beneficiaireParraineCount').val();
var beneficiaireNonParraineCount = $('#beneficiaireNonParraineCount').val();


var donation =  $('#donation').val();
var donation1 =  $('#donation1').val();
var donation2 =  $('#donation2').val();
var donation3 =  $('#donation3').val();
var donation4 =  $('#donation4').val();
var donation5 =  $('#donation5').val();
var donation6 =  $('#donation6').val();
var donation7 =  $('#donation7').val();
var donation8 =  $('#donation8').val();
var donation9 =  $('#donation9').val();
var donation10 =  $('#donation10').val();
var donation11 =  $('#donation11').val();

var paiement =  $('#paiement').val();
var paiement1 =  $('#paiement1').val();
var paiement2 =  $('#paiement2').val();
var paiement3 =  $('#paiement3').val();
var paiement4 =  $('#paiement4').val();
var paiement5 =  $('#paiement5').val();
var paiement6 =  $('#paiement6').val();
var paiement7 =  $('#paiement7').val();
var paiement8 =  $('#paiement8').val();
var paiement9 =  $('#paiement9').val();
var paiement10 =  $('#paiement10').val();
var paiement11 =  $('#paiement11').val();

//var month = Date.today().addMonths(-6);


var ville1 =  $('#ville1').val();
var ville2 =  $('#ville2').val();
var ville3 =  $('#ville3').val();
var ville4 =  $('#ville4').val();
var ville5 =  $('#ville5').val();

var total1 =  $('#total1').val();
var total2 =  $('#total2').val();
var total3 =  $('#total3').val();
var total4 =  $('#total4').val();
var total5 =  $('#total5').val();
console.log(total1);

var now = new Date();
var monthsFinals = [];
var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
for (var i = 0; i <= 11; i++) {
	console.log(months[now.getMonth()] + ' ' + now.getFullYear());
	monthsFinals[i]=months[now.getMonth()];

    var past = now.setMonth(now.getMonth() - 1);
//    monthsFinals[i]=months[now.getMonth()];
	console.log(monthsFinals[i]);
}
Highcharts.chart('containerrrrrr', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Donations reçus par mois'
  },
  subtitle: {
    text: ''
  },
  xAxis: {
  categories: [

  monthsFinals[11],
  monthsFinals[10],
  monthsFinals[9],
  monthsFinals[8],
  monthsFinals[7],
  monthsFinals[6],
  monthsFinals[5],
  monthsFinals[4],
  monthsFinals[3],
  monthsFinals[2],
  monthsFinals[1],
  monthsFinals[0],

  ],
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'donationn (Milles DHS) '
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:.1f} Milles DHs</b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
    },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    }
  },
  series: [ {
    name: 'Donations',
    data: [donation11/1000, donation10/1000, donation9/1000, donation8/1000, donation7/1000, donation6/1000, donation5/1000, donation4/1000, donation3/1000, donation2/1000, donation1/1000, donation/1000]

    }],

    credits: {
    enabled: false
  },
});




Highcharts.chart('containerrrrr', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Paiements reçus par mois'
  },
  subtitle: {
    text: ''
  },
  xAxis: {
  categories: [
	  
  monthsFinals[11],
  monthsFinals[10],
  monthsFinals[9],
  monthsFinals[8],
  monthsFinals[7],
  monthsFinals[6],
  monthsFinals[5],
  monthsFinals[4],
  monthsFinals[3],  
  monthsFinals[2],
  monthsFinals[1],
  monthsFinals[0],
  
  ],
    crosshair: true
  },
  yAxis: {
    min: 0,
    title: {
      text: 'paiement (Milles DHS) '
    }
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:.1f} Milles DHs</b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
  plotOptions: {
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    }
  },
  series: [{
    name: 'Paiements',
    data: [paiement11/1000, paiement10/1000, paiement9/1000, paiement8/1000, paiement7/1000, paiement6/1000, paiement5/1000, paiement4/1000, paiement3/1000, paiement2/1000, paiement1/1000, paiement/1000]

    }],
    credits: {
    enabled: false
  },
});




Highcharts.chart('containerrrr', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: 0,
    plotShadow: false
  },
  title: {
    text: 'Projets %',
    align: 'center',
    verticalAlign: 'middle',
    y: 60
  },
  tooltip: {
    pointFormat: ' <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      dataLabels: {
        enabled: true,
        distance:-50,
        style: {
          fontWeight: 'bold',
          color: 'white'
        }
      },
      startAngle: -90,
      endAngle: 90,
      center: ['50%', '75%'],
      size: '110%'
    }
  },
  series: [{
    type: 'pie',
    name: 'Browser share',
    innerSize: '50%',
     data: [
      ['Réalisés', projectsClosedCount/projectsCount],
      ['En cours de collection d\'argents', projectsNotCollectedCount/projectsCount],
      ['En cours de réalisation', projectsCollectedCount/projectsCount]
        ]
    }],
    credits: {
    enabled: false
  },
});






Highcharts.chart('containerrr', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: 0,
    plotShadow: false
  },
  title: {
    text: 'Garçons/Filles %',
    align: 'center',
    verticalAlign: 'middle',
    y: 70
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      dataLabels: {
        enabled: true,
        distance: -50,
        style: {
          fontWeight: 'bold',
          color: 'white'
        }
      },
      startAngle: -90,
      endAngle: 90,
      center: ['50%', '75%'],
      size: '110%'
    }
  },
  series: [{
    type: 'pie',
    name: 'Browser share',
    innerSize: '50%',
     data: [
      ['Garçons', beneficiaireGarconCount/beneficiaireCount],
      ['Filles', beneficiaireFilleCount/beneficiaireCount],
      
      /*{
        name: 'Other',
        y: 7.61,
        dataLabels: {
          enabled: false
        }
    }*/
    ]
    }],

    credits: {
    enabled: false
  },
});


var dataPrev = {
  2016: [
     [ville1, total1/2],
    [ville2, total2/2],
    [ville3, total3],
    [ville4, total4],
    [ville5, total5]

  ],
  2012: [
    ['South Korea', 13],
    ['Japan', 0],
    ['Australia', 0],
    ['Germany', 0],
    ['Russia', 22]
  ],
  2008: [
    ['South Korea', 0],
    ['Japan', 0],
    ['Australia', 0],
    ['Germany', 13],
    ['Russia', 27]
  ],
  2004: [
    ['South Korea', 0],
    ['Japan', 5],
    ['Australia', 16],
    ['Germany', 0],
    ['Russia', 32]
  ],
  2000: [
    ['South Korea', 0],
    ['Japan', 0],
    ['Australia', 9],
    ['Germany', 20],
    ['Russia', 26]
  ]
};

var data = {
  2016: [
	  
    [ville1, parseInt(total1)],
    [ville2, parseInt(total2)],
    [ville3, parseInt(total3)],
    [ville4, parseInt(total4)],
    [ville5, parseInt(total5)]

  ],
  2012: [
    ['South Korea', 13],
    ['Japan', 0],
    ['Australia', 0],
    ['Germany', 0],
    ['Russia', 24]
  ],
  2008: [
    ['South Korea', 0],
    ['Japan', 0],
    ['Australia', 0],
    ['Germany', 16],
    ['Russia', 22]
  ],
  2004: [
    ['South Korea', 0],
    ['Japan', 16],
    ['Australia', 17],
    ['Germany', 0],
    ['Russia', 27]
  ],
  2000: [
    ['rabat', 0],
    ['casablanca', 0],
    ['agadir', 16],
    ['salé', 13],
    ['Marrakech', 32]
   
  ]
};

var countries = [{
  name: ville1,
  flag: ville1,
  color: 'rgb(200, 200, 255)'
}, {
  name: ville2,
  flag: ville2,
  color: 'rgb(200, 200, 255)'
}, {
  name: ville3,
  flag: ville3,
  color: 'rgb(200, 200, 255)'
}, {
  name: ville4,
  flag: ville4,
  color: 'rgb(200, 200, 255)'
}, {
  name: ville5,
  flag: ville5,
  color: 'rgb(200, 200, 255)'
}];


function getData(data) {
  return data.map(function (country, i) {
    return {
      name: country[0],
      y: country[1],
      color: countries[i].color
    };
  });
}

/*function getData(data) {
  return data.map(function (country, i) {
    return {
      name: countries[i].name,
      y: country[1],
      color: countries[i].color
    };
  });*/



var chart = Highcharts.chart('containerr', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Top 5 villes où habitent nos orphelins'
  },
  subtitle: {
    text: ''
  },
  plotOptions: {
    series: {
      grouping: false,
      borderWidth: 0
    }
  },
  legend: {
    enabled: false
  },
  tooltip: {
    shared: true,
    headerFormat: '<span style="font-size: 15px">{point.point.name}</span><br/>',
    pointFormat: '<span style="color:{point.color}">\u25CF</span> <b>{point.y} orphelins</b><br/>'
  },
  xAxis: {
    type: 'category',
    max: 4,
    labels: {
      useHTML: true,
      animate: true,
      /*formatter:
	function () {
        var value = this.value,
          output;
	var villes = [ville1, ville2, ville3, ville4, ville5];	

	//return point.point.name;
	/*countries.forEach(function (country) {
	  
		var arrayLength = villes.length;
		for (var i = 0; i < arrayLength; i++) {

			if (country.name == villes[i]) {
            output = country.name;
          }
    
	}		
           // output = country.name;
          
	});

        return '<span><p> </p><br></span>';
	}*/
    }
  },
  yAxis: [{
    title: {
      text: 'Nombre des orphelins / ville'
    },
    showFirstLabel: false
  }],
  series: [{
    color: 'rgb(158, 159, 163)',
    pointPlacement: -0.2,
    linkedTo: 'main',
    //data: dataPrev[2016].slice(),
    name: '2012'
  }, {
    name: '2016',
    id: 'main',
    dataSorting: {
      enabled: true,
      matchByName: true
    },
    dataLabels: [{
      enabled: true,
      inside: true,
      style: {
        fontSize: '12px'
    },
	    formatter: function () {
      return this.y;
    }
    }],
    data: getData(data[2016]).slice()
  }],
  exporting: {
    allowHTML: true
      },
      credits: {
    enabled: false
  },
});

var years = [2016, 2012, 2008, 2004, 2000];

years.forEach(function (year) {
  var btn = document.getElementById(year);

  btn.addEventListener('click', function () {

    document.querySelectorAll('.buttons button.active').forEach(function (active) {
      active.className = '';
    });
    btn.className = 'active';

    chart.update({
      title: {
        text: 'Summer Olympics ' + year + ' - Top 5 countries by Gold medals'
      },
      subtitle: {
        text: 'Comparing to results from Summer Olympics ' + (year - 4) + ' - Source: <ahref="https://en.wikipedia.org/wiki/' + (year) + '_Summer_Olympics_medal_table">Wikipedia</a>'
      },
      series: [{
        name: year - 4,
        data: dataPrev[year].slice()
      }, {
        name: year,
        data: getData(data[year]).slice()
      }]
    }, true, false, {
      duration: 800
    });
  });
});


$('.count').each(function () {
  var $this = $(this);
  jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
    duration: 5000,
    easing: 'swing',
    step: function () {
      $this.text(Math.ceil(this.Counter));
    }
  });
});


/*$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 5000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});*/
   

   Highcharts.chart("container", {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: "pie"
  },
  title: {
    text: "Pourcentage des orphelins parrainés et non parrainés"
  },
  tooltip: {
    pointFormat: "<b>{point.percentage:.2f}%</b>"
  },
  accessibility: {
    point: {
      valueSuffix: "%"
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: "pointer",
      dataLabels: {
        enabled: true,
        format: " {point.percentage:.2f} %"
      }
    }
  },
  series: [
    {
      name: "Brands",
      colorByPoint: true,
      data: [
        {
          name: "Parrainés",
          y: beneficiaireParraineCount/beneficiaireCount,
          sliced: true,
          selected: true
        },

        {
          name: "Non parrainés",
          y: beneficiaireNonParraineCount/beneficiaireCount
        }
      ]
    }
  ],
	  credits: {
    enabled: false
  },
});
</script>
    		
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<!-- Circle Progress JS -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-circle-progress/1.2.2/circle-progress.min.js'>	
    

    jQuery(document).ready(function($) {
    //$(document).ready( function () {
        $('#pageTable').DataTable();
    });



    </script>
@endsection
