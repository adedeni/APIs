<?
// error_reporting(E_ALL);
// ini_set('display_errors',1);
require_once 'functions.php';
require_once 'dbh.php';

$data = json_decode(file_get_contents("php://input"), true);

$matricNumber = $data['matric_no'];
$studentId = $data['student_id'];

$response = [];


$secretKey = $data['secretKey'] ?? null;
$cgpa = $data['cgpa'] ?? null;
$gpa = $data['gpa'] ?? null;
$age = $data['age'] ?? null;
$level = $data['level'] ?? null;
$department = $data['department'] ?? null;
$state = $data['state'] ?? null;
$gender = $data['gender'] ?? null;
$extraCurricular = $data['extraCurricular'] ?? null;

$studentDetails = getStudentDetails($pdo, $matricNumber, $studentId);
if (!$matricNumber || !$studentId) {
    $response = [
        'code' => 'COD422',
        'message' => 'Incomplete parameters: Matric Number or Student ID not supplied'
    ];
} else if (isStudentNotFound($pdo, $matricNumber, $studentId)) {
    $response = [
        'code' => 'COD404',
        'message' => 'Student not found'
    ];
} else if(!$studentDetails){
         $response = [
        'code'=> 'COD124',
        'message'=> 'Student ID/ Matric not exist '
        ];
}
else if ($studentDetails['age'] < 18){
      $response = [
        'code'=> 'COD125',
        'message'=> 'The is scholarship is meant for students older than 18 years old'
        ];
}
else if ($studentDetails['level'] < 400){
      $response = [
        'code'=> 'COD126',
        'message'=> "The student is currently in {$studentDetails['level']} level, and this scholarship is meant for students in 400 level and above"
        ];
}
else if ($studentDetails['CGPA'] < 4.5){
      $response = [
        'code'=> 'COD127',
        'message'=> "Student's CGPA is less than 4.5"
        ];
}
else if ($studentDetails['GPA'] < 4.5){
      $response = [
        'code'=> 'COD128',
        'message'=> "Student's last Semester GPA is less than 4.5"
        ];
}
else{
    
    $cgpaScore = calculateCgpaScore($cgpa);
    $genderScore = calculateGenderScore($gender);
    $departmentScore = calculateDepartmentScore($department);
    $stateScore = calculateStateScore($state);
    $extraCurricularScore = calculateExtraCurricularScore($extraCurricular);

    $totalScore = (($cgpaScore + $genderScore + $departmentScore + $stateScore + $extraCurricularScore) / 43) * 100;

    $response = [
        'code' => 'COD200',
        'message' => 'The student has been successfully verified and is eligible for the scholarship. Below are the details:',
        'basicData' => [
            "fullName" => $studentDetails['fullName'],
            "matricNumber" => $matricNumber,
            "studentId" => $studentId,
            "score" => $totalScore,
            'scholarshipDetails' => [
            "cgpa" => $studentDetails['CGPA'],
            "gpa" => $studentDetails['GPA'],
            "state" => $studentDetails['state'],
            "extra_curricular" => $studentDetails['extra_curricular'],
            "department" => $studentDetails['department'],
            "gender" => $studentDetails['gender']
            ]
        ]
        
    ];
}


echo json_encode($response);