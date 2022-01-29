 function validated(){
 	// alert('bad work');
 	// return false;
	var err="Please fill all specified fields.";
	var check=0;
	var a;
	var e=document.getElementById("jsError");
	// var forpwd=document.getElementById('message');
	var details="";
	var valueDate = document.getElementById('dob_bs').value;
		var name=
		{
			firstName:document.getElementById("firstName").value,
		 	middleName:document.getElementById('middleName').value,
		 	surName:document.getElementById('surName').value,
		 	fullName:function()
		 		{
		 			return name.firstName+" "+name.middleName+" "+name.surName;
		 		}
		 };
		// alert(name.fullName());
		// alert(name.firstName);
		// return false;
		 var pAddress=
		{
			pCountry:document.getElementById("pCountry").value,
		 	pZone:document.getElementById('pZone').value,
		 	pDistrict:document.getElementById('pDistrict').value,
		 	pCity:document.getElementById('pCity').value,
		 	pTole:document.getElementById('pTole').value,
		 	address:function()
		 		{
		 			return pAddress.pCountry+" "+pAddress.pZone+" "+pAddress.pDistrict+" "+pAddress.pCity+" "+pAddress.pTole;
		 		}
		 };
		 // alert(pAddress.address());
	var tAddress=
		{
			tCountry:document.getElementById("tCountry").value,
		 	tZone:document.getElementById('tZone').value,
		 	tDistrict:document.getElementById('tDistrict').value,
		 	tCity:document.getElementById('tCity').value,
		 	tTole:document.getElementById('tTole').value,
		 	address:function()
		 		{
		 			return tAddress.tCountry+" "+tAddress.tZone+" "+tAddress.tDistrict+" "+tAddress.tCity+" "+tAddress.tTole;
		 		}
		 };
		 // alert(tAddress.address());
	var dob=
		{
			ad:document.getElementById("dob_ad").value,
		 	bs:document.getElementById("dob_bs").value,
		 	fullDob:function()
		 		{
		 			return dob.ad+" "+dob.bs;
		 		}
		 };	 
		  // alert(dob.fullDob());
	var account=
		{
			contact1:document.getElementById("contact_1").value,
		 	contact2:document.getElementById("contact_2").value,
		 	username:document.getElementById("username").value,
		 	// conformUsername:document.getElementById('conformUsername').value,
			email:document.getElementById("email").value,
		 	// conformEmail:document.getElementById("conformEmail").value,
		 	fullAccount:function()
		 		{
		 			return account.contact1+" "+account.contact2+" "+account.username+" "+account.email;
		 		}
		 };
		 // alert(account.fullAccount());
		 // return false;
	var pwd=
		{
			pwd:document.getElementById("password_1").value,
		 	conformPwd:document.getElementById("password_2").value,
		 	fullPassword:function()
		 		{
		 			return pwd.pwd+" "+pwd.conformPwd;
		 		}
		 };	 
		  // alert(pwd.fullPassword());		

	if (name.firstName=="") 
		{
			check=check+1;
			a=document.getElementById("firstName");
		}
	else if (name.surName=="") 
		{
			check=check+1;
			a=document.getElementById("surName");
		}
	 else if (pAddress.pCountry=="") 
		{
			check=check+1;
			a=document.getElementById("pCountry");
		}
	 else if (pAddress.pZone=="") 
		{
			check=check+1;
			a=document.getElementById("pZone");
		}
	else if (pAddress.pDistrict=="") 
		{
			check=check+1;
			a=document.getElementById("pDistrict");
		}
	else if (pAddress.pCity=="") 
		{
			check=check+1;
			a=document.getElementById("pCity");
		}
	else if (pAddress.pTole=="") 
		{
			check=check+1;
			a=document.getElementById("pTole");
		}
	else if (tAddress.tCountry=="") 
		{
			check=check+1;
			a=document.getElementById("tCountry");
		}
	else if (tAddress.tZone=="") 
		{
			check=check+1;
			a=document.getElementById("tZone");
		}
	else if (tAddress.tDistrict=="") 
		{
			check=check+1;
			a=document.getElementById("tDistrict");
		}
	else if (tAddress.tCity=="") 
		{
			check=check+1;
			a=document.getElementById("tCity");
		}
	else if (tAddress.tTole=="") 
		{
			check=check+1;
			a=document.getElementById("tTole");
		}
	else if ( valueDate== null || valueDate== '')
		{
		check=check+1;
    	alert('Please enter your date of birth');
    	return false;
		}
	else if (account.contact1=="") 
		{
			check=check+1;
			a=document.getElementById("contact_1");
		}
	else if (account.username=="") 
		{
			check=check+1;
			a=document.getElementById("username");
		}
	else if (account.email=="") 
		{
			check=check+1;
			a=document.getElementById("email");
		}
	 else if (pwd.pwd=="") 
		{
			check=check+1;
			a=document.getElementById("password_1");
		}
	else if (pwd.conformPwd=="") 
		{
			check=check+1;
			a=document.getElementById("password_2");
		}
		// document.getElementById("terms").checked
	else if (document.getElementById("termsCon").checked!=true) 
		{
			check=check+1;
			alert("please read our terms and conditions and agree it.");
			return false;
		}
	else if (document.getElementById("regRobot").checked==false) 
	{
			check=check+1;
			alert("please check I AM NOT A ROBOT?");
			return false;
	}
	else
		{
		if (pwd.pwd==pwd.conformPwd) {
		if (pwd.pwd.length>=8 & pwd.pwd.length<=20) {
			return true;
		}
		else{
			alert('Error: check password details');
			return false;
		}
	}
	else{
		alert('Error: check password details');
			return false;
	}
		}
	
	// if (forpwd!='') {
	// 	alert('bad');
	// 	alert(forpwd);
	// 	return false;
	// }
	// else{
	// 	alert('good');
	// }
	if((check)!=0){
		// a.style.backgroundColor="red";
		a.style.border="solid";
		a.style.borderColor="red";
		a.style.color="#a94442";
		a.style.backgroundColor="#f2dede";
		e.style.display="block";
		e.style.color="a94442";
		e.style.border="1px solid #a94442";
		e.style.borderRadius="7px";
		e.offsetHeight="20px";
		e.offsetWidth="100px";
		e.style.borderColor='#a94442';
		e.style.backgroundColor='#f2dede';
		e.innerHTML=("!!!Check the highlited section below!!!");
		alert("Please Enter all field properly");
		return false;
	}

};

