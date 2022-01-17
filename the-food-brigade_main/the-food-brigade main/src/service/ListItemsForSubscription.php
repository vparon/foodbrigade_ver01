<?php 

require_once "autoloader.php";

echo json_encode(Db::Query(
	"SELECT
		subscription_plan_item_id,
		subscription_plan_item_subscription_plan_id,
		subscription_plan_item_cheese_type_id,
		cheese_type_name,
		cheese_type_description,
		cheese_type_image,
		subscription_plan_item_quantity,
		subscription_plan_item_unit_id,
		unit_postfix
	FROM
		subscription_plan_item
	INNER JOIN
		cheese_type
	ON subscription_plan_item.subscription_plan_item_cheese_type_id = cheese_type.cheese_type_id
	INNER JOIN
		unit
	ON subscription_plan_item.subscription_plan_item_unit_id = unit.unit_id
	WHERE subscription_plan_item_subscription_plan_id = :subscription_plan_id",
	['subscription_plan_id' => $_GET['subscription_plan_id']]
));

?>