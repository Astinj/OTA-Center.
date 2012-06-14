<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: safe.php: Includen helemaal bovenaan een bestand dat je beveiligd wilt hebben (inloggen verplicht)

// Volgende regel commentaar maken als je config.php al geinclude hebt (# of //)

if(isset($_SESSION['user_id'])) {
 // Inloggen correct, updaten laatst actief in db
 $stmt = $db->stmt_init();
 $stmt->prepare('UPDATE `gebruikers` SET `lastactive` = NOW() WHERE `id` = ?');
 $stmt->bind_param('i', $_SESSION['user_id']);
 $stmt->execute();
 $stmt->close();
 
 //$sql = "UPDATE gebruikers SET lastactive=NOW() WHERE id='".$_SESSION['user_id']."'";
 //mysql_query($sql);
}else{
 if(isset($_COOKIE['user_id'])) {
  $stmt = $db->stmt_init();
  $stmt->prepare('SELECT `wachtwoord`, `status` FROM `gebruikers` WHERE `id` = ?');
  $stmt->bind_param('i', $_COOKIE['user_id']);
  $stmt->execute();
  $stmt->bind_result($rij_wachtwoord, $rij_status);
  $stmt->fetch();
  $stmt->close();
  
  //$sql = "SELECT wachtwoord,status FROM gebruikers WHERE id='".$_COOKIE['user_id']."'";
  //$query = mysql_query($sql);
  //$rij = mysql_fetch_object($query);
  $dbpass = htmlspecialchars($rij_wachtwoord);
  $dbstatus = htmlspecialchars($rij_status);
  if($dbpass == $_COOKIE['user_password']) {
   $_SESSION['user_id'] = $_COOKIE['user_id'];
   $_SESSION['user_status'] = $dbstatus;
  }else{
   setcookie("user_id", "", time() - 3600);
   setcookie("user_password", "", time() - 3600);
   echo "Cookies incorrect. Cookies verwijderd.";
   header("Location: ?page=inloggen");
   exit();
  }
 }else{
  header("Location: ?page=inloggen");
  exit();
 }
}
?>