<?php 

require_once "autoloader.php";

echo json_encode(Db::Query(
	"SELECT
		subscription_id,
		subscription_subscribed,
		subscription_duration,
		subscription_next_delivery,
		subscription_webuser_id,
		subscription_subscription_plan_id,
		subscription_plan_image,
		subscription_plan_name,
		subscription_plan_description,
		
		subscription_payment_type_id,
		payment_type_name,
		
		subscription_buyer_person_id,
		buyer_person.person_first_name AS buyer_person_first_name,
		buyer_person.person_last_name AS buyer_person_last_name,
		
		subscription_buyer_organization_id,
		buyer_organization.organization_name AS buyer_organization_name,
		buyer_organization.organization_legal_entity_type_id AS buyer_organization_legal_entity_type_id,
		buyer_organization.organization_legal_entity_type_name AS buyer_organization_legal_entity_type_name,
		buyer_organization.organization_tax_number AS buyer_organization_tax_number,
		
		subscription_buyer_address_id,
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
		
		subscription_orderer_person_id,
		orderer_person.person_first_name AS orderer_person_first_name,
		orderer_person.person_last_name AS orderer_person_last_name,
		
		subscription_orderer_contact_id,
		orderer_contact.contact_email AS orderer_contact_email,
		orderer_contact.contact_phone AS orderer_contact_phone,
		
		subscription_recipient_person_id,
		recipient_person.person_first_name AS recipient_person_first_name,
		recipient_person.person_last_name AS recipient_person_last_name,
		
		subscription_recipient_contact_id,
		recipient_contact.contact_email AS recipient_contact_email,
		recipient_contact.contact_phone AS recipient_contact_phone,
		
		subscription_dropoff_address_id,
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
		dropoff_address.address_house_number AS dropoff_address_house_number
	FROM 
		subscription
	INNER JOIN
		subscription_plan
	ON subscription.subscription_subscription_plan_id = subscription_plan.subscription_plan_id
	INNER JOIN
		payment_type
	ON subscription.subscription_payment_type_id = payment_type.payment_type_id
	LEFT JOIN
		person AS buyer_person
	ON subscription.subscription_buyer_person_id = buyer_person.person_id
	LEFT JOIN
		view_organization AS buyer_organization
	ON subscription.subscription_buyer_organization_id = buyer_organization.organization_id
	INNER JOIN
		view_address AS buyer_address
	ON subscription.subscription_buyer_address_id = buyer_address.address_id
	INNER JOIN
		person AS orderer_person
	ON subscription.subscription_orderer_person_id = orderer_person.person_id
	INNER JOIN
		contact AS orderer_contact
	ON subscription.subscription_orderer_contact_id = orderer_contact.contact_id
	INNER JOIN
		person AS recipient_person
	ON subscription.subscription_recipient_person_id = recipient_person.person_id
	INNER JOIN
		contact AS recipient_contact
	ON subscription.subscription_recipient_contact_id = recipient_contact.contact_id
	INNER JOIN
		view_address AS dropoff_address
	ON subscription.subscription_dropoff_address_id = dropoff_address.address_id
	WHERE 
		subscription.status = 1 AND subscription_webuser_id = :subscription_webuser_id",
		['subscription_webuser_id' => $_GET['webuser_id']]
));

?>