<?
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require_once 'functions.php';

$url = 'https://adedeni.raolakschool.org/APIs/scholarshipEndPoint.php';

$data = [
    'student_id' => '22',
    'matric_no'=> '871200'
];

$curlInit = curl_init();
curl_setopt($curlInit, CURLOPT_URL, $url);
curl_setopt($curlInit, CURLOPT_POST, 1);
curl_setopt($curlInit, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);

$headers = [
    "secret-key: bc1qjmtk9qtkmffjfhv7qs27d7ur20enmp205uznk9",
    "Content-Type: application/json",
];
curl_setopt($curlInit, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($curlInit);

if ($response === false) {
    echo "API can't be called: " . curl_error($curlInit);
} else {

    $data = json_decode($response, true);

    if (isset($data['code']) && isset($data['message'])) {
        if($data['code'] == 'COD200'){
         $score = $data['basicData']['score'];
         $convertedScore = number_format($score, 2);
        echo "CODE: {$data['code']}</br>";
        echo "MESSAGE: {$data['message']}<br/>";
        echo  "MATRIC NO: {$data['basicData']['matricNumber']}<br/>
              STUDENT ID: {$data['basicData']['studentId']}<br/>
              DEPARTMENT: {$data['basicData']['scholarshipDetails']['department']}<br/>
              STATE: {$data['basicData']['scholarshipDetails']['state']}<br/>
              GENDER: {$data['basicData']['scholarshipDetails']['gender']}<br/>
              LAST SEMESTER GPA: {$data['basicData']['scholarshipDetails']['gpa']}<br/>
              CGPA: {$data['basicData']['scholarshipDetails']['cgpa']}<br/>
              SCORE: $convertedScore%<br/>
              ";
        }
    } else {
        echo 'Unexpected response format';
    }
 }

curl_close($curlInit);