<?php
$errorArgum1 = "Ошибка! Аргументы заданы неверно. Укажите флаг --today или запустите скрипт с аргументами {цена} и {описание покупки}";
$errorNoArgum = "Ошибка! Аргументы не заданы. Укажите флаг --today или запустите скрипт с аргументами {цена} и {описание покупки}";
if ($argv[1] == "--today") {
    today();
} elseif ($argv[1] == NULL || $argv[2] == NULL) {
    var_dump($errorNoArgum);
} else {
    if ($argv[1]) {
        if (!is_numeric($argv[1])) {
            var_dump($errorArgum1);
        } else {
            addNew ($argv);
        }
    }
    
}

function today () 
{
    $handleToday = fopen("./data.csv", "rb");
    $data = fgetcsv($handleToday, 100, ",");
    $sumToday = 0;
    while ($data) {
        if ($data[0] == date('Y-m-d')) {
            $sumToday += $data[1];
            }
        $data = fgetcsv($handleToday, 100, ",");
    }
    if ($sumToday > 0) {
        $nowDate = date('Y-m-d');
        var_dump("$nowDate расход за день: $sumToday руб.");
    } else {
        var_dump('Нет записей за сегодня');
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
