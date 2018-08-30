<!DOCTYPE>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Прохождение теста</title>
        </head>
        <body>
            <form action="./test.php" method="get">
                <input name="numberTest" type="text">
                <input type="submit">
            </form>
            <?php

            function getMassiveFromCsv () {
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

            function getAndDecodeJson ($massive, $questionNum) {
                $url = $massive["$questionNum"][1];
                $jsonObj = file_get_contetns($url);
                $obj = json_decode($jsonObj);
                return $obj;
            }

            $massiveDest = getMassiveFromCsv();

            if ($_GET) {
                var_dump($_GET);
                $num = $_GET["numberTest"];
                if ($massiveDest[$num]) {
                    $testObj = getAndDecodeJson($massiveDest, $_GET["numberTest"]);
                    echo "<form action='' method='POST'>";
                    echo "<fieldset>";
                    echo "<legend>Сколько граммов в одном килограмме?</legend>";
                    echo "<label><input type='radio' name='q1'> 10</label>";
                    echo "<label><input type='radio' name='q1'> 100</label>";
                    echo "<label><input type='radio' name='q1'> 1000</label>";
                    echo "<label><input type='radio' name='q1'> 10000</label>";
                    echo "</fieldset>";
                    echo "<fieldset>";
                    echo "<legend>Сколько метров в одном дециметре?</legend>";
                    echo "<label><input type='radio' name='q2'> 100</label>";
                    echo "<label><input type='radio' name='q2'> 10</label>";
                    echo "<label><input type='radio' name='q2'> 0.1</label>";
                    echo "<label><input type='radio' name='q2'> 0.01</label>";
                    echo "</fieldset>";
                    echo "<input type='submit' value='Отправить'>";
                    echo "</form>";
                }
            }


            ?>
        </body>
    </html>