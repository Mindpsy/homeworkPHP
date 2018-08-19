<?php
function getMeteoInfo ($nameCity) {
    $response = file_get_contents("https://samples.openweathermap.org/data/2.5/weather?q=$nameCity&appid=5ba0e778860bd1ac395efb34b8f5e0fb");
    return $response;
}

$x = $_GET['x'];
$data = getMeteoInfo($x);
$objData = json_decode($data);
echo "$data";

$city = $objData->name;
$weatherIcon = $objData->weather[0]->icon;
$weatherDescription = $objData->weather[0]->description;
$temp = $objData->main->temp;
$tempMax = $objData->main->temp_max;
$tempMin = $objData->main->temp_min;
$windSpeed = $objData->wind->speed;

echo "<hr>";
echo "Weather in $city";
echo "</br><img src='http://openweathermap.org/img/w/$weatherIcon.png'>";
echo "</br>$weatherDescription";
echo "</br>Curent temperature: $temp";
echo "</br>Min temperature: $tempMin";
echo "</br>Max temperature: $tempMax";
echo "</br>Wind speed: $windSpeed m/s";




?>