<?php 

require_once "autoloader.php";

echo json_encode(Db::Query(
	"SELECT * FROM webuser"
));

?>
