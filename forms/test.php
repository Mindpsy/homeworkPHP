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
                if ($handle) {
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
                $obj = json_decode($jsonObj);
                return $obj;
            }

            $massiveDest = getMassiveFromCsv();

            if (isset($_GET["numberTest"])):
                $num = $_GET["numberTest"];
                if (isset($massiveDest[$num-1])):
                    $testObj = getAndDecodeJson($massiveDest, $_GET["numberTest"]);?>
                    <form action='' method='POST'>
                    <?php
                    if (isset($testObj)):
                        foreach ($testObj as $key => $value):?>
                            <fieldset>
                                <legend><?=$value->description; ?></legend>
                                <label><input type="radio" name="<?="q1".$key ?>"><?=$value->answer[0] ?></label>
                                <label><input type="radio" name="<?="q1".$key ?>"><?=$value->answer[1] ?></label>
                                <label><input type="radio" name="<?="q1".$key ?>"><?=$value->answer[2] ?></label>
                                <label><input type="radio" name="<?="q1".$key ?>"><?=$value->answer[3] ?></label>
                            </fieldset>
                        <?php 
                        endforeach;
                    endif;
                endif;
            endif;?>
                        <input type="submit" value="Отправить" name="check">
                    </form>
            <?php
            if(isset($_POST["check"])):
                $sumtest = count($testObj)-1;
                $failedQustions = [];

                foreach ($testObj as $key => $value):
                    if($sumtest == $key):
                        break;
                    endif;
                    if($value->correct != $POST[$key]):
                        $failedQustions[] = $key;
                    endif;
                endforeach;
                
                if(empty($failedQustions)):
                    echo "Поздравляем вы правильно ответили на все вопросы!";
                else:
                    echo "Вы допустили ошибки в следующих вопросах";
                    foreach($failedQustions as $keys => $values):
                        echo "$keys";
                    endforeach;
                endif;
            endif;
            ?>
            </body>
        </html>