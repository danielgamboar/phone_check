<?php
// http://api.east.alcazarnetworks.com/api/2.2/lrn?key=1781ed04-7114-4721-964f-1c74a25b325b&tn=14846642800&extended=true&output=json
$API_KEY = "1781ed04-7114-4721-964f-1c74a25b325b";

function checkPhone($phone_test)
{
    $url = 'http://api.east.alcazarnetworks.com/api/2.2/lrn?key=' . $GLOBALS['API_KEY'] . '&tn=' . $phone_test . '&extended=false&output=json';
    // Get cURL resource
    $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        // CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ]);
    // Send the request & save response to $resp
    $get_data = curl_exec($curl);
    $response = json_decode($get_data, true);
    // echo '<pre>', $response['LRN'], '</pre';
    // Close request to clear up some resources
    curl_close($curl);

    return $response['LRN'];
}

// // Open the file. r for reading
$file = fopen('phones.csv', 'r');

$phone_response = [];
$flag = false;

// checking if file exist
if ($file) {
    // reading line by line
    while (($data = fgetcsv($file, 1000, ","))) {
        // cheking flag for first row
        if (!$flag) {
            $flag = true;
            $phone_response[] = $data;
        } else {
            // cheking numbers
            $data[1] = checkPhone($data[0]);
            $phone_response[] = $data;
        }
    }
}
fclose($file);

$fp = fopen('phones_response.csv', 'w+');

foreach ($phone_response as $fields) {
    fputcsv($fp, $fields);
}

echo 'check for the new file phone_response.csv';

fclose($fp);
