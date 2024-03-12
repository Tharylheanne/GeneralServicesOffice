$(document).ready(function(){
//================================================
		var DOMAIN ="http://localhost/System_PHP/system";

  $("#logins").on("submit",function(){
 

$.ajax({

				url: DOMAIN+"/login/includes/process.php",
				method:"POST",

				data:$("#logins").serialize(),

				success: function(data){
					if(data =="NOT_REGISTERED"){
						alert("NOT REGISTER");
			
					}else if(data=="PASSWORD_NOT_MATCHED"){
				alert("ERRIR");
					}else if(data=="OK"){
						alert("basa");
					}
					else {
						
						console.log(data);
						//alert("Logged In Success");
						alert(data);
						
					}
					
				}
			})


//==============================================================================

  });


});