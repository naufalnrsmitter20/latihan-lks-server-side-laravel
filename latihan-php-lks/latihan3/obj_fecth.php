<?php 

$file_name = "data.json";
$data = fopen($file_name, "r") or die ("Failed to read " . $file_name);
$data_decode = json_decode(fread($data, filesize($file_name)));
fclose($data);

if($data_decode === null){
    die("Failed to decode JSON" . json_last_error_msg());
};

foreach ($data_decode as $key => $value) {
    echo "Record " . $key + 1 . "\n";
    echo "Id : " . $value->id . "\n";
    echo "first_name : " . $value->first_name . "\n";
    echo "last_name : " . $value->last_name . "\n";
    echo "created : " . $value->created . "\n";
    echo "updated : " . $value->updated . "\n";
    echo "\n";
};

?>