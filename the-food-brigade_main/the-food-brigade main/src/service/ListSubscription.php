<?php 

require_once "autoloader.php";

echo json_encode(Db::Query(
	"SELECT
		subscription_plan.subscription_plan_id,
		subscription_plan_min_duration,
		subscription_plan_discount,
		subscription_plan_is_active,
		subscription_plan_image,
		subscription_plan_name,
		subscription_plan_description,
		subscription_plan_total_price,
		(subscription_plan_total_price * (1.0 - subscription_plan_discount)) AS subscription_plan_discounted_total_price
	FROM
		subscription_plan
	INNER JOIN
	(
		SELECT
			subscription_plan_item_subscription_plan_id AS subscription_plan_id,
			SUM(price.price_value * subscription_plan_item.subscription_plan_item_quantity) AS subscription_plan_total_price
		FROM
			subscription_plan_item
		INNER JOIN
			cheese_type
		ON subscription_plan_item.subscription_plan_item_cheese_type_id = cheese_type.cheese_type_id
		INNER JOIN
			price
		ON cheese_type.cheese_price_id = price.price_id
		GROUP BY subscription_plan_item.subscription_plan_item_subscription_plan_id
	) AS subscription_plan_price_sum
	ON subscription_plan.subscription_plan_id  = subscription_plan_price_sum.subscription_plan_id
	WHERE subscription_plan.subscription_plan_is_active = 1"
));

?>