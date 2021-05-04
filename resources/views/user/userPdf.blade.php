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


<h2>Utilisateurs Parrains</h2>
<h3 align="center">liste des utilisateurs qui ont parrainee des orphelins</h3>
     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:2px;" width="10%">ID</th>
    <th style="border: 1px solid; padding:2px;" width="15%">email</th>
    <th style="border: 1px solid; padding:2px;" width="5%">Compte verifie</th>
    <th style="border: 1px solid; padding:2px;" width="15%">nom</th>
    <th style="border: 1px solid; padding:2px;" width="15%">prenom</th>
    <th style="border: 1px solid; padding:2px;" width="20%">description</th>
   <th style="border: 1px solid; padding:2px;" width="10%">reseau</th>


   </tr>
@foreach ($users as $customer)

<tr>
       <td style="border: 1px solid; padding:2px;">{{$customer->id}}</td>
       <td style="border: 1px solid; padding:2px;">{{$customer->email}}</td>
       <td style="border: 1px solid; padding:2px;">

@if($customer->verifie == 0)
non verifie
@else verifie
@endif


</td>
       <td style="border: 1px solid; padding:2px;">{{$customer->lastname}}</td>
       <td style="border: 1px solid; padding:2px;">{{$customer->firstname}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->description}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->provider}}</td>
      </tr>
@endforeach
</table>


</body>

</html>
