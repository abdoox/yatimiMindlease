<!DOCTYPE html>

<html>

<head>

	<title>Load PDF</title>
<meta http-equiv="Content-Type" content="text/html; "/>
</head>
<style> 

 body { font-family: DejaVu Sans, sans-serif; font-size:5px;}
</style>
	
<body>


<h1 align="center">liste des donations</h1>

     <table width="100%" style="border-collapse: collapse; border: 0px;">
      <tr>
    <th style="border: 1px solid; padding:2px;" width="1%">transaction</th>
    <th style="border: 1px solid; padding:2px;" width="2%">montant</th>	
    <th style="border: 1px solid; padding:2px;" width="2%">date paiement</th>
    <th style="border: 1px solid; padding:2px;" width="2%">email user</th>	
    <th style="border: 1px solid; padding:2px;" width="2%">type</th>

   </tr>
@foreach ($paiements as $customer)

<tr>
        <td style="border: 1px solid; padding:2px;">{{$customer->transaction_id}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->montant}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->created_at}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->email}}</td>
        <td style="border: 1px solid; padding:2px;">{{$customer->title}}</td>
        

      </tr>
@endforeach
</table>


</body>

</html>
