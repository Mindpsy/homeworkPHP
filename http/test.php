<?php 
session_start();
$nameWinner = $_SESSION['name'];
?>
<!DOCTYPE>
    <html>
        <head>
            <meta charset="utf-8">
            <title>Прохождение теста</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    
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
                    echo "Поздравляем вы правильно ответили на все вопросы!";
                    if(!$_SESSION['adminStatus'] && !$_SESSION['guestStaus']):?>
                    <form action="" method="GET">
                        <label>
                            Введите свое имя для выдачи сертификата :)
                            <input type="text" name="nameWinner">
                            <input type="submit" name="pushName" value="Отправить">
                        </label>
                    </form>
                <?php
                    else:
                        $balls = ($sumtest - count($failedQustions)) + 1;
                        $imgName = $_SESSION['name']; ?>
                    <br/>
                    <img src=<?="sertificate.php?nameWinner={$imgName}&result={$balls}" ?> />
                <?php 
                    endif;       
                else:
                    echo "Вы допустили ошибки в следующих вопросах";
                    foreach($failedQustions as $keys => $values):
                        echo "$keys";
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