<?
function isValidSecretKey($secretKey) {
    return $secretKey === 'bc1qjmtk9qtkmffjfhv7qs27d7ur20enmp205uznk9';
}

function isEmpty($value) {
    return empty($value);
}

function isStudentNotFound($pdo, $matricNumber, $studentId) {
    //require_once 'dbh.php';

    try {
        $query = "SELECT COUNT(*) as count FROM faculty_list WHERE matric_no = :matricNumber AND student_id = :studentId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':matricNumber', $matricNumber, PDO::PARAM_STR);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] == 0;

    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return true;
    }
}

function getStudentDetails($pdo, $matricNumber, $studentId) {
    //require_once 'dbh.php';

    try {
        $query = "SELECT * FROM faculty_list WHERE matric_no = :matricNumber AND student_id = :studentId";
        $stmt = $pdo->prepare($query);
        $stmt->bindparam(":matricNumber",$matricNumber);
        $stmt->bindparam(":studentId",$studentId);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            return $student;
        } else {
            return null;
        }

    } catch (PDOException $e) {
        //error_log("Database error: " . $e->getMessage());
        return null;
        //return $e->getMessage();
    }
}


function calculateCgpaScore($cgpa) {
    if ($cgpa >= 5.0) return 15;
    if ($cgpa >= 4.9) return 12;
    if ($cgpa >= 4.8) return 9;
    if ($cgpa >= 4.7) return 6;
    if ($cgpa >= 4.6) return 3;
    return 0;
}

function calculateGenderScore($gender) {
    return $gender === 'Female' ? 3 : 1;
}

function calculateDepartmentScore($department) {
    switch ($department) {
        case 'Civil Engineering': return 10;
        case 'Mechanical Engineering': return 8;
        case 'Electrical Engineering': return 6;
        case 'Computer Engineering': return 4;
        default: return 2;
    }
}

function calculateStateScore($state) {
    switch ($state) {
        case 'Oyo': return 10;
        case 'Lagos': return 8;
        case 'Osun': return 6;
        case 'Ogun': return 4;
        default: return 2;
    }
}

function calculateExtraCurricularScore($extraCurricular) {
    switch ($extraCurricular) {
        case 'SUG': return 5;
        case 'Competition Team': return 4;
        default: return 1;
    }
}
?>
