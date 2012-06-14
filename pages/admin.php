<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: ledenlijst.php: Alle geregistreerde accounts weergeven
// Pagina alleen voor admins; safe_admin.php
include("safe_admin.php");

if(isset($_GET['edit'])) {
 // Bewerken
 if(is_numeric($_GET['edit'])) {
  if(isset($_POST['submit'])) {
   // Bewerkenuitvoeren
   if($_POST['pass1'] != "") {
    if($_POST['pass1'] == $_POST['pass2']) {
     $newpass = md5($_POST['pass1']);
     $stmt = $db->stmt_init();
     $stmt->prepare('UPDATE `gebruikers` SET `naam` = ?, `wachtwoord` = ?, `email` = ?, `actief` = ?, `status` = ? WHERE `id` = ?');
     $stmt->bind_param('sssisi', $_POST['naam'], $newpass, $_POST['email'], $_POST['actief'], $_POST['status'], $_GET['edit']);
     
     //$sql = "UPDATE gebruikers SET naam='".$_POST['naam']."',wachtwoord='".$newpass."',email='".$_POST['email']."',actief='".$_POST['actief']."',status='".$_POST['status']."' WHERE id='".$_GET['edit']."'";
     //$query = mysql_query($sql);
     if($stmt->execute();) {
      echo "De gebruiker is succesvol gewijzigd, wachtwoord is veranderd.<br />\n<a href=\"?page=admin\">&laquo; Terug naar het beheer</a>";
     }else{
      echo "Fout opgetreden tijdens bewerken.<br />\n<a href=\"javascript:history.back()\">&laquo; Ga terug</a>";
     }
     
     $stmt->close();
    }else{
     echo "De nieuwe wachtwoorden zijn niet hetzelfde.<br />\n<a href=\"javascript:history.back()\">&laquo; Ga terug</a>";
    }
   }else{
    // Zonder wachtwoord wijzigen
    $stmt = $db->stmt_init();
    $stmt->prepare('UPDATE `gebruikers` SET `naam` = ?, `email` = ?, `actief` = ?, `status` = ? WHERE `id` = ?');
    $stmt->bind_param('ssisi', $_POST['naam'], $_POST['email'], $_POST['actief'], $_POST['status'], $_GET['edit']);
    
    //$sql = "UPDATE gebruikers SET naam='".$_POST['naam']."',email='".$_POST['email']."',actief='".$_POST['actief']."',status='".$_POST['status']."' WHERE id='".$_GET['edit']."'";
    //$query = mysql_query($sql);
    if($stmt->execute()) {
     echo "De gebruiker is succesvol gewijzigd.<br />\n<a href=\"?page=admin\">&laquo; Terug naar het beheer</a>";
    }else{
     echo "Fout opgetreden tijdens bewerken.<br />\n<a href=\"javascript:history.back()\">&laquo; Ga terug</a>";
    }
    
    $stmt->close();
   } 
  }else{
   // Bewerkform
   $stmt = $db->stmt_init();
   $stmt->prepare('SELECT `naam`, `status`, `email`, `actief` FROM `gebruikers` WHERE `id` = ?');
   $stmt->bind_param('i', $_GET['edit']);
   $stmt->execute();
   $stmt->bind_result($naam, $status, $email, $actief);
   $stmt->fetch();
   $stmt->close();
   //$sql = "SELECT * FROM gebruikers WHERE id='".$_GET['edit']."'";
   //$query = mysql_query($sql);
   //$rij = mysql_fetch_object($query);
   //$naam = htmlspecialchars($rij->naam);
   //$status = htmlspecialchars($rij->status);
   //$email = htmlspecialchars($rij->email);
   //$actief = htmlspecialchars($rij->actief);
   ?>
   <form method="post" action="?page=admin&edit=<?= $_GET['edit'] ?>">
    <table>
     <tr>
      <td>Naam:</td><td><input type="text" name="naam" value="<?= $naam ?>" maxlength="50" /></td>
     </tr>
     <tr>
      <td>Nieuw wachtwoord:</td><td><input type="password" name="pass1" /> <small>(leeglaten voor huidige)</small></td>
     </tr>
     <tr>
      <td>Herhaal:</td><td><input type="password" name="pass2" /></td>
     </tr>
     <tr>
      <td>E-mailadres:</td><td><input type="text" name="email" value="<?= $email ?>" maxlength="100" /></td>
     </tr>
     <tr>
      <td>Actief:</td><td><input type="text" name="actief" value="<?= $actief ?>" maxlength="1" size="1" /> <small>(1 = actief, 0 = niet actief)</small></td>
     </tr>
     <tr>
      <td>Status:</td><td><input type="text" name="status" value="<?= $status ?>" maxlength="1" size="1" /> <small>(1 = admin, 0 = gebruiker)</small></td>
     </tr>
     <tr>
      <td></td><td><input type="submit" name="submit" value="Opslaan" /></td>
     </tr>
    </table>
   </form>
   <?
  }
 }else{
  // Lijst
  ?>
  Welke gebruiker wil je bewerken?<br />
  <form method="get" action="?page=admin">
   <table>
    <tr>
     <td><select name="edit" size="1">
      <option value="do">&nbsp;</option>
      <?
      $sql = "SELECT `naam`, `id` FROM `gebruikers` ORDER BY `naam` ASC";
      $query = $db->query($sql);
      while($rij = $query->fetch_object()) {
       $id = htmlspecialchars($rij->id);
       $naam = htmlspecialchars($rij->naam);
       echo "<option value=\"".$id."\">".$naam."</option>\n";
      }
      ?></select>
     </td>
     <td><input type="submit" value="Bewerken" /></td>
    </tr>
   </table>
  </form>
  <?
 }
}elseif(isset($_GET['del'])) {
 // Verwijderen
 if(is_numeric($_GET['del'])) {
  // Verwijderenuitvoeren
  $stmt = $db->stmt_init();
  $stmt->prepare('DELETE FROM `gebruikers` WHERE `id` = ?');
  $stmt->bind_param('i', $_GET['del']);
  //$sql = "DELETE FROM gebruikers WHERE id='".$_GET['del']."'";
  //$query = mysql_query($sql);
  if($stmt->execute()) {
   echo "De gebruiker met het ID ".$_GET[ 'del']." is succesvol verwijderd.<br />\n<a href=\"?page=admin\">&laquo; Terug naar het beheer</a>";
  }else{
   echo "Er is iets fout gegaan bij het verwijderen van userID ".$_GET['del'].". Bestaat het gebruikersID wel?<br />\n<a href=\"?page=admin\">&laquo; Terug naar het beheer</a>";
  }
 }else{
  // Lijst
  ?>
  Welke gebruiker wil je verwijderen?<br />
  <form method="get" action="?page=admin">
   <table>
    <tr>
     <td><select name="del" size="1">
      <option value="">&nbsp;</option>
      <?
      $sql = "SELECT `naam`, `id` FROM `gebruikers` ORDER BY `naam` ASC";
      $query = $db->query($sql);
      while($rij = $query->fetch_object()) {
       $id = htmlspecialchars($rij->id);
       $naam = htmlspecialchars($rij->naam);
       echo "<option value=\"".$id."\">".$naam."</option>\n";
      }
      ?></select>
     </td>
     <td><input type="submit" value="Verwijderen" /></td>
    </tr>
   </table>
  </form>
  <?
 }
}else{
 // Keuzelijst
 ?>
 Wat wil je doen?<br />
 <ul>
  <li><a href="?page=admin&edit=do">Gebruiker bewerken</a></li>
  <li><a href="?page=admin&del=do">Gebruiker verwijderen</a></li>
 </ul>
 <?
}
  ?>