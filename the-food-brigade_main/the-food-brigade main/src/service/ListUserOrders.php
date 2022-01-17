<?php 

require_once "autoloader.php";

echo json_encode(Db::Query(
	"SELECT
		oorder.order_id,
		order_number,
		order_created,
		order_paid,
		order_is_paid,
		
		order_payment_type_id,
		payment_type_name,
		
		order_webuser_id,
		
		order_order_status_id,
		order_status_name,
		
		order_buyer_person_id,
		buyer_person.person_first_name AS buyer_person_first_name,
		buyer_person.person_last_name AS buyer_person_last_name,
		
		order_buyer_organization_id,
		buyer_organization.organization_name AS buyer_organization_name,
		buyer_organization.organization_legal_entity_type_id AS buyer_organization_legal_entity_type_id,
		buyer_organization.organization_legal_entity_type_name AS buyer_organization_legal_entity_type_name,
		buyer_organization.organization_tax_number AS buyer_organization_tax_number,
		
		order_buyer_address_id,
		buyer_address.address_post_code_id AS buyer_address_post_code_id,
		buyer_address.address_post_code_number AS buyer_address_post_code_number,
		buyer_address.address_country_id AS buyer_address_country_id,
		buyer_address.address_country_name AS buyer_address_country_name,
		buyer_address.address_street_id AS buyer_address_street_id,
		buyer_address.address_street_name AS buyer_address_street_name,
		buyer_address.address_street_type_id AS buyer_address_street_type_id,
		buyer_address.address_street_type_name AS buyer_address_street_type_name,
		buyer_address.address_city_id AS buyer_address_city_id,
		buyer_address.address_city_name AS buyer_address_city_name,
		buyer_address.address_house_number AS buyer_address_house_number,
		
		order_seller_person_id,
		seller_person.person_first_name AS seller_person_first_name,
		seller_person.person_last_name AS seller_person_last_name,
		
		order_seller_organization_id,
		seller_organization.organization_name AS seller_organization_name,
		seller_organization.organization_legal_entity_type_id AS seller_organization_legal_entity_type_id,
		seller_organization.organization_legal_entity_type_name AS seller_organization_legal_entity_type_name,
		seller_organization.organization_tax_number AS seller_organization_tax_number,
		
		order_seller_address_id,
		seller_address.address_post_code_id AS seller_address_post_code_id,
		seller_address.address_post_code_number AS seller_address_post_code_number,
		seller_address.address_country_id AS seller_address_country_id,
		seller_address.address_country_name AS seller_address_country_name,
		seller_address.address_street_id AS seller_address_street_id,
		seller_address.address_street_name AS seller_address_street_name,
		seller_address.address_street_type_id AS seller_address_street_type_id,
		seller_address.address_street_type_name AS seller_address_street_type_name,
		seller_address.address_city_id AS seller_address_city_id,
		seller_address.address_city_name AS seller_address_city_name,
		seller_address.address_house_number AS seller_address_house_number,
		
		order_orderer_person_id,
		orderer_person.person_first_name AS orderer_person_first_name,
		orderer_person.person_last_name AS orderer_person_last_name,
		
		order_orderer_contact_id,
		orderer_contact.contact_email AS orderer_contact_email,
		orderer_contact.contact_phone AS orderer_contact_phone,
		
		order_recipient_person_id,
		recipient_person.person_first_name AS recipient_person_first_name,
		recipient_person.person_last_name AS recipient_person_last_name,
		
		order_recipient_contact_id,
		recipient_contact.contact_email AS recipient_contact_email,
		recipient_contact.contact_phone AS recipient_contact_phone,
		
		order_dropoff_address_id,
		dropoff_address.address_post_code_id AS dropoff_address_post_code_id,
		dropoff_address.address_post_code_number AS dropoff_address_post_code_number,
		dropoff_address.address_country_id AS dropoff_address_country_id,
		dropoff_address.address_country_name AS dropoff_address_country_name,
		dropoff_address.address_street_id AS dropoff_address_street_id,
		dropoff_address.address_street_name AS dropoff_address_street_name,
		dropoff_address.address_street_type_id AS dropoff_address_street_type_id,
		dropoff_address.address_street_type_name AS dropoff_address_street_type_name,
		dropoff_address.address_city_id AS dropoff_address_city_id,
		dropoff_address.address_city_name AS dropoff_address_city_name,
		dropoff_address.address_house_number AS dropoff_address_house_number,
		
		order_total_price
	FROM
		`order` AS oorder
	INNER JOIN
		payment_type
	ON oorder.order_payment_type_id = payment_type.payment_type_id
	INNER JOIN
		order_status
	ON oorder.order_order_status_id = order_status.order_status_id
	LEFT JOIN
		person AS buyer_person
	ON oorder.order_buyer_person_id = buyer_person.person_id
	LEFT JOIN
		view_organization AS buyer_organization
	ON oorder.order_buyer_organization_id = buyer_organization.organization_id
	INNER JOIN
		view_address AS buyer_address
	ON oorder.order_buyer_address_id = buyer_address.address_id
	LEFT JOIN
		person AS seller_person
	ON oorder.order_seller_person_id = seller_person.person_id
	LEFT JOIN
		view_organization AS seller_organization
	ON oorder.order_seller_organization_id = seller_organization.organization_id
	INNER JOIN
		view_address AS seller_address
	ON oorder.order_seller_address_id = seller_address.address_id
	INNER JOIN
		person AS orderer_person
	ON oorder.order_orderer_person_id = orderer_person.person_id
	INNER JOIN
		contact AS orderer_contact
	ON oorder.order_orderer_contact_id = orderer_contact.contact_id
	INNER JOIN
		person AS recipient_person
	ON oorder.order_recipient_person_id = recipient_person.person_id
	INNER JOIN
		contact AS recipient_contact
	ON oorder.order_recipient_contact_id = recipient_contact.contact_id
	INNER JOIN
		view_address AS dropoff_address
	ON oorder.order_dropoff_address_id = dropoff_address.address_id
	INNER JOIN
	(
		SELECT
			order_item_order_id AS order_id,
			SUM(order_item_quantity * price_value) AS order_total_price
		FROM
			order_item
		INNER JOIN
			price
		ON order_item.order_item_price_id = price.price_id
		WHERE 
			status = 1 AND order_item_status_id = 1
		GROUP BY order_item_order_id
	) AS oorder_total_price
	ON oorder.order_id = oorder_total_price.order_id
	WHERE oorder.status = 1 AND order_webuser_id = :order_webuser_id",
	['order_webuser_id' => $_GET['webuser_id']]
));

?>