var checkPwd = function() {
	var pwd1=document.getElementById('password_1').value;
	var pwd2=document.getElementById('password_2').value;
	var msg= document.getElementById('message');
	var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;

	var len=pwd1.length;
	// alert(len);

	if (len<8 | len>20){
		msg.style.color = 'red';
		msg.innerHTML='Password must be of minimum 8 and maximum 20 characters';
		var r=0;
	}
	else{
		msg.innerHTML='too short or to long';
	

// if(pwd1.value.match(decimal)) { 
  	if ( pwd1===pwd2 ) {
   		msg.style.color = 'green';
    	msg.innerHTML = '';
  		}
  	else {
  	 	msg.style.color = 'red';
    	msg.innerHTML = 'Both password did not match';
    	r=0;
  		}
	// }
// else{ 
	// msg.innerHTML='Please check the password conditions';
	// }
	}
}
	
function validatefeedback() {
	var a;
	var check=0;
	var fullName=document.getElementById('name').value;
	var email=document.getElementById('email').value;
	var contact=document.getElementById('contact').value;
	var feedback=document.getElementById('feedback').value;
if (fullName=="") {
	check=check+1;
	a=document.getElementById("fullName");
}
else if (email=="") {
	check=check+1;
	a=document.getElementById("email");
}
else if (contact=="") {
	check=check+1;
	a=document.getElementById("contact");
}
else if (feedback=="") {
	check=check+1;
	a=document.getElementById("feedback");
}
else{
	return true;
}
	if((check)!=0){
		// a.style.backgroundColor="red";
		a.style.border="solid";
		a.style.borderColor="red";
		a.style.color="#a94442";
		a.style.backgroundColor="#f2dede";
		// e.style.display="block";
		// e.style.color="a94442";
		// e.style.border="1px solid #a94442";
		// e.style.borderRadius="7px";
		// e.offsetHeight="20px";
		// e.offsetWidth="100px";
		// e.style.borderColor='#a94442';
		// e.style.backgroundColor='#f2dede';
		// e.innerHTML=("!!!Check the highlited section below!!!");
		alert("Please Enter all field properly");
		return false;
	}
}