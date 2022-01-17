<?php 

require_once "autoloader.php";

echo json_encode(Db::Execute(
	"UPDATE webuser SET webuser_password = :webuser_password WHERE webuser_id = :webuser_id",
	['webuser_id' => $_GET['webuser_id'], 'webuser_password' => $_GET['webuser_password']]
));

?>
