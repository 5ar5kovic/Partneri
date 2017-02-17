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
if ($vrsta == 1) {
	$stmt = $DB_con->prepare("SELECT * FROM preduzeca WHERE idPreduzeca=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
}
else {
	$user->logout();
	$user->redirect("../index.php");
}
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);	

$naziv = $userRow['naziv'];
$maticniBroj = $userRow['maticniBroj'];
$pib = $userRow['PIB'];
$sifraDelatnosti = $userRow['sifraDelatnosti'];
$racun = $userRow['racun'];
$adresa = $userRow['adresa'];
$username = $userRow['username'];
$email = $userRow['email'];

if(isset($_POST['btn-materijal']))
{
	$materijal = trim($_POST['mat']);
	$sifra = trim($_POST['sif']);
	if ($materijal != "") {
		$user->dodajMaterijal($materijal, $sifra, $user_id);
		echo("<meta http-equiv='refresh' content='1'>"); 
	}
	else {
		echo '<script language="javascript">';
		echo 'alert("Unesite naziv materijala")';
		echo '</script>';
	}
}

if(isset($_POST['btn-obrisi'])) 
{
	$idMaterijala = trim($_POST['idMat']);
	$user->obrisiMaterijal($idMaterijala);
	echo("<meta http-equiv='refresh' content='1'>"); 
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
		<h1> Preduzeće: <?php print($naziv) ?> </h1>
		<ul>
			<li> Matični broj: <?php print($maticniBroj); ?> </li>
			<li> PIB: <?php print($pib); ?> </li>
			<li> Šifra delatnosti: <?php print($sifraDelatnosti) ?> </li>
		</ul>
		<br/>
		</div>
		
		<table class="rwd-table">
		<tr>
			<th> ID </th>
			<th> Materijal </th>
			<th> Sifra materijala </th>
		</tr>
		<?php $user->prikaziMaterijale($user_id); ?>
		</table>
	

		<br/>
		<br/>
		<form method="POST">
		<div class="box">
		<div class="box3">
		<input type="text" name="mat" placeholder="Novi materijal..." autocomplete="off"/>
		<input type="text" name="sif" placeholder="Sifra materijala..." autocomplete="off"/>
        <button class="button button-block" name="btn-materijal"/>Dodaj materijal</button>
        <br/> <br/><br/>
        <select name="idMat">
              <?php 
                try {
                   $sql = 'SELECT idMaterijala,naziv,preduzece FROM materijali';
                   $projresult = $DB_con->query($sql);                       
                   $projresult->setFetchMode(PDO::FETCH_ASSOC);

                   while ( $row = $projresult->fetch() ) 
                   {
                   		if ($row['preduzece'] == $user_id)
                      		echo '<option value="'.$row['idMaterijala'].'">'.$row['naziv'].'</option>';
                   }
                }
                catch (PDOException $e) {   
                  die("Some problem getting data from database !!!" . $e->getMessage());
                }
              ?>
        </select>
        <button class="button button-block"  name="btn-obrisi" />Obrisi materijal</button>
        </div> </div>
        </form> <br/><br/><br/><br/><br/>
        </div> 
  	</body>

</html>