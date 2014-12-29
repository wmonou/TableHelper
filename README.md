CakePHP TableHelper
===================
Ajax user management dashboard
- Demo : http://pukis.kodehive.com
- Username : superdemo, admindemo, userdemo
- Password : demoo123

CakePHP is choosen for this projects because its provides the main reason of a framework which would help us to launch the project faster.
In the other side, using ajax will faster your application load since it doesn't to transfer the additional resources (css, js, etc) everytime request is performed. Ajax bypasing to check wheter they are exist or not on your web browser cache.

Features :
-  Ajax User Management - Ajax access control list user management
- Json Configuration Management - Configuration setting management for your application in json
- Table Helper - Generate your table with sorting and pagination only by configurations

Plan for Future Version :
- Frontend - Angular.js integration
- Backend - SOA architecture
- Functionality - Emails
- Functionality - Pages and Menu

Installation :
- Copy these source to your document root (/var/www, etc)
- Dump database schema from App/Modules/Pukis/Config/Schema
- Configure your database configuration App/Config/database.php

Sorry - there is no automatic instalation procedure yet, but you are programmer should be easily to do it.

To implement ajax view on your view, jQuery ajax has been encapsulate to be a simple function

Usage of Table Helper

On your controller

<code>
$this->set('users', $this->paginate('Property'));
</code>

You have array set on your controller for your data

<code>
	$properties = array(
	 	0 => array(
	 		'Property' => array(
				'id' => 12
	 			'address_id' => 96
	 			'description' => An okay apartment
	 			'price' => 300
	 			'type' => apartment
	 			'num_bedrooms' => 1
	 		)
	 		'Address' => array(
				'id' => 96
	 			'address1' => 650 Columbus Ave
	 			'address2' =>
	 			'city' => Boston
				'state' => MA
				'zip' => 1104
	 		)
	 	)
		...
	);
</code>

You want to show some field of your properties data

<code>
	$displayFields = array(
		'Type' => 'type',
		Address1' => 'Address.address1',
		City' => array(							// if its array, the entry generated will have links
			'fieldName' => 'Address.city',		// Fielname for entry -- mandatory
			'urlPrefix' => '/city/index/'		// Url for entry -- mandatory
	        'urlParam'  => 'Address.city'		// Linking to Address.city -- mandatory or fill null
		),
	    'State' => 'Address.city',
	    'Price' => 'price',
	    'Bedrooms' => 'num_bedrooms'
	);
</code>

You have action for each row

<code>
	$actions = array(
		'View' => array(
			'urlPrefix' => '/properties/view/', 	// urlPrefix -- mandatory
			'urlParam' =>'Property.id', 			// Linking to property id -- mandatory or fill null
	  		'iconClass' => 'fa fa-eye',			    // Usage font-awesome class
	  		'confirm' => 'are you sure?',			// Html helper confirm
	  		'options' => array()
	  		),					// Html helper options
	    'Edit Address' => array(
	  		'urlPrefix' => '/address/edit/',
	  		'fieldName' =>'Address.id',
	  		'iconClass' => 'fa fa-pencil',
	  		'confirm' => 'are you sure?',
	  		'options' => array()
	  	)
	);
</code>

You want to generate the table

<code>
	echo $this->Table->createTable('Property', $properties, $displayFields, $tableOption, $actions);
</code>

Hope this will simplify your projects

Wishlist :
Regarding the future development plan of this project, you also can give me ideas what to do.
- http://twitter.com/wmonou - Tweet me for wishlist
- http://wmonou.com - Visit my website for wishlist
