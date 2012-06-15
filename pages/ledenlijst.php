<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: ledenlijst.php: Alle geregistreerde accounts weergeven
include('safe.php');
?>
<table>
    <tr>
        <th>Gebruikersnaam</th>
    </tr>
    <?
    $sql = "SELECT `naam`, `actief` FROM `gebruikers` ORDER BY `naam` ASC";
    $query = $db->query($sql);
    while($rij = $query->fetch_object()) {
        $naam = htmlspecialchars($rij->naam);
        $actief = htmlspecialchars($rij->actief);
        if ($actief == 0) {
            echo "<tr>\n";
            echo "<td><font color=\"gray\">".$naam."</font></td>\n";
            echo "</tr>\n";
        } else {
            echo "<tr>\n";
            echo "<td>".$naam."</td>\n";
            echo "</tr>\n";
        }
    }
    ?>
</table>
<p></p>
<small>Gebruikers die <font color="gray">grijs</font> in de lijst staan, zijn momenteel gedeactiveerd.</small>
