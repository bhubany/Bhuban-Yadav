

// -----------WHILE LOGOUT--------------
function confirmBox(){
 	var confm=confirm("Are you sure you want to logout?");
 	if (confm==true) {
 		return true;
 	}
 	else{
 		return false;
 	}
 };

// ----------------------DELETING SOMETHING---------------
function confirmDel(){
 	var confm=confirm("Are you sure you want to delete this?");
 	if (confm==true) {
 		return true;
 	}
 	else{
 		return false;
 	}
 };
 // function confirmDelete() {
 // 	var confm=confirm("Are you sure you want to delete this?");
 // 	if(confm==true){
 // 		return true;
 // 	}
 // 	else{
 // 		return false;
 // 	}
 // };