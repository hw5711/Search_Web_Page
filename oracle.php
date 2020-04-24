<html>
<head>
<title>Search Result</title>
</head>

<body style="background-color:#f1f1f1">
	<p>Search Result: </p>
	<p>search query: $query_string</p>
	<form action="search.pl">
	
	<p>$proc_returns</p>
	</form>
</body>


</html>

<?php

putenv("LD_LIBRARY_PATH=/home/oracle/app/oracle/product/11.2.0/dbhome_1/lib");
putenv("ORACLE_HOME=/home/oracle/app/oracle/product/11.2.0/dbhome_1");
putenv("ORACLE_SID = csdbora");

$query_string =  $_SERVER["QUERY_STRING"];

$split = explode("&", $query_string);
$arg = array();
foreach($split as $x){

	$y = explode("=",$x);
	foreach($y as $f){
	  	array_push($arg,$f);
	}
}

if($arg[0]=='departmentNumber' && $arg[1] != 0)
{
	$executable='../c++/sample3 '.$arg[0].' '.$arg[1]	;
	echo shell_exec('whoami');
}
else if($arg[2]=='departmentName' )
{
	$executable='../c++/sample3 '.$arg[2].' '.$arg[3]	;
	echo shell_exec($executable);
}
if($arg[0]=='salaryLow' || $arg[0]=='commissionLow')
{
	$executable='../c++/sample3 '.$arg[0].' '.$arg[1].' '.$arg[3];
	echo shell_exec($executable);
}

$cmd = 'export LD_LIBRARY_PATH;'.$executable;
$result = shell_exec($cmd);
if (strlen($result)== 0)
    print "<p>No Result</p>";
else{
     print "<pre>";
     print $result;
     print "</pre>";
	}

?>
