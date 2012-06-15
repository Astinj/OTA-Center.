<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: safe.php: Includen helemaal bovenaan een bestand dat je beveiligd wilt hebben (inloggen verplicht)

if (isset($_SESSION['user_id'])) {
    // Inloggen correct, updaten laatst actief in db
    $stmt = $db->stmt_init();
    $stmt->prepare('UPDATE `gebruikers` SET `lastactive` = NOW() WHERE `id` = ?');
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
} else if (isset($_COOKIE['user_id'])) {
    $stmt = $db->stmt_init();
    $stmt->prepare('SELECT `wachtwoord`, `status` FROM `gebruikers` WHERE `id` = ?');
    $stmt->bind_param('i', $_COOKIE['user_id']);
    $stmt->execute();
    $stmt->bind_result($wachtwoord, $status);
    $stmt->fetch();
    $stmt->close();

    if ($dbpass == $_COOKIE['user_password']) {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['user_status'] = $dbstatus;
    } else {
        setcookie("user_id", "", time() - 3600);
        setcookie("user_password", "", time() - 3600);
        //echo "Cookies incorrect. Cookies verwijderd.";
        header("Location: ?page=inloggen");
        exit();
    }
} else {
    header("Location: ?page=inloggen");
    exit();
}
?>
