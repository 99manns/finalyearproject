var url = "http://api.soa.co.uk/";
var company;
var key ;
var user;

$.ajaxSetup({ cache: false });
defvalues();
$(function(){
	$(".date").datepicker();
	$(".date").datepicker("option","dateFormat","dd/mm/yy");
});

function defvalues(){	
	if($.cookie("company") == null)
		$.cookie("company", "1");
	if($.cookie("key") == null)
		$.cookie("key", "dd6852db-3697-4b74-95f2-7e49f40018bf");
	if($.cookie("user") == null)
		$.cookie("user", "2");
	if(company == null)
		company = $.cookie("company");
	if(key == null)
		key =$.cookie("key");
	if(user == null)
		user =$.cookie("user");		
			
}

	function formatdate(date){
		if(date != null){
			var d = new Date(date);
			var h = addZero(d.getHours());
			var m= addZero(d.getMinutes());
			return d.getDate()+'/'+d.getMonth()+'/'+d.getFullYear()+'  '+h+':'+m;
		}else
			return date;
	}
	//http://www.w3schools.com/jsref/jsref_gethours.asp
	function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
	
	function sqldate(date){
		if(date != null && date !="null"){
			var temp = date.split("/");
			return new Date(temp[1]+"/"+temp[0]+"/"+temp[2]).toISOString();
		}else
			return '';
	}
	
	function loactions(){
	var request =$.ajax({
			url:url+"loactions?CompanyID="+company+"&APIKey="+key+"&UserID="+user,
			dataType:"json",
			method:"GET"
		});		
		request.success(function(data){			
			var datas= data.Locations;			
			var text="";
			for(var i=0;i <datas.length; i++){
				text +="<option value='"+datas[i].Locationid+"'>"+datas[i].Towncity
				+" "+datas[i].Addressline+"</option>";
			}
			$(".list").html("<select class='loac'>"+text+"</select>");			
		});
		request.fail(function(data){
			alert("fail"+data.responseText);
		});
		return request;
	}
	function customers(){
		var request =$.ajax({
			url:url+"customers?CompanyID="+company+"&APIKey="+key+"&UserID="+user,
			dataType:"json",
			method:"GET"
		});		
		request.success(function(data){			
			var datas= data.Users;			
			var text="";
			for(var i=0;i <datas.length; i++){
				text +="<option value='"+datas[i].Userid+"'>"+datas[i].Firstname
				+" "+datas[i].Lastname+"</option>";
			}
			$(".clist").html("<select>"+text+"</select>");
			
		});
		request.fail(function(data){
			alert("fail"+data.responseText);
		});
		return request;
	}
	function products(){
	var datas = null;
		var request =$.ajax({
			url:url+"productByCompany?CompanyID="+company+"&APIKey="+key+"&UserID="+user+"&ID=1",
			dataType:"json",
			method:"GET"
		});
		request.success(function(data){
			datas= data.Products;			
			var text;
			for(var i=0;i <datas.length; i++){
				text +="<option value='"+datas[i].Productid+"'>"+
				datas[i].Name+"</option>";
			}
			$(".plist").html("<select>"+text+"</select>")
		
		});
		request.fail(function(data){
			alert("fail"+data.responseText);
		});		
		return request;
	}
	//http://stackoverflow.com/questions/9501690/javascript-documentation-on-getparameterbyname
	function getParameterByName(name)
	{
	  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
	  var regexString = "[\\?&]" + name + "=([^&#]*)";
	  var regex = new RegExp(regexString);
	  var found = regex.exec(window.location.search);
	  if(found == null)
		return "";
	  else
		return decodeURIComponent(found[1].replace(/\+/g, " "));
	}
