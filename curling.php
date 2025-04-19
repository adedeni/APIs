<?php
$url = 'https://raolakschool.org/api_endpoint.php';

$inputs = [
    'userName' => 'ADEDENI',
    'Age' => 'under-18',
    'phone_number' => '09036176161'
];


$curlInit = curl_init();
curl_setopt($curlInit, CURLOPT_URL, $url);
curl_setopt($curlInit, CURLOPT_POST, 1);
curl_setopt($curlInit, CURLOPT_POSTFIELDS, json_encode($inputs));
curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

$headers = [
  "secret-key: bcdsftevt6w7ttqocbwqtctct4tbhf",
  "Content-Type: application/json",
];
curl_setopt($curlInit, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($curlInit);

if ($response === false) {
    echo "API can't be called: " . curl_error($curlInit);
} else {
    $input = json_decode($response, true);

    if (isset($input['code']) && isset($input['message'])) {
        print_r($input);
        echo '<br><br>';
        echo 'code: ' . $input['code'] . '<br><br>';
        echo 'message: ' . $input['message'];
    } else {
        echo "Input code or message is not set";
    }
}

curl_close($curlInit);