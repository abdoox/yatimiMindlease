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


<h1 align="center">liste des orphelins</h1>

     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:2px;" width="1%">ID</th>
    <th style="border: 1px solid; padding:2px;" width="2%">nom</th>	
    <th style="border: 1px solid; padding:2px;" width="2%">prenom</th>
    <th style="border: 1px solid; padding:2px;" width="2%">pere</th>	
    <th style="border: 1px solid; padding:2px;" width="5%">mere</th>
    <th style="border: 1px solid; padding:2px;" width="4%">birthday</th>
    <th style="border: 1px solid; padding:2px;" width="1%">sex</th>
    <!--<th style="border: 1px solid; padding:2px;" width="3%">weight</th>
    <th style="border: 1px solid; padding:2px;" width="3%">length</th>-->
    <th style="border: 1px solid; padding:2px;" width="5%">tel mere</th>
    <th style="border: 1px solid; padding:2px;" width="3%">deces mere</th>
    <th style="border: 1px solid; padding:2px;" width="1%">nombre freres</th>
    <th style="border: 1px solid; padding:2px;" width="3%">annif pere</th>
    <th style="border: 1px solid; padding:2px;" width="3%">deces pere</th>
    <th style="border: 1px solid; padding:2px;" width="3%">type</th>
    <th style="border: 1px solid; padding:2px;" width="3%">handicape</th>
    <th style="border: 1px solid; padding:2px;" width="5%">address</th>
    <!--<th style="border: 1px solid; padding:2px;" width="5%">leisure</th>-->
    <th style="border: 1px solid; padding:2px;" width="5%">niveau scol</th>
    <!--<th style="border: 1px solid; padding:2px;" width="5%">dream</th>-->
    <th style="border: 1px solid; padding:2px;" width="5%">city</th>
    <!--<th style="border: 1px solid; padding:2px;" width="3%">last_school_name</th>-->
    <th style="border: 1px solid; padding:2px;" width="10%">type maison</th>
    <th style="border: 1px solid; padding:2px;" width="5%">prix location</th>

   </tr>
@foreach ($beneficiaires as $customer)

<tr>
        <td style="border: 1px solid; padding:2px;">{{$customer->id}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->last_name}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->first_name}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->father_name}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->mother_name}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->birthday}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->sex}}</td>
	<!--<td style="border: 1px solid; padding:2px;">{{$customer->weight}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->length}}</td>-->
	<td style="border: 1px solid; padding:2px;">{{$customer->mother_phone}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->mother_death_date}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->brothers_number}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->father_birthday}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->death_date}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->type}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->handicape}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->address}}</td>
	<!--<td style="border: 1px solid; padding:2px;">{{$customer->leisure}}</td>-->
	<td style="border: 1px solid; padding:2px;">{{$customer->school_level}}</td>
	<!--<td style="border: 1px solid; padding:2px;">{{$customer->dream}}</td>-->
	<td style="border: 1px solid; padding:2px;">{{$customer->city}}</td>
	<!--<td style="border: 1px solid; padding:2px;">{{$customer->last_school_name}}</td>-->
	<td style="border: 1px solid; padding:2px;">{{$customer->house_type}}</td>
	<td style="border: 1px solid; padding:2px;">{{$customer->house_price}}</td>

      </tr>
@endforeach
</table>


</body>

</html>
