<?php

use Base\Location as BaseLocation;

/**
 * Skeleton subclass for representing a row from the 'location' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Location extends BaseLocation
{
	function setValues($hanler){
		$address = $handler -> getValue('address');
		$towncity =$handler -> getValue('city');
		$county = $handler -> getValue('country');
		$post = $handler -> getValue('postcode');
				
		if($address <> null)
			$this -> setAddressline($address);
		if($towncity <> null)
			$this -> setTowncity($towncity);
		if($country <> null)
			$this -> setCountry($county);
		if($post <> null)
			$this -> setPostcode($post);
	}
}
