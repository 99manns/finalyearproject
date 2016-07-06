<?php
include 'master.php';
use Propel\Runtime\Propel;
use Map\ItemTableMap;

 header("Access-Control-Allow-Origin: *"); 
 header("Access-Control-Allow-Methods: *");
 header("Content-Type: application/json"); 
 header("HTTP/1.1");
 
$EP= new endpoints();
echo $EP ->process();
//http://api.soa.co.uk/addLocation?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&address=cast&city=Newbury&country=UK
class endpoints
{		
	public $handler;
	
	function __construct(){						
		global $handler;
		 
		$handler = new handler();
		$handler->parseRequest();			
		if(!$handler->authenticate()){				
			return $handler->Status[2];
		}			
	}
	public function process(){
		global $handler;		
		if(method_exists($this,$handler->FName)){				
			return $this->{$handler->FName}();
		}else{			
			return json_encode( $handler->Status[3]);
		}
	}
	/**http://api.soa.co.uk/addVendingMachine?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=2&name=cokeuor&locationid=1
	 *  @brief addVendingMachine
	 *  
	 *  @return Status or vending mail
	 *  
	 *  @details addVendingMachine
	 */
	function addVendingMachine(){		
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$Vend = new VendingMachine();
		$Vend-> setValues($handler);
		$Vend-> save();
		
		return $Vend ->toJson();
	}
	function updateVendingMachine(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$Vend = VendingmachineQuery::create()->findPK($handler->ID);
		$Vend-> setValues($handler);
		$Vend-> save();
		
		return $Vend ->toJson();
	}
	function deleteVendingMachine(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$Vend = VendingmachineQuery::create()->findPK($handler->ID);
		$Vend-> setDelted(true);
		$Vend-> save();
		
		return $Vend ->toJson();
	}
	//http://api.soa.co.uk/addProduct?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=2&name=coke-200ml&disc=200ml can of coke&img=api.soa.co.uk/images?i=coke
	function addProduct(){
		global $handler;
		
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}		
				
		$prod = new Product();
		$prod -> setValues($handler);
		$prod -> save();
		
