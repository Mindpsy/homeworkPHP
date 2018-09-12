<?php 
$massiveNamesC = array();
$dataBase = readData($massiveNamesC);

searchCountry($argv[1], $dataBase);



function readData ($namesC) 
{
    $handleVisa = fopen("./dataVisa.csv", "rb");
    $countNulls = 0;
    if($handleVisa) {
        $tempData = fgetcsv($handleVisa, 100, ",");
        $massiveData = array();
        while ($tempData) {
            if ($tempData[1] !== NULL) {
                $massiveData += [$tempData[1]=>$tempData[4]];
                $namesC[] = $tempData[1];
                $tempData = fgetcsv($handleVisa, 100, ",");
            }
            if ($tempData[1] == NULL) {
            $tempData = fgetcsv($handleVisa, 100, ",");
            $countNulls++;
            }
        }
        fclose($handleVisa);
    }
    echo "Число Нулов за все циклы: $countNulls \r\n";
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