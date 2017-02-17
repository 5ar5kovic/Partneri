<?php
include_once '../klase/dbconfig.php';
if(!$user->is_loggedin()) {
	$user->redirect('../index.php');
}
	$partner = $_SESSION['user_session'];
?>
<!DOCTYPE html>

<html>
	<head>
		<title> Izvestaj </title>
		<link rel="stylesheet" href="../css/home.css">
	</head>

	<body>
	<div class="container">
	<div class="logout">
	<a href="partner.php"> Nazad </a>
	</div>
	<br/> <br/> <br/>
	<div class="box">
	<form method="POST" action="#">
			<div class="izvestaj">
	        Izvestaj od
	        <input type="date" name="d1"/>
	        do
	        <input type="date" name="d2"/>
	        <button class="button button-block"  name="btn-izvestaj" />Napravi izvestaj</button>
	        </div>
  	</form>
  	<?php
  		if(isset($_POST['btn-izvestaj'])) {
		if (isset($_POST['d1']) && isset($_POST['d2'])) {
			$datum1 = trim($_POST['d1']);
			$datum2 = trim($_POST['d2']);
			echo '<table class="rwd-table"><caption>Izvestaj za period od '. $datum1 .' do '. $datum2 .'</caption><tr><th>Vrsta</th><th>Materijal</th><th>Kolicina</th><th>Datum</th></tr>';
			$user->prikaziZaduzenja($partner, $datum1, $datum2);
			$user->prikaziRazduzenja($partner, $datum1, $datum2);
			echo '</table>';
		}
		else {
			echo '<script language="javascript">';
			echo 'alert("Unesite datume")';
			echo '</script>';
		}
	}
  	?> </div>
  	<br/> <br/> <br/><br/> <br/> <br/>
  	</div>
	</body>
</html>