		return $prod->toJson();
	}
	function updateProduct(){
		global $handler;		
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}						
		$prod = ProductQuery::create()->findPK($handler->ID);
		$prod -> setValues($handler);
		$prod -> save();
		
		return $prod->toJson();
	}
	function delteProduct(){
		global $handler;		
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}						
		$prod = ProductQuery::create()->findPK($handler->ID);
		$prod -> setDelted(true);
		$prod -> save();
		
		return $prod->toJson();
	}
	//http://api.soa.co.uk/addStock?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=2&price=12.54&qty=23&productid=1&vendingid=1
	function addStock(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
						
		$stock = new Stock();
		$stock-> setValues($handler);
		$stock -> save();
		
		return $stock->toJson();
	}
	function updateStock(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
						
		$stock = StockQuery::create()-> findPK($handler->ID);
		$stock-> setValues($handler);
		$stock -> save();
		
		return $stock->toJson();
	}
	
	//http://api.soa.co.uk/addOffer?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=2&name=£10off&disc=£10 off any purchase before 22-11-2015&endDate=22-11-2015&discount=9.99&customerid=1
	function addOffer(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		
		$offer = new Offer();
		$offer -> setValues($handler);
		$offer -> save();
		
		return $offer->toJson();	
	}
	function updateOffer(){
	global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		
		$offer = OfferQuery::create()->findPK($handler -> ID);
		$offer -> setValues($handler);		
		$offer -> save();
		
		return $offer->toJson();	
	}
	function deleteOffer(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		
		$offer = OfferQuery::create()->findPK($handler -> ID);
		$offer -> setDelted(true);
		$offer -> save();
		
		return $offer->toJson();
	}
	//http://api.soa.co.uk/addUser?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3
	function addUser(){
		global $handler;
		if(UserQuery::create()->findPK($handler ->UserID)->getPermission()->getName() != "Admin"){
			return json_encode($handler -> Status[2]);
		}
		
		$User = new User();
		$User-> setValues($handler);
		$User->save();
		
		return $User ->toJson();
	}
	function updateUser(){		
		global $handler;
		if(UserQuery::create()->findPK($handler ->UserID)->getPermission()->getName() != "Admin"){
			return json_encode($handler -> Status[2]);
		}
		
		$User = UserQuery::create()->findPK($handler ->ID);
		$User-> setValues($handler);
		$User->save();
		
		return $User ->toJson();
	}
	function deleteUser(){
		global $handler;
		if(UserQuery::create()->findPK($handler ->UserID)->getPermission()->getName() != "Admin"){
			return json_encode($handler -> Status[2]);
		}
		
		$User = UserQuery::create()->findPK($handler ->ID);
		$User-> setDelted(true);
		$User->save();
		
		return $User ->toJson();
	}
	//http://api.soa.co.uk/addLocation?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&address=cast&city=Newbury&country=UK
	function addLocation(){
		global $handler;
		if(UserQuery::create()->findPK($handler ->UserID)->getPermission()->getName() != "Admin"){
			return json_encode($handler -> Status[2]);
		}
				
		$Location = new Location();
		$Location-> setValues($handler);
		$Location ->save();
		
		return $Location->toJson();
	}
	function updateLocation(){
		global $handler;
		if(UserQuery::create()->findPK($handler ->UserID)->getPermission()->getName() != "Admin"){
			return json_encode($handler -> Status[2]);
		}
				
		$Location = LocationQuery::create()-> findPK($handler-ID);
		$Location-> setValues($handler);
		$Location ->save();
		
		return $Location->toJson();
	}
	function deleteLocation(){
		global $handler;
		if(UserQuery::create()->findPK($handler ->UserID)->getPermission()->getName() != "Admin"){
			return json_encode($handler -> Status[2]);
		}
				
		$Location = LocationQuery::create()-> findPK($handler-ID);
		$Location-> setDelted(true);
		$Location ->save();
		
		return $Location->toJson();
	}
	
	/***Search 
	 *  
	 *  
	 */
	 //http://api.soa.co.uk/vendingByCompany?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&ID=1
	function vendingByCompany(){
		global $handler;		
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$loc = VendingmachineQuery::create()->filterByCompanyid($handler->ID)
		->joinWith("Vendingmachine.Location")
		-> find();
		
		return $loc -> toJson();
	}
	//http://api.soa.co.uk/productByCompany?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&ID=1
	function productByCompany(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$loc = ProductQuery::create()->filterByCompanyid($handler->ID)
		-> find();
		return $loc -> toJson();
	}
