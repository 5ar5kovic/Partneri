<?php
require_once 'klase/dbconfig.php';

if($user->is_loggedin()!="")
{
 $user->redirect('ostalo/home.php');
}

if(isset($_POST['btn-login']))
{
 $uname = $_POST['txt_uname_email'];
 $umail = $_POST['txt_uname_email'];
 $upass = $_POST['txt_password'];
  
 if($user->login($uname,$umail,$upass))
 {
    $vrsta = $_SESSION['vrsta'];
    if ($vrsta == 1)
      $user->redirect('ostalo/preduzece.php');
    else if ($vrsta == 2)
      $user->redirect('ostalo/partner.php');
    //$user->redirect('ostalo/home.php');
 }
 else
 {
  $error = "Wrong Details !";
 } 
}


if(isset($_POST['btn-signup-preduzece']))
{
   $uname = trim($_POST['pr-username']);
   $umail = trim($_POST['pr-email']);
   $upass = trim($_POST['pr-password']);
   $comp = trim($_POST['pr-naziv']);
   $maticni = trim($_POST['pr-maticni']); 
   $pib = trim($_POST['pr-pib']);
   $sifra = trim($_POST['pr-sifra']);
   $racun = trim($_POST['pr-racun']);
   $adresa = trim($_POST['pr-adresa']);
 
   if($uname=="") {
      $error[] = "provide username !"; 
   }
   else if($umail=="") {
      $error[] = "provide email id !"; 
   }
   else if(!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email address !';
   }
   else if($upass=="") {
      $error[] = "provide password !";
   }
   else
   {
      try
      {
         $stmt = $DB_con->prepare("SELECT username,email FROM preduzeca WHERE username=:uname OR email=:umail");
         $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         if($row['username']==$uname) {
            $error[] = "sorry username already taken !";
         }
         else if($row['email']==$umail) {
            $error[] = "sorry email id already taken !";
         }
         else
         {
            if($user->registerPreduzece($uname,$upass,$umail, $comp, $maticni, $pib, $sifra, $racun, $adresa)) 
            {
                $user->redirect('ostalo/registracijaPreduzeca.html');
            }
         }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 
}


if(isset($_POST['btn-signup-partner']))
{
   $uname = trim($_POST['pa-username']);
   $umail = trim($_POST['pa-email']);
   $upass = trim($_POST['pa-password']);
   $naziv = trim($_POST['pa-naziv']);
   $comp = trim($_POST['pa-preduzece']);
   $licenca = trim($_POST['pa-licenca']);
   $adresa = trim($_POST['pa-adresa']);
 
   if($uname=="") {
      $error[] = "provide username !"; 
   }
   else if($umail=="") {
      $error[] = "provide email id !"; 
   }
   else if(!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Please enter a valid email address !';
   }
   else if($upass=="") {
      $error[] = "provide password !";
   }
   else
   {
      try
      {
         $stmt = $DB_con->prepare("SELECT username,email FROM partneri WHERE username=:uname OR email=:umail");
         $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
         $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
         if($row['username']==$uname) {
            $error[] = "sorry username already taken !";
         }
         else if($row['email']==$umail) {
            $error[] = "sorry email id already taken !";
         }
         else
         {
            if($user->registerPartner($uname,$upass,$umail,$naziv,$comp,$licenca,$adresa)) 
            {
                $user->redirect('ostalo/registracijaPartnera.html');
            }
         }
     }
     catch(PDOException $e)
     {
        echo $e->getMessage();
     }
  } 
}

?>

<!DOCTYPE html>
<html>

<head>

  <title>Partneri</title>
  <link rel="icon" href="slike/favicon.ico" type="image/icon" sizes="16x16">

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Partnerske Firme">
  <meta name="abstract" content="Partnerske Firme">
  <meta name="keywords" content="partneri">
  <meta name="author" content="Petar Petkovic">
  <meta name="contact" content="petar.petkovic@pmf.edu.rs">
  <meta name="robots" content="index, follow">
  <meta name="copyright" content="Petar Petkovic">
  <meta name="rating" content="safe for kids">

  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' type='text/css'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/home.css">

</head>

<body>
    <div class="logout">
      <a href="ostalo/Uputstvo.pdf" target="_blank"><i class="glyphicon glyphicon-log-out"></i> Uputstvo za korišćenje</a>
    </div>
  <div class="form">
      <ul class="tab-group">
        <li class="tab active"><a href="#login">Prijava</a></li>
        <li class="tab"><a href="#signup">Registracija</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="login">   
          <h1>Prijava</h1>
          
          <form action="#" method="POST">
          
            <div class="field-wrap">
            <label>
              Korisničko ime<span class="req">*</span>
            </label>
            <input type="text" name="txt_uname_email" required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Lozinka<span class="req">*</span>
            </label>
            <input type="password" name="txt_password" required autocomplete="off"/>
          </div>
          
          <button class="button button-block" name="btn-login"/>Prijavi se</button>
          
          </form>

        </div>
        <div id="signup">   
          <h1>Registracija</h1>
          
          <ul class="tab-group">
            <li class="tab active" onclick="switchVisible1();"><a href="#">Preduzece</a></li>
            <li class="tab" onclick="switchVisible2();"><a href="#">Partner</a></li>
          </ul>
          <form action="#" method="POST">

          <div id="preduzece">
            <div class="field-wrap">
              <label>
                Korisnicko ime<span class="req">*</span>
              </label>
              <input type="text" name="pr-username" required autocomplete="off"/>
            </div>

             <div class="field-wrap">
              <label>
                Lozinka<span class="req">*</span>
              </label>
              <input type="password" name="pr-password" required autocomplete="off"/>
            </div>

            <div class="field-wrap">
              <label>
                Email adresa<span class="req">*</span>
              </label>
              <input type="email" name="pr-email" required autocomplete="off"/>
            </div>
            
            <div class="field-wrap">
              <label>
                Naziv firme<span class="req">*</span>
              </label>
              <input type="text" name="pr-naziv" required autocomplete="off"/>
            </div>
            
            <div class="field-wrap">
              <label>
                Matični broj
              </label>
              <input type="text" name="pr-maticni" autocomplete="off"/>
            </div> 

            <div class="field-wrap">
              <label>
                PIB
              </label>
              <input type="text" name="pr-pib" autocomplete="off"/>
            </div>

            <div class="field-wrap">
              <label>
                Šifra delatnosti
              </label>
              <input type="text" name="pr-sifra" autocomplete="off"/>
            </div>

            <div class="field-wrap">
              <label>
                Broj računa
              </label>
              <input type="text" name="pr-racun" autocomplete="off"/>
            </div>

            <div class="field-wrap">
              <span class="levo"> Adresa: </span>
              <select name="pr-adresa" class="desno">
              <?php 
                try {
                   $sql = 'select idAdrese,naziv from adrese';
                   $projresult = $DB_con->query($sql);                       
                   $projresult->setFetchMode(PDO::FETCH_ASSOC);

                   while ( $row = $projresult->fetch() ) 
                   {
                      echo '<option value="'.$row['idAdrese'].'">'.$row['naziv'].'</option>';
                   }
                }
                catch (PDOException $e) {   
                  die("Some problem getting data from database !!!" . $e->getMessage());
                }
              ?>
              </select>
            </div>
            <button class="button button-block" name="btn-signup-preduzece"/>Registruj se</button>
          </div>  <!-- end of .preduzece -->
          </form>

          <form action="#" method="POST">
          <div id="partner">
            <div class="field-wrap">
              <label>
                Korisnicko ime<span class="req">*</span>
              </label>
              <input type="text" name="pa-username" required autocomplete="off"/>
            </div>

             <div class="field-wrap">
              <label>
                Lozinka<span class="req">*</span>
              </label>
              <input type="password" name="pa-password" required autocomplete="off"/>
            </div>

            <div class="field-wrap">
              <label>
                Email adresa<span class="req">*</span>
              </label>
              <input type="email" name="pa-email" required autocomplete="off"/>
            </div>
            
            <div class="field-wrap">
              <label>
                Naziv<span class="req">*</span>
              </label>
              <input type="text" name="pa-naziv" required autocomplete="off"/>
            </div>

            <div class="field-wrap">
            <span class="levo"> Preduzece: </span>
              <select name="pa-preduzece" class="desno">
              <?php 
                try {
                   $sql = 'select idPreduzeca,naziv from preduzeca';
                   $projresult = $DB_con->query($sql);                       
                   $projresult->setFetchMode(PDO::FETCH_ASSOC);

                   while ( $row = $projresult->fetch() ) 
                   {
                      echo '<option value="'.$row['idPreduzeca'].'">'.$row['naziv'].'</option>';
                   }
                }
                catch (PDOException $e) {   
                  die("Some problem getting data from database !!!" . $e->getMessage());
                }
              ?>
              </select>
            </div>

            <div class="field-wrap">
              <label>
                Broj licence
              </label>
              <input type="text" name="pa-licenca" autocomplete="off"/>
            </div>
            
            <div class="field-wrap">
            <span class="levo"> Adresa: </span>
              <select name="pa-adresa" class="desno">
              <?php 
                try {
                   $sql = 'select idAdrese,naziv from adrese';
                   $projresult = $DB_con->query($sql);                       
                   $projresult->setFetchMode(PDO::FETCH_ASSOC);

                   while ( $row = $projresult->fetch() ) 
                   {
                      echo '<option value="'.$row['idAdrese'].'">'.$row['naziv'].'</option>';
                   }
                }
                catch (PDOException $e) {   
                  die("Some problem getting data from database !!!" . $e->getMessage());
                }
              ?>
              </select>
            </div>
            
            <button class="button button-block" name="btn-signup-partner"/>Registruj se</button>

          </form>

        </div>
        
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>

