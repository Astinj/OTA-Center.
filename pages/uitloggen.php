<?
// Groot Inlogsysteem versie 2
// Copyright Jorik Berkepas
// Support by helpdesk90@gmail.com (MSN|Email)
// Pagina: uitloggen.php: Pagina om gebruiker weer uit te loggen

session_unset();
session_destroy();

if (isset($_COOKIE['user_id'])) {
    setcookie("user_id", "", time() - 3600);
    setcookie("user_password", "", time() - 3600);
    setcookie("user_status", "", time() - 3600);
    setcookie("user_lastactive", "", time() - 3600);

}

echo "You are logged out correctly.<br />\n<a href=\"?page=home\">&laquo; Login again.</a>";
header("Location: ?page=home");
?>
