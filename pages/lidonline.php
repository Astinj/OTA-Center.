<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: lidonline.php: Leden die online zijn weergeven. Dit script kun je includen waar je het wilt hebben
// Deze pagina is niet bedoeld voor los gebruik, omdat er geen <html></html> tags etc zijn, en geen stylsheet
// Include deze pagina daarom waar je hem wilt hebben als < ? include("lidonline.php"); ? > (zonder spaties bij haakjes)

$query = $db->query('SELECT `naam`, `status` FROM `gebruikers` WHERE DATE_SUB(NOW(),INTERVAL 10 MINUTE) <= `lastactive` ORDER BY `naam` ASC');
$tellen = $query->num_rows;
$i = 1;
while ($rij = $query->fetch_object()) {
    $naam = htmlspecialchars($rij->naam);
    if ($rij->status == 1) {
        $naam = "<b>$naam</b>";
    }

    echo $naam;
    if ($i != $tellen) {
        echo ', ';
    }
    $i++;
}
?>
