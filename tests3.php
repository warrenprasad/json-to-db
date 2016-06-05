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
$tdate = htmlspecialchars($_GET["xdate"]);
$tcity = htmlspecialchars($_GET["xcity"]);
$target = 1;
$myfile = fopen("KOL-TEMPDATA01.txt", "a+") or die("Unable to open file!");

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else 
{
	echo "SUCCESS in Connecting to DB.........";
}
    
        $sqltime = "SELECT time_set_unix FROM time_set where time_set_id=".$tdate;
		$resulttime = mysqli_query($conn, $sqltime);
		$rowtime = mysqli_fetch_assoc($resulttime);
		$timecheck = $rowtime['time_set_unix'];

        
        $condition = $forecast->getHistoricalConditions(22.5727, 88.3639, $rowtime['time_set_unix']);
		
		
		echo "<br>MAX Temperatur: ". $condition->getMaxTemperature(). "\n";
		echo "<br>MIN Temperatur: ". $condition->getMinTemperature(). "\n";
		echo "<br>Humidity : ". $condition->getHumidity(). "\n";
		echo "<br>Summary : ". $condition->getSummary(). "\n";
		echo "<br>Icon : ". $condition->getIcon(). "\n";
		echo "<br>Time: ".$timecheck;
		echo "<br>Date: ".$tdate;
		
		
		$maxtemp = $condition->getMaxTemperature(); if($maxtemp==NULL){$maxtemp=0; echo"MAX TEMP SET TO 0".$maxtemp;}
		$mintemp = $condition->getMinTemperature();
		$hum = $condition->getHumidity();
		$summary = $condition->getSummary();
		$icon = $condition->getIcon();
		$str1 = "$tdate, $timecheck , '$summary', '$icon', $mintemp, $maxtemp, $hum";
		echo "<br>".$str1;
		fwrite($myfile, "\n");
		fwrite($myfile, $str1);

mysqli_close($conn);
?> 
