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
                $obj = json_decode($jsonObj);
                return $obj;
            }

            $massiveDest = getMassiveFromCsv();

            if (isset($_GET["numberTest"])):
                $num = $_GET["numberTest"] - 1;
                if (isset($massiveDest[$num])): 
                    $testObj = getAndDecodeJson($massiveDest, $num);?>
                    <form action='' method='POST'>
                    <?php
                    if(isset($testObj)):
                        foreach ($testObj as $key => $value): ?>
                            <fieldset>
                                <legend><?=$value->description; ?></legend>
                                <label><input type="radio" name="<?="q1".$key ?>" value="<?=$value->answer[0]; ?>"><?=$value->answer[0] ?></label>
                                <label><input type="radio" name="<?="q1".$key ?>" value="<?=$value->answer[1]; ?>"><?=$value->answer[1] ?></label>
                                <label><input type="radio" name="<?="q1".$key ?>" value="<?=$value->answer[2]; ?>"><?=$value->answer[2] ?></label>
                                <label><input type="radio" name="<?="q1".$key ?>" value="<?=$value->answer[3]; ?>"><?=$value->answer[3] ?></label>
                            </fieldset>
                        <?php
                        endforeach;
                    endif;
                    ?>
                    <?php if($_GET["numberTest"] != null): ?>
                        <input type='submit' value='Отправить' name="check">
                    </form>
                    <?php endif; ?>
                <?php
                endif;
            endif;
            
            if(isset($_POST['check'])):
                $sumtest = count($testObj)-1;
                $failedQustions = [];
                $massiveAnswers = arrayFrom($_POST);
                foreach ($testObj as $key => $value):
                    if($value->correct != $massiveAnswers[$key]):
                        $failedQustions[] = $key;
                    endif;
                    if($sumtest == $key):
                        break;
                    endif;
                endforeach;
                
                if(empty($failedQustions)):
                    echo "Поздравляем вы правильно ответили на все вопросы!";
                    ?>
                    <form action="" method="GET">
                        <label>
                            Введите свое имя для выдачи сертификата :)
                            <input type="text" name="nameWinner">
                            <input type="submit" name="pushName" value="Отправить">
                        </label>
                    </form>
                <?php
                else:
                    echo "Вы допустили ошибки в следующих вопросах";
                    foreach($failedQustions as $keys => $values):
                        echo "$keys";
                    endforeach;
                endif;
            endif;

            if (isset($_GET['pushName'])):
                var_dump("нажал на отправить");
                if(isset($_GET['nameWinner'])):
                    var_dump("нажал на отправить");
                    header('Content-type: image/jpeg');
                    $nameWinner = $_GET['nameWinner'];
                    $balls = count($sumtest) - $failedQustions;
                    $text = "$nameWinner Набрал(а) </br> $balls баллов";
                    $im = imagecreatetruecolor(200, 200)
                        or die("Невозможно инициализировать список gd");
                    $textcolor = imagecolorallocate($im, 233, 14, 91);
                    imageString($im, 1, 5, 5, $text, $textcolor);
                    imagepng($im);
                    imagedestroy($im);
                endif;
            endif;
            
            function arrayFrom ($fucObject) {
                $regularMassive = [];
                foreach($fucObject as $key => $value) {
                    $regularMassive[] = $value;
                }
                return $regularMassive;

            }
            ?>
        </body>
    </html>