<?php 
$massiveNamesC = array();
$dataBase = readData($massiveNamesC);

if (isset($argv[1])) {
    searchCountry($argv[1], $dataBase);
} else {
    echo "Введите название страны";
}



function readData ($namesC) 
{
    $handleVisa = fopen("./dataVisa.csv", "rb");
    if($handleVisa) {
        $tempData = fgetcsv($handleVisa, 100, ",");
        $massiveData = array();
        while ($tempData) {
            if (isset($tempData[1]) && isset($tempData[4])) {
                $massiveData += [$tempData[1]=>$tempData[4]];
                $namesC[] = $tempData[1];
                
            }
            $tempData = fgetcsv($handleVisa, 100, ",");
        }
        fclose($handleVisa);
    }
    return $massiveData;
}

function searchCountry ($qCountry, $dataVisa) 
{
    if (array_key_exists($qCountry, $dataVisa)) {
        $valueVisa = $dataVisa[$qCountry];
        echo "Result: \r\n";
        echo "$qCountry: $valueVisa";
    } elseif (!array_key_exists($qCountry, $dataVisa)) {
        echo "Проверьте пожалуйста правилльность написания Страны и попробуйте снова.";
    }
}

?>