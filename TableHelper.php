<?php

/**
 *
 * @author ”Yusuf Widiyatmono <yusuf.widiyatmono@wmonou.com>”
 * modified from steveklebanoff https://github.com/steveklebanoff/cakephp-table-helper/blob/master/table.php
 */

/**
 * Usage of Table Helper
 * You have array set on your controller for your model properties
 * $properties = array(
 *		[0] => array(
 *				['Property'] => array(
 * 						['id'] => 12
 *						['address_id'] => 96
 *						['description'] => An okay apartment
 *						['price'] => 300
 *						['type'] => apartment
 *						['num_bedrooms'] => 1
 *				)
 *				['Address'] => array(
 *						['id'] => 96
 *						['address1'] => 650 Columbus Ave
 *						['address2'] =>
 *						['city'] => Boston
 *						['state'] => MA
 *						['zip'] => 1104
 *				)
 *		) ...
 * You want to show some field of your properties data
 * $displayFields = array(
 * 						'Type' => 'type',
 *                      'Address1' => 'Address.address1',
 *                      'City' => array(						// if its array, the entry generated will have links
 *                      	'fieldName' => 'Address.city',		// Fielname for entry -- mandatory
 *                      	'urlPrefix' => '/city/index/'		// Url for entry -- mandatory
 *                      	'urlParam'  => 'Adress.city')		// Linking to Address.city -- mandatory or fill null
 *                      'State' => 'Address.city',
 *                      'Price' => 'price',
 *                      'Bedrooms' => 'num_bedrooms');
 * You have action for each row
 * $actions = array('View' => array(
 * 						'urlPrefix' => '/properties/view/', 	// urlPrefix -- mandatory
 * 						'urlParam' =>'Property.id', 			// Linking to property id -- mandatory or fill null
 * 						'iconClass' => 'fa fa-eye',			    // Usage font-awesome class
 * 						'confirm' => 'are you sure?',			// Html helper confirm
 * 						'options' => array()),					// Html helper options
 *                  'Edit Address' => array(
 * 						'urlPrefix' => '/address/edit/',
 * 						'fieldName' =>'Address.id',
 * 						'iconClass' => 'fa fa-pencil',
 * 						'confirm' => 'are you sure?',
 * 						'options' => array()));
 * You want to generate the table
 * echo $this->Table->createTable('Property', $properties, $displayFields, $tableOption, $actions);
 *
 */

class TableHelper extends AppHelper
{
	/**
	 * Helper used in this helper
	 * @var array
	 */
    public $helpers = array('Html', 'Paginator');

    /**
     * Create table header
     *
     * @todo
     * @param array $tableDisplayFields
     * @param array $tableActions
     * @return string
     */
    private function _createTableHeader($tableDisplayFields, $tableActions = array()) {
    	$output = "";
    	$options = "";

    	$output .= "<table class='table table-bordered table-condensed table-hover'>";
    	$output .= "<thead>";
    	$output .= "<tr>";

    	// table header field
    	foreach($tableDisplayFields as $tableDisplayFieldName => $tableDisplayField)
    	{
    		if(is_array($tableDisplayField) && isset($tableDisplayField['fieldName'])){
    			$tableDisplayField = $tableDisplayField['fieldName'];
    		}
    		$tableClass = str_replace('.', '-', strtolower($tableDisplayField));
    		$output .= "<th class='th-$tableClass'>" . $this->Paginator->sort($tableDisplayField, $tableDisplayFieldName) . "</th>";
    	}

    	// if has table header actions
    	if (!empty($tableActions))
    	{
    		$output .= "<th class='th-actions'>Actions</th>";
    	}

    	$output .= "</tr>";
    	$output .= "</thead>";

    	return $output;
    }

    /**
     * Create table footer
     *
     * @param array $tableDisplayFields
     * @param array $tableActions
     * @return string
     */
    private function _createTableFooter($tableDisplayFields, $tableActions = array()){
    	$output = "";

    	$output .= "<tfoot>";
    	$output .= "<tr>";

    	// table footer field
    	foreach($tableDisplayFields as $tableDisplayFieldName => $tableDisplayField)
    	{
    		if(is_array($tableDisplayField) && isset($tableDisplayField['fieldName'])){
    			$tableDisplayField = $tableDisplayField['fieldName'];
    		}

    		$output .= "<th class='th-$tableDisplayField'>" . $tableDisplayFieldName . "</th>";
    	}

    	// if has footer actions
    	if (!empty($tableActions))
    	{
    		$output .= "<th class='th-actions'>Actions</th>";
    	}

    	$output .= "</tr>";
    	$output .= "</tfoot>";
    	$output .= "</table>";

    	return $output;
    }

    /**
     * Retrun field value
     *
     * @param string $defaultModelName
     * @param array $entry
     * @param array $entryDisplayField
     * @return array
     */
    private function _getField($defaultModelName, $entry, $entryDisplayField = null)
    {
    	// $entryDisplayField is null then halt
    	if($entryDisplayField == null)
    		return null;

    	// Determine model names and field name
    	$modelsAndFields = explode('.', $entryDisplayField);
    	if ((sizeof($modelsAndFields)) == 1)
    	{
    		// Field doesn't have any model names in it (i.e. 'allows_pets')
    		$entryModelNames = array($defaultModelName);
    		$entryField = $entryDisplayField;
    	}
    	else
    	{
    		// Field has model names (i.e. 'Property.Address.address1')
    		$modelsAndFieldsLastItemIndex = sizeof($modelsAndFields) - 1;

    		$entryModelNames = array_slice($modelsAndFields, 0, $modelsAndFieldsLastItemIndex );
    		$entryField = $modelsAndFields[$modelsAndFieldsLastItemIndex];
    	}

    	// Get field
    	$fieldToDisplay = $entry;
    	foreach ($entryModelNames as $entryModelName)
    	{
    		$fieldToDisplay = $fieldToDisplay[$entryModelName];
    	}
    	return $fieldToDisplay[$entryField];
    }

