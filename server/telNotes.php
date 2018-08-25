<?php
echo "<!DOCTYPE>";
echo "<html>";
echo "<head>";
echo "<title>";
echo "</title>";
echo "<meta charset='UTF-8'>";
echo "<meta name='vievport' content='width=device-width'>";
echo "</head>";
echo "<body>";
echo "<table>";
echo "<tr>";
echo "<td>Имя</td>";
echo "<td>Фамилия</td>";
echo "<td>Адрес</td>";
echo "<td>Номер телефона</td>";
echo "</tr>";
                
$jsonNotes = file_get_contents("./jsonNotes.json");
$objectNotes = json_decode($jsonNotes);
foreach($objectNotes as $value ) {
    echo "<tr>";
    echo "<td>$value->firstName</td>";
    echo "<td>$value->lastName</td>";
    echo "<td>$value->address</td>";
    echo "<td>$value->phoneNumber</td>";
    echo "</tr>";
}
echo "</table>";
echo "</body>";
echo "</html>";
    ?>