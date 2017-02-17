<?php
include_once '../klase/dbconfig.php';
if(!$user->is_loggedin()) {
	$user->redirect('../index.php');
}
if (isset($_GET['logout'])) {
    $user->logout();
    $user->redirect("../index.php");
}

$user_id = $_SESSION['user_session'];
$vrsta = $_SESSION['vrsta'];
if ($vrsta == 2) {
	$stmt = $DB_con->prepare("SELECT * FROM partneri WHERE idPartnera=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
} 
else if ($vrsta == 1) {
	$stmt = $DB_con->prepare("SELECT * FROM preduzeca WHERE idPreduzeca=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
}
else {
	$user->logout();
	$user->redirect("../index.php");
}
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);	

$naziv = $userRow['naziv'];
?>


<!DOCTYPE html>
<html>

	<head>
		<title><?php print($naziv); ?></title>
	</head>

	<body>
		<a href="home.php?logout=true"><i class="glyphicon glyphicon-log-out"></i> logout</a>
		<h1> <?php print($naziv) ?> </h1>
  	</body>

</html>