    /**
     * Get display field wheter is text or link
     *
     * @param array $defaultModelName
     * @param array $entry
     * @param array $entryDisplayField
     * @return string
     */
    private function _getDisplayField($defaultModelName, $entry, $entryDisplayField)
    {
    	if(is_array($entryDisplayField) && isset($entryDisplayField['fieldName']) && isset($entryDisplayField['urlPrefix']) && isset($entryDisplayField['urlParam']))
    	{
    		list($entryDisplayField, $entryUrlPrefix, $entryUrlParam)  =
    			array($entryDisplayField['fieldName'], $entryDisplayField['urlPrefix'], $entryDisplayField['urlParam']);
    		// get entry display url
    		$entryDisplaynUrl = $entryUrlPrefix . $this->_getField($defaultModelName, $entry, $entryUrlParam);
    	}
    	else if (is_array($entryDisplayField) && $entryDisplayField['fieldName'])
    	{
    		$entryDisplayField = $entryDisplayField['fieldName'];
    	}

    	// retrive field display value
    	$fieldToDisplay = $this->_getField($defaultModelName, $entry, $entryDisplayField);

    	// attach link to field display
    	if (isset($entryDisplaynUrl))
    		return $this->Html->link($fieldToDisplay, $entryDisplaynUrl);

    	return $fieldToDisplay;
    }

    /**
     * get action field
     *
     * @param unknown $defaultModelName
     * @param unknown $entry
     * @param array $tableActions
     * @return string
     */
    private function _getActionField($defaultModelName, $entry, $entryDisplayField = null, $entryActions = array()) {
    	$output = "";
    	foreach ($entryActions as $entryActionKey => $entryActionValue)
    	{
    		if (isset($entryActionValue['urlPrefix']) && isset($entryActionValue['urlParam'])) {
    			list($actionName, $actionUrlPrefix, $actionUrlParam)  =
    			array($entryActionKey, $entryActionValue['urlPrefix'], $entryActionValue['urlParam']);

    			if(isset($entryActionValue['iconClass']))
    				$actionName = $this->Html->tag('i', "&nbsp", array('class' => $entryActionValue['iconClass'])) . $actionName;

    			$actionConfirm = false;
    			if(isset($entryActionValue['confirm']))
    				$actionConfirm = $entryActionValue['confirm'];

    			$actionOption = array();
    			if(isset($entryActionValue['options']))
    				$actionOption = $entryActionValue['options'];
    			$actionOption['escape'] = false;

    			$actionUrl = $actionUrlPrefix . $this->_getField($defaultModelName, $entry, $actionUrlParam);
    			$output .= $this->Html->link($actionName, $actionUrl, $actionOption, $actionConfirm);
    			$output .= " ";
    		} else {
    			$output .= $this->Html->link($entryActionKey, $entryActionValue);
    		}
    	}
    	return $output;
    }

    /**
     * Create table
     *
     * @param String $tableModelName
     * @param array $tableEntries
     * @param array $tableDisplayFields
     * @param array $tableActions
     * @return string
     */
    public function createTable($tableModelName, $tableEntries, $tableDisplayFields, $tableActions = array())
    {
		$output = "";
		// Get table header
		$output .= $this->_createTableHeader($tableDisplayFields, $tableActions);

		// return message when there is no data to generate
		if (empty($tableEntries))
			return "no data to generate table";

        // Create entries
        foreach ($tableEntries as $entry)
        {
            $output .= "<tr>";
            // print table output
            foreach($tableDisplayFields as $tableDisplayFieldName => $tableDisplayField)
            {
            	$fieldToDisplay = $this->_getDisplayField($tableModelName, $entry, $tableDisplayField);
                $output .= "<td>" . $fieldToDisplay . "</td>";
            }
            // if has table action
            if (!empty($tableActions))
            {
                $actionFieldToDisplay = $this->_getActionField($tableModelName, $entry, $tableDisplayField, $tableActions);
            	$output .= "<td>" . $actionFieldToDisplay . "</td>";
            }
            $output .= "</tr>";
        }

        $output .= $this->_createTableFooter($tableDisplayFields, $tableActions);

        $output .= $this->_createPaginator();

        return $output;
    }

    /**
     *
     * @param unknown $class
     * @param string $prevClass
     * @param string $nextClass
     * @return string
     */
    private function _createPaginator(){

    	$output = "";
    	$output.= "<div class='btn-group' role='group'>";

    	$output.= $this->Paginator->prev(
					"<i class='fa fa-angle-left'></i> " . __d('pukis', 'prev'),
					array('class' => 'btn btn-default prev', 'tag' => 'a', 'escape' => false),
					"<i class='fa fa-angle-left'></i> " . __d('pukis', 'prev'),
					array('class' => 'btn btn-default prev disabled', 'tag'=>'a', 'escape' => false)
					);

    	$output.= $this->Paginator->numbers(array(
    		'class'=>'btn btn-default', 'tag' => 'a', 'currentClass' => 'btn btn-primary', 'currentTag' => 'a'
    		));

    	$output.= $this->Paginator->next(
	    			__d('pukis', 'next') . " <i class='fa fa-angle-right'></i>",
	    			array('class' => 'btn btn-default next', 'tag' => 'a', 'escape' => false),
	    			__d('pukis', 'next') . " <i class='fa fa-angle-right'></i>",
	    			array('class' => 'btn btn-default next disabled', 'tag'=>'a', 'escape' => false)
    	);

    	$output.= "</div>";

    	return $output;
    }
}