//http://api.soa.co.uk/offerByCompany?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&ID=1	
	function offerByCompany(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$loc = OfferQuery::create()->filterByCompanyid($handler->ID)
		->filterByDelted(false)
		->leftJoinWith("Offer.Product")
		->leftJoinWith("Offer.User")		
		-> find();
		return $loc -> toJson();
	}
	//http://api.soa.co.uk/stockByVending?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&ID=1
	function stockByVending(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$loc = StockQuery::create()->filterByVendingMachineid($handler->ID)
		->joinWith("Stock.Vendingmachine")
		->joinWith("Stock.Product")
		-> find();
		return $loc -> toJson();
	}
	//get all location
	function loactions(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$loactions = LocationQuery::create()
		->filterByDelted(false)
		->find();
		return $loactions->toJson();
	}
	//get all users
	function customers(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$cust = UserQuery::create()
		->filterByDelted(false)
		->find();
		return $cust-> toJson();
	}
	//get all Compnaies
	function companies(){
		global $handler;
		if(!$handler->authorised()){
			return $handler -> Status[4];
		}
		$cust = CompanyQuery::create()
		->filterByDelted(false)
		->find();
		return $cust-> toJson();
	}
	
	//http://api.soa.co.uk/vendingStockByLocation?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&ID=1
	function vendingStockByLocation(){
		global $handler;
		
		$stocks = StockQuery::create()->where('Stock.Quanitity >?',0)
		->joinWith('Stock.Product')
		->useVendingmachinequery()
			->filterByLocationid($handler->ID)
		->endUse()->with('Vendingmachine')
		->find();
							
		return $stocks -> toJson();
	}
	//http://api.soa.co.uk/offers?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3
	function offers(){
		global $handler;
		
		$offer = OfferQuery::create() -> filterByDelted(false)
		-> where("Offer.Startdate <?",Date('c'));
		
		$cust = $handler-> getValue('customerid');
		$pro = $handler-> getValue('productid');
		
		if($cust <> null &&$pro <> null )
			$offer = $offer -> filterByUserid($cust) ->filterByProductid($pro);
		else if($cust <> null)
			$offer = $offer -> filterByUserid($cust) -> where("Offer.Productid IS NULL");
		else if($pro <> null)
			$offer = $offer -> filterByProductid($pro) -> where("Offer.Userid IS NULL");
		
		return $offer -> find() -> toJson();
	}
	
	function order(){
		global $handler;		
		$cust =$handler -> getValue('customerid');
		$offer = $handler -> getValue('offerid');
		$stock = $handler -> getValue('stockid');		
		$stocks = StockQuery::create() -> findPK($stock);
		$vend = $stocks -> getVendingmachineid();//find values from stockid
		$prod = $stocks -> getProductid();
		$sprice = $stocks -> getRetailprice();
		$pprice = ProductQuery::create()->findPK($prod)->getPurchaseprice();
		
		if($offer <> null)
			$offers = OfferQuery::create()->findPK($offer);//get offer				
		if($stocks -> getQuanitity() <=0){
			return $handler -> Status[7]; //if no stock return error
		}
		if($offers <> null){
			if($offers -> getEnddate() <=  date('c') && $offers -> getEnddate() != null){
				$offers -> setDelted(true);
				$offers -> save();//if offer expired delete and return error
				return $handler -> Status[6];
			}
			if($offers -> getQuanitity()<=0 && $offers -> getQuanitity()!= null){
				$offers -> setDelted(true);
				$offers -> save();//if offer ran out delte and return error
				return $handler -> Status[6];
			}
			$sprice -= $offers -> getDiscount();
			if($sprice<0){
				$sprice =0; //make sure price is at least 0
			}
		}		
		 $con = Propel::getWriteConnection(ItemTableMap::DATABASE_NAME);
		$con -> beginTransaction();//wrap in transaction as multiple updates
		$Order = new Item();
		try{			
			$Order -> setProductid($prod);
			$Order -> setUserid($cust);
			$Order -> setVendingMachineid($vend);
			$Order -> setPurchaseprice($pprice);
			
			if($offers <> null){
				$Order -> setOfferid($offer);
				if($offers -> getQuanitity()!= null)
					$offers -> setQuanitity($offers -> getQuanitity()-1);
				$offers -> save($con);//update offer
			}
			$Order -> setSaleprice($sprice);
			$Order -> setAddeddate(date('c') );//date(Y-m-d H:i:s)
			
			$stocks -> setQuanitity($stocks -> getQuanitity()-1);			
			$Order ->save($con);			
			$stocks -> save($con);//update stock
			
			$con -> commit();//process all updates
		}catch(Exception $e){
			$con -> rollback();//if error revese any changes and return error
			return json_encode($handler->Status[8]);
		}
		return $Order->toJson();	
		}

	//report (Location)
	function profitByProduct(){
		global $handler;
		$sdate = $handler ->getValue('start');
		$edate = $handler ->getValue('end');
		
		$items = ItemQuery::create()
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		-> where("Item.Addeddate >?",$sdate)-> where("Item.Addeddate <?",$edate)
		->withColumn("sum(Item.Saleprice - Item.Purchaseprice)","Profit")
		->joinWith("Item.Product")
		->withColumn("Product.Name","ProductName")
		->groupBy("Item.Productid")
		-> select(array("ProductName","Profit"))
		->find();
		
		return $items -> toJson();
	}
	function profitByCustomer(){
		global $handler;
		$sdate = $handler ->getValue('start');
		$edate = $handler ->getValue('end');
		
		$items = ItemQuery::create()
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		-> where("Item.Addeddate >?",$sdate)-> where("Item.Addeddate <?",$edate)
		->withColumn("sum(Item.Saleprice - Item.Purchaseprice)","Profit")
		->joinWith("Item.User")
		->withColumn("User.Email","UserEmail")
		->groupBy("Item.Userid")
		-> select(array("UserEmail","Profit"))
		->find();
		
		return $items -> toJson();
	}
	function salesByCustomer(){
		global $handler;
		$sdate = $handler ->getValue('start');
		$edate = $handler ->getValue('end');
		
		$items = ItemQuery::create()
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		-> where("Item.Addeddate >?",$sdate)-> where("Item.Addeddate <?",$edate)
		->withColumn("count(Item.Itemid)","Sales")
		->joinWith("Item.User")
		->withColumn("User.Email","UserEmail")
		->groupBy("Item.Userid")
		-> select(array("UserEmail","Sales"))
		->find();
		
		return $items -> toJson();
	}
	function salesByProduct(){
		global $handler;
		$sdate = $handler ->getValue('start');
		$edate = $handler ->getValue('end');
		
		$items = ItemQuery::create()
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		-> where("Item.Addeddate >?",$sdate)-> where("Item.Addeddate <?",$edate)
		->withColumn("count(Item.Itemid)","Sales")
		->joinWith("Item.Product")
		->withColumn("Product.Name","ProductName")
		->groupBy("Item.Productid")
		-> select(array("ProductName","Sales"))
		->find();
		
		return $items -> toJson();
	}
	function offersByProduct(){
		global $handler;
		$sdate = $handler ->getValue('start');
		$edate = $handler ->getValue('end');
		
		$items = ItemQuery::create()
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		-> where("Item.Addeddate >?",$sdate)-> where("Item.Addeddate <?",$edate)
		->where("Item.Offerid IS NOT NULL")
		->withColumn("count(Item.Itemid)","Offer")
		->joinWith("Item.Product")
		->withColumn("Product.Name","ProductName")
		->groupBy("Item.Productid")
		-> select(array("ProductName","Offer"))
		->find();
		
		return $items -> toJson();
	}
	function offersByCustomer(){
		global $handler;
		$sdate = $handler ->getValue('start');
		$edate = $handler ->getValue('end');
		
		$items = ItemQuery::create()
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		-> where("Item.Addeddate >?",$sdate)-> where("Item.Addeddate <?",$edate)
		->where("Item.Offerid is Not NULL")
		->withColumn("count(Item.Itemid)","Offer")
		->joinWith("Item.User")
		->withColumn("User.Email","UserEmail")
		->groupBy("Item.Userid")
		-> select(array("UserEmail","Offer"))
		->find();
		
		return $items -> toJson();
	}
	//http://api.soa.co.uk/salesByLocation?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&start=2015-01-01&end=2016-01-01
	function salesByLocation(){
		global $handler;		
		$sdate = $handler ->getValue('start');
		$edate = $handler ->getValue('end');
		
		$items = ItemQuery::create()
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		-> where("Item.Addeddate >?",$sdate)-> where("Item.Addeddate <?",$edate)		
		->withColumn("count(Item.Itemid)","Sales")
		->joinWith("Item.Vendingmachine")
		->joinWith("Vendingmachine.Location")
		->withColumn("Location.Addressline","Location")
		->groupBy("Vendingmachine.Locationid")
		-> select(array("Location","Sales"))
		->find();
		
		return $items -> toJson();		
	}
	function offersByLocation(){
		global $handler;		
		$sdate = $handler ->getValue('start');
		$edate = $handler ->getValue('end');
		
		$items = ItemQuery::create()
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		->where("Item.Offerid is Not NULL")
		-> where("Item.Addeddate >?",$sdate)-> where("Item.Addeddate <?",$edate)		
		->withColumn("count(Item.Itemid)","Offer")
		->joinWith("Item.Vendingmachine")
		->joinWith("Vendingmachine.Location")
		->withColumn("Location.Addressline","Location")
		->groupBy("Vendingmachine.Locationid")
		-> select(array("Location","Offer"))
		->find();
		
		return $items -> toJson();		
	}
	function profitByLocation(){		
		global $handler;
		$sdate = $handler ->getValue('start');
		$edate = $handler ->getValue('end');
		
		$items = ItemQuery::create()
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()		
		-> where("Item.Addeddate >?",$sdate)-> where("Item.Addeddate <?",$edate)		
		->withColumn("sum(Item.Saleprice - Item.Purchaseprice)","Profit")
		->joinWith("Item.Vendingmachine")
		->joinWith("Vendingmachine.Location")
		->withColumn("Location.Addressline","Location")
		->groupBy("Vendingmachine.Locationid")
		-> select(array("Location","Profit"))
		->find();
		
		return $items -> toJson();	
	}
	//http://api.soa.co.uk/Revenue?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&month=0&year=2015
	function Revenue(){
		global $handler;		
		
		$items = ItemQuery::create()		
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		->withColumn("sum(Item.Saleprice)","Revenue")	
		->withColumn("MonthName(Item.Addeddate)","MonthName")
		->withColumn("Year(Item.Addeddate)","Year")
		->withColumn("Month(Item.Addeddate)","Month")
		->groupBy("Year")->groupBy("Month")
		-> select(array("Revenue","MonthName"))
		->find();
		
		return $items -> toJson();
	}
	function Profit(){
		global $handler;
				
		$items = ItemQuery::create()		
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)
		->endUse()
		->withColumn("sum(Item.Saleprice - Item.Purchaseprice)","Profit")
		->withColumn("MonthName(Item.Addeddate)","MonthName")
		->withColumn("Year(Item.Addeddate)","Year")
		->withColumn("Month(Item.Addeddate)","Month")
		->groupBy("Year")->groupBy("Month")
		-> select(array("Profit","MonthName"))
		->find();
		
		return $items -> toJson();
	}
	//big group
	//http://api.soa.co.uk/Report?CompanyID=1&APIKey=dd6852db-3697-4b74-95f2-7e49f40018bf&UserID=3&type=offer&group=month
	function Report(){
		global $handler;
		$items = ItemQuery::create()		
		->useVendingmachinequery()
			->filterByCompanyid($handler -> CompanyID)//only show for selected company
		->endUse()
		//joins
		->joinWith("Item.Vendingmachine")
		->joinWith("Vendingmachine.Location")		
		->joinWith("Item.User")
		->joinWith("Item.Product")
		->joinWith("User.Gender")
		//value or qty or profit
		->withColumn("sum(Item.Saleprice - Item.Purchaseprice)","Profit")
		->withColumn("sum(Item.Saleprice)","Revenue")
		->withColumn("count(Item.Itemid)","Quanitity");
		//offer or all
		if($handler -> getValue("type") == "offer")
			$items =$items->where("Item.Offerid is Not NULL");
		//group names
		$items =$items->withColumn("Year(Item.Addeddate)","Year")
		->withColumn("Month(Item.Addeddate)","Month")
		->withColumn("Location.Addressline","Location")		
		->withColumn("User.Email","UserEmail")			
		->withColumn("Product.Name","ProductName")
		->withColumn("MonthName(Item.Addeddate)","MonthName")
		->withColumn("Gender.Name","Gender");		
		//with date
		if($handler -> getValue("date") == "true")
			$items =$items->groupBy("Year")->groupBy("Month");		
		//options
		if($handler -> getValue("group") == "location")
			$items =$items->groupBy("Vendingmachine.Locationid");
		else if($handler -> getValue("group") == "user")
			$items =$items->groupBy("Item.Userid");
		else if($handler -> getValue("group") == "product")
			$items =$items->groupBy("Item.Productid");
		else if($handler -> getValue("group") == "month")
			$items =$items->groupBy("Year")->groupBy("Month");		
		
		$items =$items-> select(array("Profit","MonthName","Revenue","Quanitity","Year",
			"Location","UserEmail","ProductName","Gender"));
		
		return $items-> find()->toJson();
	}

	
}


?>