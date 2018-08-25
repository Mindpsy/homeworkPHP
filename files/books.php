<?php 
function getApiBook ($queryUser) 
{
    $encodeQuery = urlencode($queryUser);
    $apiData = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=$encodeQuery");
    return json_decode($apiData);
}

function chekJsonData ($encodedJson)
    {
        $last_error = json_last_error();
        if(json_last_error()) {
            json_last_error_msg();
        }
        
    }

function writeInCsv ($destinationWrite, $massiveData) 
    {
        $handleWrite = fopen($destinationWrite, "wb"); 
        if($handleWrite) {
            foreach($massiveData as $name=>$value){
                $row = [$value->id, $value->volumeInfo->title, implode($value->volumeInfo->    authors)];
                fputcsv($handleWrite, $row);
            }
        }
        fclose($handleWrite);
    }

$searchString = implode(array_slice($argv, 1));
$apiObj = getApiBook($searchString);

$urlFile = "./books.csv";
writeInCsv($urlFile, $apiObj->items);

?>