<?php 
function getApiBook ($queryUser) 
{
    $encodeQuery = urlencode($queryUser);
    $apiData = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=$encodeQuery");
    var_dump($apiData);
}

function writeToCsv ($data, $destionation) {
    $handle = fopen($destionation, "wb");
    if($handle) {
        fputcsv($handle, $data);
        fclose($handle);
    }
}

getApiBook($argv[1]);

?>