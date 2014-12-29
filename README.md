Cakephp TableHelper
==================
To display retrieved entry in table with sorting and pagination feature.
- author ”Yusuf Widiyatmono <yusuf.widiyatmono@wmonou.com>”
- modified from steveklebanoff https://github.com/steveklebanoff/cakephp-table-helper/blob/master/table.php

<code>
// Usage of Table Helper
// On your controller
$this->set('users', $this->paginate('Property'));

// You have array set on your controller for your data
$properties = array(
 	[0] => array(
 		['Property'] => array(
			['id'] => 12
 			['address_id'] => 96
 			['description'] => An okay apartment
 			['price'] => 300
 			['type'] => apartment
 			['num_bedrooms'] => 1
 		)
 		['Address'] => array(
			['id'] => 96
 			['address1'] => 650 Columbus Ave
 			['address2'] =>
 			['city'] => Boston
			['state'] => MA
			['zip'] => 1104
 		)
 	)
	...
);

// You want to show some field of your properties data
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
// You have action for each row
$actions = array(
	'View' => array(
		'urlPrefix' => '/properties/view/', 	// urlPrefix -- mandatory
		'urlParam' =>'Property.id', 			// Linking to property id -- mandatory or fill null
  		'iconClass' => 'fa fa-eye',			    // Usage font-awesome class
  		'confirm' => 'are you sure?',			// Html helper confirm
  		'options' => array()),					// Html helper options
        'Edit Address' => array(
  		'urlPrefix' => '/address/edit/',
  		'fieldName' =>'Address.id',
  		'iconClass' => 'fa fa-pencil',
  		'confirm' => 'are you sure?',
  		'options' => array()));

// You want to generate the table
echo $this->Table->createTable('Property', $properties, $displayFields, $tableOption, $actions);
</code>