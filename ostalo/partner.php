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
else {
	$user->logout();
	$user->redirect("../index.php");
}
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);	

$naziv = $userRow['naziv'];
$brojLicence = $userRow['brojLicence'];
$idPreduzeca = $userRow['idPreduzeca'];


if(isset($_POST['btn-zaduzi']))
{
	$mater = trim($_POST['zad']);
	$kolicina = trim($_POST['kolicina']);
	$datum = trim($_POST['datum']);
	$partner = $user_id;
	if ($kolicina != "" && $kolicina > 0) {
		$user->zaduzi($partner, $mater, $kolicina, $datum);
		echo("<meta http-equiv='refresh' content='1'>"); 
	}
	else {
		echo '<script language="javascript">';
		echo 'alert("Unesite kolicinu materijala")';
		echo '</script>';
	}
}

if(isset($_POST['btn-razduzi']))
{
	$mat = trim($_POST['razd']);
	$kolic = trim($_POST['kolic']);
	$dat = trim($_POST['dat']);
	$partner = $user_id;
	if ($kolic != "" && $kolic > 0) {
		if ($user->trenutnoStanjeMaterijala($mat,$partner) >= $kolic) {
			$user->razduzi($partner, $mat, $kolic, $dat);
			echo("<meta http-equiv='refresh' content='1'>"); 
		}
		else {
			echo '<script language="javascript">';
			echo 'alert("Na stanju se ne nalazi tolika kolicina")';
			echo '</script>';	
		}
	}
	else {
		echo '<script language="javascript">';
		echo 'alert("Unesite kolicinu materijala")';
		echo '</script>';
	}
}

?>


<!DOCTYPE html>
<html>

	<head>
		<title><?php print($naziv); ?></title>
		<link rel="stylesheet" href="../css/home.css">
	</head>

	<body>
	<div class="container">
		<div class="logout">
			<a href="home.php?logout=true"><i class="glyphicon glyphicon-log-out"></i> logout</a>
		</div>
		<div class="uvod">
		<h1> Partner: <?php print($naziv) ?> </h1>
		<ul>
			<li> Broj licence: <?php print($brojLicence); ?> </li>
		</ul>
		</div>
		<br/>
		<br/>

		<table class="rwd-table">
		<caption>Trenutno stanje</caption>
		<tr>
			<th> ID </th>
			<th> Materijal </th>
			<th> Sifra materijala </th>
			<th> Trenutno stanje </th>
		</tr>
		<?php $user->trenutnoStanje($user_id, $idPreduzeca); ?>
		</table>

		<br/> <br/>
		<form method="POST">
		<div class="box">
			<select name="zad">
	              <?php 
	                try {
	                   $sql = 'SELECT idMaterijala,naziv,preduzece FROM materijali';
	                   $projresult = $DB_con->query($sql);                       
	                   $projresult->setFetchMode(PDO::FETCH_ASSOC);

	                   while ( $row = $projresult->fetch() ) 
	                   {
	                   		if ($row['preduzece'] == $idPreduzeca)
	                      		echo '<option value="'.$row['idMaterijala'].'">'.$row['naziv'].'</option>';
	                   }
	                }
	                catch (PDOException $e) {   
	                  die("Some problem getting data from database !!!" . $e->getMessage());
	                }
	              ?>
	        </select>
	        <input type="text" name="kolicina" placeholder="Kolicina..." autocomplete="off"/>
	        <input type="date" name="datum"/>
	        <button class="button button-block"  name="btn-zaduzi" />Zaduzi</button>
	        </div>
	        <br/> <br/>
	        <div class="box">
	        <select name="razd">
	              <?php 
	                try {
	                   $sql = 'SELECT idMaterijala,naziv,preduzece FROM materijali';
	                   $projresult = $DB_con->query($sql);                       
	                   $projresult->setFetchMode(PDO::FETCH_ASSOC);

	                   while ( $row = $projresult->fetch() ) 
	                   {
	                   		if ($row['preduzece'] == $idPreduzeca)
	                      		echo '<option value="'.$row['idMaterijala'].'">'.$row['naziv'].'</option>';
	                   }
	                }
	                catch (PDOException $e) {   
	                  die("Some problem getting data from database !!!" . $e->getMessage());
	                }
	              ?>
	        </select>
	        <input type="text" name="kolic" placeholder="Kolicina..." autocomplete="off"/>
	        <input type="date" name="dat"/>
	        <button class="button button-block"  name="btn-razduzi" />Razduzi</button>
	        </div>
	        <br/> <br/>
	    </form>
	    <form action="izvestaj.php">
	    	<div class="box2">
	        <button class="button button-block"  name="btn-izvestaj" />Napravi izvestaj</button>
  			</div>
  		</form>
  	</div>
  	</body>

</html>