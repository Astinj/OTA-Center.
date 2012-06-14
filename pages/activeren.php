<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: activeren.php: Account activeren naar wachtwoord vergeten/registratie
if(isset($_GET['id'])) {
 $id = $_GET['id'];
 
 if(isset($_GET['code'])) {
  $stmt = $db->stmt_init();
  $stmt->prepare('SELECT `id`, `actcode`, `actief` FROM `gebruikers` WHERE `id` = ?');
  $stmt->bind_param('i', $id);
  
  $stmt->execute();
  $stmt->bind_result($rij_id, $rij_actcode, $rij_actief);
  $stmt->fetch();
  $stmt->close();
  
  //$sql = "SELECT id,actcode,actief FROM gebruikers WHERE id='".$_GET['id']."'";
  //$query = mysql_query($sql);
  //$rij = mysql_fetch_object($query);
  $dbid = htmlspecialchars($rij_id);
  $dbcode = htmlspecialchars($rij_actcode);
  $actief = htmlspecialchars($rij_actief);
  if($actief == 0) {
   if($dbcode == $_GET['code']) {
    if(isset($_GET['activeer'])) {
     // Activeren en huidige pass behouden
     $stmt = $db->stmt_init();
     $stmt->prepare('UPDATE `gebruikers` SET `actief` = 1, `actcode` = \'\' WHERE `id` = ?');
     $stmt->bind_param('i', $id);
     
     //$sql = "UPDATE gebruikers SET actief=1,actcode='' WHERE id='".$_GET['id']."'";
     //$query = mysql_query($sql);
     if($stmt->execute()) {
      echo "Your account has been activated, you can now login with your old password.<br />\n<a href=\"inloggen.php\">&laquo;  Go to login.</a>";
     }else{
      echo "An error occured while activating.";
     }
     
     $stmt->close();
    }elseif(isset($_GET['registratie'])) {
     // Activeren naar registratie
     $stmt = $db->stmt_init();
     $stmt->prepare('UPDATE `gebruikers` SET `actief` = 1, `actcode` = \'\' WHERE `id` = ?');
     $stmt->bind_param('i', $id);
     
     //$sql = "UPDATE gebruikers SET actief=1,actcode='' WHERE id='".$_GET['id']."'";
     //$query = mysql_query($sql);
     if($stmt->execute()) {
      echo "Your account has been activated, you can now login.<br />\n<a href=\"?page=inloggen\">&laquo; Go to login.</a>";
     }else{
      echo "An error occured while activating.";
     }
     
     $stmt->close();
    }else{
     if(isset($_POST['submit'])) {
      // Uitvoeren
      if($_POST['pass1'] == $_POST['pass2']) {
       $md5pass = md5($_POST['pass1']);
       
       $stmt = $db->stmt_init();
       $stmt->prepare('UPDATE `gebruikers` SET `wachtwoord` = ?, `actief` = 1, `actcode` = \'\' WHERE `id` = ?');
       $stmt->bind_param('si', $md5pass, $id);
       
       //$sql = "UPDATE gebruikers SET wachtwoord='".$md5pass."',actief=1,actcode='' WHERE id='".$_GET['id']."'";
       //$query = mysql_query($sql);
       if($stmt->execute()) {
        echo "Your account has been activated and your password is changed.<br />\n<a href=\"?page=inloggen\">&laquo; Go to login</a>";
       }else{
        echo "An error occured while changing password.";
       }
       
       $stmt->close();
      }else{
       echo "The filled out passwords do not match.<br />\n<a href=\"javascript:history.back()\">&laquo; Go Back</a>";
      }
     }else{
      // Formulier wachtwoord wijzigen
      ?>
      <form method="post" action="activeren.php?id=<?= $id ?>&code=<?= $_GET['code'] ?>">
       <table>
        <tr>
         <td>New password:</td><td><input type="password" name="pass1" /></td>
        </tr>
        <tr>
         <td>Verify:</td><td><input type="password" name="pass2" /></td>
        </tr>
        <tr>
         <td></td><td><input type="submit" name="submit" value="Change Pass" /></td>
        </tr>
       </table>
      </form>
      <?
     }
    }
   }else{
    echo "The activation code is not correct. In case you lost it, go to 'forgot password' again.<br />\n<a href=\"forgotpass.php\">&laquo; Go to forgot password.</a>";
   }
  }else{
   echo "Your account was not deactivated. You can login again. In case you lost your password, please click on 'forgot password' on the login page.<br />\n<a href=\"inloggen.php\">&laquo; Go to login</a>";
  }
 }else{
  header("Location: ?page=activeren&uid=$id");
 }
}else{
 // Formulier
 ?>
 <form method="get" action="?page=activeren" >
  <table>
   <tr>
    <td>UserID:</td><td><input type="text" name="id" maxlength="5" <? if (isset($_GET['uid'])) { echo 'value="'.$_GET['uid'].'"'; } ?> /></td>
   </tr>
   <tr>
    <td>Activationcode:</td><td><input type="text" name="code" maxlength="15" /></td>
   </tr>
   <tr>
    <td align="right"><input type="checkbox" name="activeer" value="yes" style="border: 0px" /></td><td>Dont change password <small>(only activates account)</small></td>
   </tr>
   <tr>
    <td></td><td><input type="submit" value="Activate" /></td>
   </tr>
  </table>
 </form>
 <?
}
// id = userid
// code = actcode
// activeer = huidige wachtwoord houden
// controleren of code bij id hoort!
?>