<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$errorArgum1 = "Ошибка! Аргументы заданы неверно. Укажите флаг --today или запустите скрипт с аргументами {цену цифрой} и {описание покупки}";
$errorNoArgum = "Ошибка! Перввый аргумент задан не верно. Укажите флаг --today или запустите скрипт с аргументами {цена цифрой} и {описание покупки}";
$errorArgum2 = "Ошибка! Аргументы заданы неверно. Укажите флаг --today или запустите скрипт с аргументами {цена цифрой} и {описание покупки текст}";

if (isset($argv[1])) {
    if($argv[1] == "--today") {
        today();
    } else if (!is_numeric($argv[1])) {
        echo $errorArgum1;
    } elseif (isset($argv[2])) {
        if(is_numeric($argv[1]) && !is_string($argv[2])) {
            echo $errorArgum2;
        } elseif (is_numeric($argv[1]) && is_string($argv[2])) {
            addNew ($argv);
            $tmpDate = date('Y-m-d');
            $tmpPrice = $argv[1];
            $tmpDescr = $argv[2];
            echo "Добавлена строка: $tmpDate, $tmpPrice, $tmpDescr";
        }
    } 
} elseif (!isset($argv[1]) || !isset($argv[2])) {
    echo $errorNoArgum;
}

function today () 
{
    $handleToday = fopen("./data.csv", "rb");
    $data = fgetcsv($handleToday, 100, ",");
    $sumToday = 0;
    while ($data) {
        if(!empty($data[0])) {
            if ($data[0] == date('Y-m-d')) {
                $sumToday += $data[1];
            }
        }
        $data = fgetcsv($handleToday, 100, ",");
    }
    if ($sumToday > 0) {
        $nowDate = date('Y-m-d');
        echo "$nowDate расход за день: $sumToday руб.";
    } else {
        echo 'Нет записей за сегодня';
    }
    fclose($handleToday);
}

function addNew ($entryes) 
{
    $handleNew = fopen("./data.csv", "ab");
    $currentData = date('Y-m-d');
    $valueExpense = $entryes[1];
    $description = implode(" ", array_slice($entryes, 2));
    $newExpense = [$currentData, $valueExpense, $description];
    fputcsv($handleNew, $newExpense);
    fclose($handleNew);

}
?>
