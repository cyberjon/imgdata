<?php
require_once 'config.php';
$conn = new mysqli( $db_host, $db_user, $db_pass, $db_name );
$id = $_POST['id'];
$sql = "SELECT * FROM data where id = ".$id;
$result = $conn->query($sql);
$row = $result->fetch_assoc(); 
echo(json_encode($row));