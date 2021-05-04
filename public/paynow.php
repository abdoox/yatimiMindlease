<html>
<head>
<title>Yatimi</title>
<meta http-equiv="Content-Language" content="tr">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-9">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="now">
</head>

<body onload="javascript:moveWindow()">
<body>

	<form name="pay_form" method="post" action="https://payment.cmi.co.ma/fim/est3Dgate">

<?php
if(!isset($_GET['oid']) || !isset($_GET['email']) || !isset($_GET['amount'])) {
	exit();
}
    
    $form_array = array('clientid' => '600001407', 
    			'amount' => $_GET['amount'], 
    			'okUrl' => 'http://yatimi.aramobile.com/success',
    			'failUrl' => 'http://yatimi.aramobile.com/failure',
    			'TranType' =>  'PreAuth',
    			'currency' => 504,
    			'rnd' => microtime(),
    			'storetype' => '3D_PAY_HOSTING',
    			'hashAlgorithm' => 'ver3',
    			'lang' => 'ar',
    			'oid' => $_GET['oid'],
    			'email' => $_GET['email'],
    			'callbackUrl' => 'http://yatimi.aramobile.com/api/callback/donation');

	$storeKey = "YaT2020Mi";
	$postParams = array();
	foreach ($form_array as $key => $value){
		array_push($postParams, $key);
		echo "<input type=\"hidden\" name=\"" .$key ."\" value=\"" .trim($value)."\" /><br />";
	}
	natcasesort($postParams);
			
	$hashval = "";					
	foreach ($postParams as $param){				
		$paramValue = trim($form_array[$param]);
            
		$escapedParamValue = str_replace("|", "\\|", str_replace("\\", "\\\\", $paramValue));	
					
		$lowerParam = strtolower($param);
		if($lowerParam != "hash" && $lowerParam != "encoding" )	{
			$hashval = $hashval . $escapedParamValue . "|";
		}
	}
			
	$escapedStoreKey = str_replace("|", "\\|", str_replace("\\", "\\\\", $storeKey));
	$hashval = $hashval . $escapedStoreKey;
          // $byte_array = unpack('C*', $hashval);
			
	$calculatedHashValue = hash('sha512', $hashval);
            
	$hash = base64_encode (pack('H*',$calculatedHashValue));
			
	echo "<input type=\"hidden\" name=\"HASH\" value=\"" .$hash."\" /><br />";			
		
?>
	</form>
	
<script type="text/javascript" language="javascript">
function moveWindow() {
    document.pay_form.submit();
}
</script>

</body>

</html>
