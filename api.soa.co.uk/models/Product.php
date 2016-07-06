<?php

use Base\Product as BaseProduct;

/**
 * Skeleton subclass for representing a row from the 'product' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Product extends BaseProduct
{
	function setValues($handler){
		$c=$handler->CompanyID;		
		$name = $handler -> getValue('name');
		$disc = $handler -> getValue('disc');
		$img = $handler -> getValue('img');
		$price = $handler -> getValue('price');
		
		if($name <> null)
			$this -> setName($name);
		if($disc <> null)
			$this -> setDescription($disc);
		if($img <> null)
			$this -> setImage($img);
		if($price <> null)
			$this -> setPurchaseprice($price);
		$this -> setCompanyid($c);
	}

}
