<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: safe_admin.php: Includen bovenaan een bestand welke alleen admins mogen bekijken

// Volgende regel commentaar maken als config.php al geinclude is (# of //)

if(isset($_SESSION['user_id'])) {
 // Inloggen correct, updaten laatst actief in db
 $sql = "UPDATE gebruikers SET lastactive=NOW() WHERE id='".$_SESSION['user_id']."'";
 mysql_query($sql);
 if($_SESSION['user_status'] == 1) {
  // Status correct, klaar
 }else{
		echo "You are not an admin.";
		header("Location: ?page=denied");
		exit();
 }
}else{
 if(isset($_COOKIE['user_id'])) {
  $sql = "SELECT wachtwoord,status FROM gebruikers WHERE id='".$_COOKIE['user_id']."'";
  $query = mysql_query($sql);
  $rij = mysql_fetch_object($query);
  $dbpass = htmlspecialchars($rij->wachtwoord);
  $dbstatus = htmlspecialchars($rij->status);
  if($dbpass == $_COOKIE['user_password']) {
   $_SESSION['user_id'] = $_COOKIE['user_id'];
   $_SESSION['user_status'] = $dbstatus;
  }else{
   setcookie("user_id", "", time() - 3600);
   setcookie("user_password", "", time() - 3600);
   echo "Cookies incorrect. Cookies deleted.";
	header("Location: ?page=inloggen");
	exit();
  }
 }else{
  header("Location: ?page=inloggen");
  exit();
 }
}
?>