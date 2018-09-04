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

            function getAndDecodeJson ($massive, $testNum) {
                $url = $massive[$testNum][1];
                $jsonObj = file_get_contents($url);
                $obj = json_decode($jsonObj, true);
                return $obj;
            }

            $massiveDest = getMassiveFromCsv();

            if (isset($_GET["numberTest"])) {
                $num = $_GET["numberTest"];
                if (isset($massiveDest[$num-1])) { 
                    $testObj = getAndDecodeJson($massiveDest, $_GET["numberTest"]);?>
                    <form action='' method='POST'>
                    <?php
                    if(isset($testObj)) {
                    foreach ($testObj as $key => $value) { ?>
                        <fieldset>
                            <legend><?=$value->description; ?></legend>
                            <label><input type="radio" name="q11"><?=$testObj->description; ?></label>
                            <label><input type="radio" name="q12"><?=$testObj->description; ?></label>
                            <label><input type="radio" name="q13"><?=$testObj->description; ?></label>
                            <label><input type="radio" name="q14"><?=$testObj->description; ?></label>
                        </fieldset>
                    <?php }
                    }
                    ?>
                        <input type='submit' value='Отправить'>
                    </form>
                <?php
                }
            }?>
        </body>
    </html>