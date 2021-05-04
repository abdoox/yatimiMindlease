<!DOCTYPE html>

<html>

<head>

	<title>Load PDF</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<style> 

 body { font-family: DejaVu Sans, sans-serif; font-size:5px;}
</style>
	
<body>


<h1 align="center">liste des prises en charge - parrainage - </h1>

     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:2px;" width="1%">Nom parrain</th>
    <th style="border: 1px solid; padding:2px;" width="2%">Prenom parrain</th>	
    <th style="border: 1px solid; padding:2px;" width="2%">montant</th>
    <th style="border: 1px solid; padding:2px;" width="2%">prenom orphelin</th>	
    <th style="border: 1px solid; padding:2px;" width="5%">nom orphelin</th>
    <th style="border: 1px solid; padding:2px;" width="4%">Etat sanitaire (normal : null, handicape : 1)</th>
    <th style="border: 1px solid; padding:2px;" width="1%">date de parrainage</th>
    <!--<th style="border: 1px solid; padding:2px;" width="3%">weight</th>
    <th style="border: 1px solid; padding:2px;" width="3%">length</th>-->
    <th style="border: 1px solid; padding:2px;" width="5%">association</th>
    

   </tr>
@foreach ($beneficiaireUser as $customer)

<tr>
        
        <td style="border: 1px solid; padding:2px;">{{$customer->lastname}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->firstname}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->montant}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->first_name}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->last_name}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->handicape}}</td>
	<!--<td style="border: 1px solid; padding:2px;">{{$customer->weight}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->length}}</td>-->
	<td style="border: 1px solid; padding:2px;">{{$customer->created_at}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->name}}</td>
	

      </tr>
@endforeach
</table>


</body>

</html>
