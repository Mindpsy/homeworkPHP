<!DOCTYPE>
    <html>
        <head>
            <title></title>
            <meta charset='UTF-8'>
            <meta name='vievport' content='width=device-width'>
        </head>
        <body>
            <table>
                <tr>
                    <td>Имя</td>
                    <td>Фамилия</td>
                    <td>Адрес</td>
                    <td>Номер телефона</td>
                </tr>
                <?php               
                    $jsonNotes = file_get_contents("./jsonNotes.json");
                    $objectNotes = json_decode($jsonNotes, true);
                    foreach($objectNotes as $value ) {
                        echo "<tr>";
                        echo "<td>$value[firstName]</td>";
                        echo "<td>$value[lastName]</td>";
                        echo "<td>$value[address]</td>";
                        echo "<td>$value[phoneNumber]</td>";
                        echo "</tr>";
                    }
                    ?>
            </table>
        </body>
    </html>
    