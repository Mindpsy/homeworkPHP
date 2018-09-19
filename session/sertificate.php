<?php
    if(isset($_GET['nameWinner'])):
        header('Content-type: image/jpeg');
        $handle = fopen("test.png", "ab");
        $nameWinner = $_GET['nameWinner'];
        $result = $_GET['result'];
        $text = "{$nameWinner} collects {$result} balls!";
        $im = imagecreatetruecolor(200, 200)
            or die("Невозможно инициализировать список gd");
        $textcolor = imagecolorallocate($im, 233, 14, 91);
        imageString($im, 4, 5, 90, $text, $textcolor);
        imagepng($im);
        imagedestroy($im);
    endif;
?>