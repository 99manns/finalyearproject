<?php

use Base\Stock as BaseStock;

/**
 * Skeleton subclass for representing a row from the 'stock' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Stock extends BaseStock
{
	function setValues($handler){
		$price = $handler -> getValue('price');
		$qty = $handler -> getValue('qty');
		$prod = $handler -> getValue('productid');
		$vend = $handler -> getValue('vendingid');
		
		if($price <> null)
			$this -> setRetailprice($price);
		if($qty <> null)
			$this -> setQuanitity($qty);
		if($prod <> null)
			$this -> setProductid($prod);
		if($vend <> null)
			$this -> setVendingmachineid($vend);
	}

}
