<?php 
$urlVisa = "./dataVisa.csv";

function readData ($url, $namesC) 
{
    $handleVisa = fopen("./dataVisa.csv", "rb");
    var_dump($handleVisa);
    $tempData = fgetcsv($handleVisa, 100, ",");
    $massiveData = array();
    while ($tempData) {
        if ($tempData[1] !== NULL) {
            $massiveData += [$tempData[1]=>$tempData[4]];
            $namesC[] = $tempData[1];
            var_dump($tempData[1]);
            $tempData = fgetcsv($handleVisa, 100, ",");
        }
        $tempData = fgetcsv($handleVisa, 100, ",");
        var_dump("попался NULL");
    }
    fclose($handleVisa);
    return $massiveData;
}

$massiveNamesC = array();
$dataBase = readData($urlVisa, $massiveNamesC);

function searchCountry ($qCountry, $dataVisa) 
{
    if (array_key_exists($qCountry, $dataVisa)) {
        $valueVisa = $dataVisa[$qCountry];
        var_dump("Result: \r\n");
        var_dump("$qCountry: $valueVisa");
    } elseif (!array_key_exists($qCountry, $dataVisa)) {
        var_dump("Проверьте пожалуйста правилльность написания Страны и попробуйте снова.");
    }
}



function imLevenshtein($inWord, $baseWord) 
{
    // введенное слово с опечаткой
    $input = $inWord;
    // массив сверяемых слов
    $words = $baseWord;
    // кратчайшее расстояние пока еще не найдено
    $shortest = -1;
    // проходим по словам для нахождения самого близкого варианта
    foreach ($words as $word) {
        // вычисляем расстояние между входным словом и текущим
        $lev = levenshtein($input, $word);
        // проверяем полное совпадение
        if ($lev == 0) {
            // это ближайшее слово (точное совпадение)
            $closest = $word;
            $shortest = 0;
            // выходим из цикла - мы нашли точное совпадение
            break;
        }
        // если это расстояние меньше следующего наименьшего расстояния
        // ИЛИ если следующее самое короткое слово еще не было найдено
        if ($lev <= $shortest || $shortest < 0) {
            // устанивливаем ближайшее совпадение и кратчайшее расстояние
            $closest  = $word;
            $shortest = $lev;
        }
        if ($shortest == 0) {
            return $closest;
        } else {
            return $closest;
        }
    }
}

// с проверкой левенштейна чет не хочет 
/*
searchCountry(imLevenshtein($argv[1], $massiveNamesC), $dataBase);
$vr = imLevenshtein($argv[1], $massiveNamesC);
*/
searchCountry($argv[1], $dataBase);

var_dump($vr);

?>