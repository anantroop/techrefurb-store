<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "techrefurb";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function getCartCount($conn, $user_id) {
    $result = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id=$user_id");
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ? $row['total'] : 0;
}
?>