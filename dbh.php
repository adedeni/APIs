<?
$con = 'mysql:host=localhost; dbname=raolaksc_adedeni; charset=utf8';
$dbusername = "raolaksc";
$dbpassword = "Raolak123$";
try {
     $pdo = new PDO($con, $dbusername, $dbpassword);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed". $e->getMessage();
}