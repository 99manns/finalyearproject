<?php
/**
 *  @file master.php
 *  @brief load libaires 
 */
require_once 'vendor/autoload.php';
require_once 'vendor\bin\generated-conf\config.php';
$files1 = glob('models/Base/*.php');
$files2 = glob('models/Map/*.php');
$files = glob('models/*.php');
foreach($files1 as $file){
	require_once $file; 
}
foreach($files2 as $file){
	require_once $file; 
}
foreach($files as $file){
	require_once $file; 
}
	class handler{
		
		public $CompanyID="";
		public $UserID="";
		public $APIKey="";
		public $FName="";
		public $ID="";
		public $Method="";
		public $Status = array(
			1 =>'OK',
			2 => 'Unauthenticated',
			3 => 'Method not found',
			4 => 'Unauthorised',
			5 => "Object doesn't exists",
			6 => "Offers ran out",
			7 => "No stock",
			8 => "Internal Error"
		);
		public $results ='';
		/**
		 *  @brief get request method
		 *  
		 *    
		 *  @details assign method
		 */
		public function __construct(){
			$Method=$_SERVER['REQUEST_METHOD'];
		}
		/**
		 *  @brief assign variables		 *  
		 *  
		 *  @details assign requset and common variables
		 */
		public function parseRequest(){
			$request = rtrim($_SERVER['QUERY_STRING']);//get everthing after ?
			parse_str($request,$this ->results);						
			$this ->CompanyID = $this ->results['CompanyID']; //get the value after CompanyID in the querysting
			$this ->UserID =$this ->results['UserID'];
			$this ->APIKey = $this ->results['APIKey'];			
			$this ->FName = $this ->results['FName'];
			if(array_key_exists('ID',$this ->results))
				$this ->ID = $this ->results['ID'];//only assign if exsits in string
		}
		/**
		 *  @brief authenticate
		 *  
		 *  @return if authenticated
		 *  
		 *  @details see if comnapy api matchs suplied api & that user/function is defined
		 */
		public function authenticate(){	
			if($this-> CompanyID <> null){
				$company = CompanyQuery::create()->findPK($this-> CompanyID);
				if($company -> getAPIKey() <> $this->APIKey){					
					return false; //if don't match
				}else if($this->UserID <> null&& $this->FName<>null){					
					return true; //if all need varables are filled in and apikeys match
				}else					
					return false;
			}else{				
				return false;
			}
		}
		
		public function getCompany(){
			return CompanyQuery::create()->findPK($this->CompanyID);
		}
		
		public function getValue($key){
			if(array_key_exists($key,$this ->results)){
				return $this ->results[$key];
			}else
				return null;
		}
		public function authorised(){
			$user = UserQuery::create()->findPK($this->UserID);
			return $user->isadmin();
		}
	}
	
?>