<?php
header("content-type: application/json"); 
$servername = "localhost";
$username = "root";
$password = "root123";
$dbname = "testw1";
$xdata = htmlspecialchars($_GET["xdata"]);

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($xdata == "MAX") 
	{ 
		$zdata = "hist_data_temprature_max"; 
		$sql1 = "select hist_data_time_set_unix, $zdata from hist_data_01";
		$result = mysqli_query($conn, $sql1) or die("Error in Selecting " . mysqli_error($conn));
		$emparray = array();
		while($row =mysqli_fetch_assoc($result))
		{
			$emparray[] = array( intval($row['hist_data_time_set_unix'])*1000, floatval($row[$zdata]) );
		}	
	}
elseif ($xdata == "MIN") 
	{ 
		$zdata = "hist_data_temprature_min"; 
		$sql1 = "select hist_data_time_set_unix, $zdata from hist_data_01";
		$result = mysqli_query($conn, $sql1) or die("Error in Selecting " . mysqli_error($conn));
		$emparray = array();
		while($row =mysqli_fetch_assoc($result))
		{
			$emparray[] = floatval($row[$zdata]);
		}
	}
elseif ($xdata == "HUM") 
	{ 
		$zdata = "hist_data_humidity"; 
		$sql1 = "select hist_data_time_set_unix, $zdata from hist_data_01";
		$result = mysqli_query($conn, $sql1) or die("Error in Selecting " . mysqli_error($conn));
		$emparray = array();
		while($row =mysqli_fetch_assoc($result))
		{
			$emparray[] = array( intval($row['hist_data_time_set_unix'])*1000, floatval($row[$zdata])*100 );
		}
	}

echo $_GET['callback']. '({"pointStart":315513000000,"pointInterval":86400000,"dataLength":3518,"data":'. json_encode($emparray) . '});'; 
 
mysqli_close($conn);
?> 
