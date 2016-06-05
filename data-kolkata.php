<?php
include('lib/forecast.io.php');
$api_key = '09374f27ca7488a9a67dc7f3907e518f';
$servername = "localhost";
$username = "root";
$password = "root123";
$dbname = "testw1";
$units = 'si'; 
$lang = 'en'; 
$forecast = new ForecastIO($api_key, $units, $lang);


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else 
{
	echo "SUCCESS in Connecting to DB \n";
}

// Performing SQL query
$sql = "SELECT MAX(hist_data_time_set_id) from testw1.hist_data_01 where hist_data_city_id = 2;";
$result1 = mysqli_query($conn, $sql);
$rowtime1 = mysqli_fetch_assoc($result1);
$timeset = $rowtime1['MAX(hist_data_time_set_id)'];

echo "\nTIME SET ID".$timeset;

if ($timeset > 0)
{
	$timeset = $timeset+1;
}
else
{
	$timeset = 1;
}

        $sqltime = "SELECT time_set_unix FROM time_set where time_set_id=".$timeset;
		$resulttime = mysqli_query($conn, $sqltime);
		$rowtime = mysqli_fetch_assoc($resulttime);
		$timecheck = $rowtime['time_set_unix'];

        
        $condition = $forecast->getHistoricalConditions(22.5727, 88.3639, $rowtime['time_set_unix']);
		
		
		echo "\nMAX Temperatur: ". $condition->getMaxTemperature();
		echo "\nMIN Temperatur: ". $condition->getMinTemperature();
		echo "\nHumidity : ". $condition->getHumidity();
		echo "\nSummary : ". $condition->getSummary();
		echo "\nIcon : ". $condition->getIcon();
		echo "\nTime: ".$timecheck;

		
		$maxtemp = $condition->getMaxTemperature(); 
		if($maxtemp==NULL){$maxtemp=0; echo"\nMAX TEMP SET TO 0".$maxtemp;}
		$mintemp = $condition->getMinTemperature();
		if($mintemp==NULL){$mintemp=0; echo"\nMIN TEMP SET TO 0".$mintemp;}
		$hum = $condition->getHumidity();
		if($hum==NULL){$hum=0; echo"\nHUMIDITY SET TO 0".$hum;}
		$summary = $condition->getSummary();
		if($summary==NULL){$summary="\nNo Weather Description found"; echo"Summary SET TO DEFAULT".$hum;}
		$icon = $condition->getIcon();
		if($icon==NULL){$icon="default"; echo"icon SET TO DEFAULT".$hum;}
		$sql2 = "INSERT into hist_data_01 (hist_data_city_id, hist_data_time_set_unix, hist_data_summary, hist_data_icon, hist_data_temprature_min, hist_data_temprature_max, hist_data_humidity, hist_data_time_set_id) 
		VALUES ('2', $timecheck , '$summary', '$icon', $mintemp, $maxtemp, $hum, $timeset )";
		
		if ($conn->query($sql2) === TRUE) {
			echo "\nNew record created successfully ----- \n";
		} else {
			echo "Error: " . $sql2 . "\n" . $conn->error;
		}
		
		
		

mysqli_close($conn);
?> 
