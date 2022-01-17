<?php 

require_once "autoloader.php";

echo json_encode(Db::Query(
	"SELECT
		summed_cheese.cheese_type_id,
		cheese_type_name,
		cheese_type_description,
		cheese_type_image,
		cheese_price_id,
		price_value,
		price_is_discount,
		cheese_unit_id,
		unit_postfix,
		cheese_quantity
	FROM
	(
		SELECT 
			cheese_type_id, 
			cheese_price_id, 
			cheese_unit_id, 
			SUM(cheese_quantity) AS cheese_quantity
		FROM
		(
			SELECT 
				cheese_id,
				cheese_type_id,
				cheese_quantity,
				cheese_unit_id,
				CASE 
					WHEN cheese_unique_price_id IS NULL THEN cheese_price_id
					ELSE cheese_unique_price_id
				END AS cheese_price_id
			FROM 
			(
				SELECT
					cheese_id,
					cheese_cheese_type_id,
					cheese_quantity,
					cheese_unit_id,
					cheese_price_id AS cheese_unique_price_id
				FROM cheese 
				WHERE 
					status = 1 AND 
					cheese_order_item_id IS NULL AND 
					cheese_expiry > NOW()
			) AS filtered_cheese
			INNER JOIN
			(
				SELECT
					cheese_type_id,
					cheese_price_id
				FROM cheese_type
				WHERE status = 1
			) AS aux_cheese_type
			ON filtered_cheese.cheese_cheese_type_id = aux_cheese_type.cheese_type_id
		) AS aux_cheese
		GROUP BY cheese_type_id, cheese_price_id, cheese_unit_id
	) AS summed_cheese
	INNER JOIN
	(
		SELECT
			cheese_type_id,
			cheese_type_name,
			cheese_type_description,
			cheese_type_image
		FROM cheese_type
		WHERE status = 1
	) AS filtered_cheese_type
	ON summed_cheese.cheese_type_id = filtered_cheese_type.cheese_type_id
	INNER JOIN
		price 
	ON summed_cheese.cheese_price_id = price.price_id
	INNER JOIN
		unit
	ON summed_cheese.cheese_unit_id = unit.unit_id
	WHERE price_is_discount = 0"
));

?>