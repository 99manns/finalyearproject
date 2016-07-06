<?php

use Base\User as BaseUser;

/**
 * Skeleton subclass for representing a row from the 'user' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class User extends BaseUser
{
   public function isadmin(){	   
	   $a = $this -> getPermission();
	   return $a ->getAdmin();
   }
   
   public function getPermission(){
	 return PermissionQuery::create()->findPK($this->getPermissionid());
   }
   
   function setValues($handler){
	   $firstname = $handler -> getValue('firstname');
		$lastname = $handler -> getValue('lastname');
		$email = $handler -> getValue('email');
		$permisson = $handler -> getValue('permissionid');
		$location = $handler -> getValue('locationid');
		$gender = $handler -> getValue('genderid');
		
		if($location <> null)
			$this ->setLocationid($location);
		if($lastname <> null)
			$this ->setLastname($lastname);
		if($firstname <> null)
			$this ->setFirstname($firstname);
		if($permissionid <> null)
			$this ->setPermissionid($permisson);
		if($gender <> null)
			$this ->setGenderid($gender);
   }
}
