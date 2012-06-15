<?php
include('safe_admin.php');

$id = $_GET['id'];

// update data in mysql database
$stmt = $db->stmt_init();
$stmt->prepare('DELETE FROM `gebruikers` WHERE `id` = ? ');
$stmt->bind_param('i', $id);

// if successfully updated.
if ($stmt->execute()){
    echo "Deleted Successfully";
    echo "<BR>";
    echo "<a href='?page=listusers'>View result</a>";
} else {
    echo "ERROR";
}
?>
