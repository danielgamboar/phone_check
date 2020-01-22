<?php
$API_KEY = "";

function checkPhone($phone_test)
{
    $url = 'http://api.east.alcazarnetworks.com/api/2.2/lrn?key=' . $GLOBALS['API_KEY'] . '&tn=' . $phone_test . '&extended=true&output=json';
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
    echo '<pre>', var_dump($response), "</pre>";
?>
    <br>
<?php
    // Close request to clear up some resources
    curl_close($curl);

    return $response;
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
            $resp = checkPhone($data[0]);
            $data[1] = $resp["LRN"];
            $data[2] = $resp["SPID"];
            $data[3] = $resp["OCN"];
            $data[4] = $resp["LATA"];
            $data[5] = $resp["CITY"];
            $data[6] = $resp["STATE"];
            $data[7] = $resp["JURISDICTION"];
            $data[8] = $resp["LEC"];
            $data[9] = $resp["LINETYPE"];
            $data[10] = $resp["DNC"];
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
