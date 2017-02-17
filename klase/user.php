<?php
class USER
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
    public function registerPreduzece($uname,$upass,$umail, $comp, $maticni, $pib, $sifra, $racun, $adresa)
    {
       try
       {
           $new_password = password_hash($upass, PASSWORD_DEFAULT);         

           $stmt = $this->db->prepare("INSERT INTO preduzeca(naziv,maticniBroj,PIB,sifraDelatnosti,racun,adresa,username,password,email) 
                                                       VALUES(:comp, :maticni, :pib, :sifra, :racun, :adresa, :uname, :upass, :umail)");
           $stmt->bindparam(":comp", $comp);
           $stmt->bindparam(":maticni", $maticni);
           $stmt->bindparam(":pib", $pib);
           $stmt->bindparam(":sifra", $sifra);
           $stmt->bindparam(":racun", $racun);
           $stmt->bindparam(":adresa", $adresa);
           $stmt->bindparam(":uname", $uname);
           $stmt->bindparam(":upass", $new_password);
           $stmt->bindparam(":umail", $umail);            
           $stmt->execute(); 
   
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
    public function registerPartner($uname,$upass,$umail, $naziv, $comp, $licenca, $adresa)
    {
       try
       {
           $new_password = password_hash($upass, PASSWORD_DEFAULT);         

           $stmt = $this->db->prepare("INSERT INTO partneri(naziv,brojLicence,idPreduzeca,adresa,username,password,email) 
                                                       VALUES(:naziv, :licenca, :comp, :adresa, :uname, :upass, :umail)");
              
           $stmt->bindparam(":naziv", $naziv);
           $stmt->bindparam(":licenca", $licenca);
           $stmt->bindparam(":comp", $comp);
           $stmt->bindparam(":adresa", $adresa);
           $stmt->bindparam(":uname", $uname);
           $stmt->bindparam(":upass", $new_password);
           $stmt->bindparam(":umail", $umail);            
           $stmt->execute(); 
   
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
 
    public function login($uname,$umail,$upass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM partneri WHERE username=:uname OR email=:umail LIMIT 1");
          $stmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);

          if($stmt->rowCount() > 0)
          {
             if(password_verify($upass, $userRow['password']))
             {
                $_SESSION['user_session'] = $userRow['idPartnera'];
                $_SESSION['vrsta'] = 2;
                return true;
             }
             else
             {
                return false;
             }
          }
          else 
          {
            $tmt = $this->db->prepare("SELECT * FROM preduzeca WHERE username=:uname OR email=:umail LIMIT 1");
            $tmt->execute(array(':uname'=>$uname, ':umail'=>$umail));
            $row=$tmt->fetch(PDO::FETCH_ASSOC);

            if($tmt->rowCount() > 0)
            {
              if(password_verify($upass, $row['password']))
              {
                $_SESSION['user_session'] = $row['idPreduzeca'];
                $_SESSION['vrsta'] = 1;
                return true;
              }
              else
              {
                return false;
              }
            }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
 
   public function is_loggedin()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }
 
   public function redirect($url)
   {
      header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }

   public function prikaziMaterijale($user_id) {
    $query = $this->db->prepare('SELECT idMaterijala,naziv,sifra FROM materijali WHERE preduzece = :user_id');
    $query->execute(array(':user_id'=>$user_id));

    $result = $query -> fetchAll();
    foreach( $result as $row ) {
      echo "<tr> <td> " . $row['idMaterijala'] . "</td> <td> " . $row['naziv'] . "</td> <td> ". $row['sifra'] . "</td> </tr>";
    }
   }

   public function dodajMaterijal($materijal, $sifra, $user_id) {
        try
       {    
           $stmt = $this->db->prepare("INSERT INTO materijali(naziv, sifra, preduzece) 
                                                       VALUES(:materijal, :sifra, :user_id)");
           $stmt->bindparam(":materijal", $materijal);
           $stmt->bindparam(":sifra", $sifra);
           $stmt->bindparam(":user_id", $user_id);            
           $stmt->execute(); 
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
   }

  public function obrisiMaterijal($idMaterijala) {
    try {
      $sql = "DELETE FROM materijali WHERE idMaterijala = :idMaterijala";
      $query = $this->db->prepare($sql);
      $query->bindparam(":idMaterijala", $idMaterijala);
      $query->execute();
    }
    catch(PDOException $e)
       {
           echo $e->getMessage();
       } 
  }

  public function trenutnoStanje($user_id, $idPreduzeca) {
    $query = $this->db->prepare('SELECT idMaterijala,naziv,sifra FROM materijali WHERE preduzece = :idPreduzeca');
    $query->execute(array(':idPreduzeca'=>$idPreduzeca));
    $result = $query -> fetchAll();   //svi materijali jednog preduzeca
    
    foreach( $result as $row ) {  //za svaki materijal odabranog preduzeca
      $suma = 0;
      $mat = $row['idMaterijala'];
      $tmp = $this->db->prepare('SELECT kolicina FROM zaduzenja WHERE partner = :user_id AND materijal = :mat');
      $tmp->bindparam(":user_id", $user_id);
      $tmp->bindparam(":mat", $mat);
      $tmp->execute();
      $kol = $tmp -> fetchAll();    //kolicina odredjenog materijala datog partnera
      foreach ($kol as $r) {
        $suma += $r['kolicina'];
      }

      $tmp = $this->db->prepare('SELECT kolicina FROM razduzenje WHERE partner = :user_id AND materijal = :mat');
      $tmp->bindparam(":user_id", $user_id);
      $tmp->bindparam(":mat", $mat);
      $tmp->execute();
      $kol = $tmp -> fetchAll();    //kolicina odredjenog materijala datog partnera
      foreach ($kol as $r) {
        $suma -= $r['kolicina'];
      }

      echo "<tr> <td> " . $row['idMaterijala'] . "</td> <td> " . $row['naziv'] . "</td> <td> ". $row['sifra'] . "</td> <td>" . $suma . "</td> </tr>";
    }
  }

  public function trenutnoStanjeMaterijala($materijal, $user_id) {
    $s = 0;
    $query = $this->db->prepare('SELECT kolicina FROM zaduzenja WHERE partner = :user_id AND materijal = :materijal');
    $query->bindparam(":user_id", $user_id);
    $query->bindparam(":materijal", $materijal);
    $query->execute();
    $result = $query -> fetchAll();
    foreach ($result as $row) {
      $s += $row['kolicina'];
    }

    $tmp = $this->db->prepare('SELECT kolicina FROM razduzenje WHERE partner = :user_id AND materijal = :materijal');
    $tmp->bindparam(":user_id", $user_id);
    $tmp->bindparam(":materijal", $materijal);
    $tmp->execute();
    $kol = $tmp -> fetchAll();    //kolicina odredjenog materijala datog partnera
    foreach ($kol as $r) {
      $s -= $r['kolicina'];
    }
    return $s;
  }

  public function zaduzi($partner, $materijal, $kolicina, $datum) {
       try
       {    
           $stmt = $this->db->prepare("INSERT INTO zaduzenja(partner, materijal, kolicina, datum) 
                                                       VALUES(:partner, :materijal, :kolicina, :datum)");
           $stmt->bindparam(":partner", $partner);
           $stmt->bindparam(":materijal", $materijal);
           $stmt->bindparam(":kolicina", $kolicina);
           $stmt->bindparam(":datum", $datum);            
           $stmt->execute(); 
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
  }

  public function prikaziZaduzenja($partner, $datum1, $datum2) {
    $query = $this->db->prepare('SELECT materijal, kolicina, datum FROM zaduzenja WHERE partner = :partner AND datum < :datum2 AND datum > :datum1');
    $query->bindparam(":partner", $partner);
    $query->bindparam(":datum2", $datum2);
    $query->bindparam(":datum1", $datum1);
    $query->execute();
    $result = $query -> fetchAll();

    foreach ($result as $row) {
      $kol = $row['kolicina'];
      $dat = $row['datum'];
      $mat = $row['materijal'];
      $stmt = $this->db->prepare('SELECT naziv FROM materijali WHERE idMaterijala = :mat');
      $stmt->bindparam("mat", $mat);
      $stmt->execute();
      $res = $stmt -> fetchAll();
      foreach ($res as $r) {
      echo '<tr><td>'.'zaduzenje'.'</td> <td>'.$r['naziv'].'</td> <td>'.$kol.'</td> <td>'.$dat.'</td></tr><br/>';
      }
    }
  }

  public function prikaziRazduzenja($partner, $datum1, $datum2) {
    $query = $this->db->prepare('SELECT materijal, kolicina, datum FROM razduzenje WHERE partner = :partner AND datum < :datum2 AND datum > :datum1');
    $query->bindparam(":partner", $partner);
    $query->bindparam(":datum2", $datum2);
    $query->bindparam(":datum1", $datum1);
    $query->execute();
    $result = $query -> fetchAll();

    foreach ($result as $row) {
      $kol = $row['kolicina'];
      $dat = $row['datum'];
      $mat = $row['materijal'];
      $stmt = $this->db->prepare('SELECT naziv FROM materijali WHERE idMaterijala = :mat');
      $stmt->bindparam("mat", $mat);
      $stmt->execute();
      $res = $stmt -> fetchAll();
      foreach ($res as $r) {
      echo '<tr><td>'.'razduzenje'.'</td> <td>'.$r['naziv'].'</td> <td>'.$kol.'</td> <td>'.$dat.'</td></tr><br/>';
      }
    }
  }

  public function razduzi($partner, $materijal, $kolicina, $datum) {
       try
       {    
           $stmt = $this->db->prepare("INSERT INTO razduzenje(partner, materijal, kolicina, datum) 
                                                       VALUES(:partner, :materijal, :kolicina, :datum)");
           $stmt->bindparam(":partner", $partner);
           $stmt->bindparam(":materijal", $materijal);
           $stmt->bindparam(":kolicina", $kolicina);
           $stmt->bindparam(":datum", $datum);            
           $stmt->execute(); 
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
  }

 }
?>