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


            function getAndDecodeJson ($path) {
                $jsonObj = file_get_contents("tests/$path");
                $obj = json_decode($jsonObj);
                return $obj;
            }

            if (isset($_GET["numberTest"])):
                $dirTest = $_GET["numberTest"];
                ?>
                    <form action='' method='POST'>
                    <?php
                    if(is_file("tests/$dirTest")):
                        $testObj = getAndDecodeJson ($dirTest);
                        foreach ($testObj as $key => $value): ?>
                            <fieldset>
                                <legend><?=$value->description; ?></legend>
                                <?php foreach($value->answer as $k => $v): ?>
                                    <label><input type="radio" name="<?="q1".$key ?>" value="<?=$v; ?>"><?=$v ?></label>
                                <?php endforeach; ?>
                            </fieldset>
                        <?php
                        endforeach;
                    endif;
                    if($_GET["numberTest"] != null): ?>
                        <input type='submit' value='Отправить' name="check">
                    </form>
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
                    echo "</br> Поздравляем вы правильно ответили на все вопросы!";
                else:
                    echo "</br> Вы допустили ошибки в следующих номерах вопросов:";
                    foreach($failedQustions as $keys => $values):
                        $fq = $values + 1;
                        echo "</br> $fq";
                    endforeach;
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