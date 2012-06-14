<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: lidonline.php: Leden die online zijn weergeven. Dit script kun je includen waar je het wilt hebben
// Deze pagina is niet bedoeld voor los gebruik, omdat er geen <html></html> tags etc zijn, en geen stylsheet
// Include deze pagina daarom waar je hem wilt hebben als < ? include("lidonline.php"); ? > (zonder spaties bij haakjes)

// config.php al eerder geinclude? Maak van de volgende regel dan commentaar (# of //)

$sql = "SELECT `naam`, `status` FROM `gebruikers` WHERE DATE_SUB(NOW(),INTERVAL 10 MINUTE) <= `lastactive` ORDER BY `naam` ASC";
$query = $db->query($sql);
$tellen = $query->num_rows;
$i = 1;
while($rij = $query->fetch_object()) {
 $naam = htmlspecialchars($rij->naam);
 $status = htmlspecialchars($rij->status);
 if($status == 1) {
  $naam = "<b>".$naam."</b>";
 }
 echo $naam;
 if($i != $tellen) {
  echo ", ";
 }
 $i++;
}        
?>