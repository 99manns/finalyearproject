<?php

use Base\Offer as BaseOffer;

/**
 * Skeleton subclass for representing a row from the 'offer' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Offer extends BaseOffer
{
	function setValues($handler){
		$c=$handler->CompanyID;
		$name = $handler -> getValue('name');
		$disc = $handler -> getValue('disc');

		$qty = $handler -> getValue('qty');		
		$start = $handler -> getValue('startDate');
		$end = $handler -> getValue('endDate');
		$discount = $handler -> getValue('discount');
		
		$user = $handler -> getValue('customerid');
		$prod = $handler -> getValue('productid');
		
		if($disc <> null)
			$this -> setDescription($disc);
		$this -> setCompanyid($c);
		if($name <> null)
			$this -> setName($name);
		if($qty <> null)
			$this -> setQuanitity($qty);
		if($discount <> null)
			$this -> setDiscount($discount);
		if($start <> null)
			$this -> setStartDate($start);
		if($end <> null)
			$this -> setEndDate($end);
		if($user <> null)
			$this -> setUserid($user);
		if($prod <> null)
			$this -> setProductid($prod);
		
	}

}
