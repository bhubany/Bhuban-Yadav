 function checkingLogin() {
	var err="Email id or password did not match";
	var check=0;
	var a;
	var loginDetails=
		{
			email:document.getElementById("loginEmail").value,
		 	password:document.getElementById('loginPassword').value,
		 	fullDetails:function()
		 		{
		 			return loginDetails.email+" "+loginDetails.password;
		 		}
		 };
	if (loginDetails.email=="") 
		{
			check=check+1;
			a=document.getElementById("loginEmail");
		}
	else if (loginDetails.password=="") 
		{
			check=check+1;
			a=document.getElementById("loginPassword");
		}
	else
		{
			// return true;
		}
	if((check)!=0){
		a.style.backgroundColor="red";
		return false;
	}
}