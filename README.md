CakePHP TableHelper
===================
modified from steveklebanoff https://github.com/steveklebanoff/cakephp-table-helper/blob/master/table.php

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
