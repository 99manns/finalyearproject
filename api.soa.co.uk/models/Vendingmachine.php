<?php

use Base\Vendingmachine as BaseVendingmachine;

/**
 * Skeleton subclass for representing a row from the 'vendingmachine' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Vendingmachine extends BaseVendingmachine
{
	function setValues($handler){
		$c=$handler->CompanyID;
		$name = $handler -> getValue('name');
		$loc =  $handler -> getValue('locationid');		
		if($loc <> null)
			$this -> setLocationid($loc);
		$this -> setCompanyid($c);
		if($name <>null)
		$this -> setName($name);
	}

}