function offers(){
	var pid = $("#pofferid").val();
	var request =$.ajax({
			url:url+"offers?CompanyID="+company+"&APIKey="+key+"&UserID="+user
			+"&productid="+pid,
			dataType:"json",
			method:"GET"
		});		
		request.success(function(data){			
			var datas= data.Offers;		
			var text="";
			for(var i=0;i <datas.length; i++){
				text +="<option value='"+datas[i].Offerid+"'>"+datas[i].Name
				+" "+datas[i].Discount+"</option>";
			}
			$(".plist").html("<select><option value='0'>Select</option>"+text+"</select>");
			
		});
		request.fail(function(data){
			alert("fail"+data.responseText);
		});
	 request =$.ajax({
			url:url+"offers?CompanyID="+company+"&APIKey="+key+"&UserID="+user
			+"&productid="+pid+"&customerid"+user,
			dataType:"json",
			method:"GET"
		});		
		request.success(function(data){			
			var datas= data.Offers;		
			var text="";
			for(var i=0;i <datas.length; i++){
				text +="<option value='"+datas[i].Offerid+"'>"+datas[i].Name
				+" "+datas[i].Discount+"</option>";
			}
			$(".olist").html("<select><option vakue='0'>Select</option>"+text+"</select>");
			
		});
		request.fail(function(data){
			alert("fail"+data.responseText);
		});
	}
	
	function coffer(){
		var request =$.ajax({
			url:url+"offers?CompanyID="+company+"&APIKey="+key+"&UserID="+user
			+"&customerid="+user,
			dataType:"json",
			method:"GET"
		});		
		request.success(function(data){			
			var datas= data.Offers;		
			var text="";
			for(var i=0;i <datas.length; i++){
				text +="<option value='"+datas[i].Offerid+"'>"+datas[i].Name
				+" "+datas[i].Discount+"</option>";
			}
			$(".clist").html("<select><option vakue='0'>Select</option>"+text+"</select>");
			
		});
		request.fail(function(data){
			alert("fail"+data.responseText);
		});
		return request;
	}
	
	function lineChartData(label, datas){
		var temp = {
			labels: label,
			datasets: [
			{
				label: "My test dataset",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: datas
			}
			]
		};				
		return temp;
	}
	
	function barChartData(label, datas, datas1){
		
		var temp = {
			labels: label,
			datasets: [
			{
				label: "My test dataset",
				fillColor: "rgba(220,100,100,0.5)",
				strokeColor: "rgba(220,100,100,0.8)",				
				highlightFill: "rgba(220,100,100,0.75)",
				highlightStroke: "rgba(220,100,100,1)",
				data: datas
			},
			{
				label: "My 2 dataset",
				fillColor: "rgba(151,187,205,0.5)",
				strokeColor: "rgba(151,187,205,0.8)",				
				highlightFill: "rgba(151,187,205,0.75)",
				highlightStroke: "rgba(151,187,205,1)",
				data: datas1
			}
			]
		};				
		return temp;
	}
	
	function barChartData1(label, datas){
		var temp = {
			labels: label,
			datasets: [
			{
				label: "My test dataset",
				fillColor: "rgba(102,100,220,0.5)",
				strokeColor: "rgba(102,100,220,0.8)",				
				highlightFill: "rgba(102,100,220,0.75)",
				highlightStroke: "rgba(102,100,220,1)",
				data: datas
			}			
			]
		};				
		return temp;
	}
	function barChartData2(label, datas, datas1,datas2){
		var temp = {
			labels: label,
			datasets: [
			{
				label: "My test dataset",
				fillColor: "rgba(220,100,100,0.5)",
				strokeColor: "rgba(220,100,100,0.8)",				
				highlightFill: "rgba(220,100,100,0.75)",
				highlightStroke: "rgba(220,100,100,1)",
				data: datas
			},
			{
				label: "My 2 dataset",
				fillColor: "rgba(151,187,205,0.5)",
				strokeColor: "rgba(151,187,205,0.8)",				
				highlightFill: "rgba(151,187,205,0.75)",
				highlightStroke: "rgba(151,187,205,1)",
				data: datas1
			},
			{
				label: "My 3 dataset",
				fillColor: "rgba(151,0,205,0.5)",
				strokeColor: "rgba(151,0,205,0.8)",				
				highlightFill: "rgba(151,0,205,0.75)",
				highlightStroke: "rgba(151,0,205,1)",
				data: datas2
			}
			]
		};				
		return temp;
	}
	//smallest label 1st & it's data
	function comibeChartArray(label,label1,data){
		var datas=[];
		if(label.length >0){
			for(var i=0;i<label.length; i++){
				var pos =$.inArray(label[i],label1);					
				if(pos >-1){
					datas[pos] = data[i];
				}else{
					label1.push(label[i]);
					datas[label1.length-1] = data[i];
				}
			}
			for(var i=0;i<datas.length; i++){
				if(typeof datas[i]== 'undefined' )
					datas[i]=0;
			}
		}			
		return datas;
	}