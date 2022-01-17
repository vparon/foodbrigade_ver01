<?php 

require_once "autoloader.php";

echo json_encode(Db::Execute(
	"INSERT INTO webuser (webuser_username, webuser_password) VALUES (:webuser_username, :webuser_password)",
	['webuser_username' => $_GET['webuser_username'], 'webuser_password' => $_GET['webuser_password']]
));

?>
