<!DOCTYPE>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Список тестов</title>
        </head>
        <body>
            <table>
                <tr>
                    <td>Номер теста</td>
                    <td>Название теста</td>
                    <td>Путь теста</td>
                    <td>Пройти тест</td>
                </tr>
                <?php
                function getMassiveTests () {
                    $massiveRows = [];
                    $handle = fopen("./tests/list.csv", "rb");
                    if($handle) {
                        $row =  fgetcsv($handle);
                        while ($row) {                            
                            $massiveRows[] = $row;
                            $row =  fgetcsv($handle);
                        }
                        fclose($handle);
                        return $massiveRows;
                    }
                }
                $massiveTests = getMassiveTests();

                for ($i = 0; $i < count($massiveTests); $i++) {
                    $num = $i + 1;
                    $nameTest =$massiveTests[$i][0];
                    $pathTest = $massiveTests[$i][1];
                    echo "<tr>";
                    echo "<td>$num</td>";
                    echo "<td>$nameTest</td>";
                    echo "<td>$pathTest</td>";
                    echo "<td>Пройти</td>";
                    echo "</tr>";
                }
                ?>
            </table>

        </body>
    </html>