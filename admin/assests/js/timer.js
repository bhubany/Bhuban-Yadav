	var countDownDate=new Date().getTime();
		var x=setInterval(function(){
			var now=new Date().getTime();
			var dts=countDownDate+(60*60*1000);
			var distance=dts-now;
			var days=Math.floor(distance/(1000*60*60*24));
			var hours=Math.floor((distance%(1000*60*60*24))/(1000*60*60));
			var minutes=Math.floor((distance%(1000*60*60))/(1000*60));
			var seconds=Math.floor((distance%(1000*60))/(1000));
			document.getElementById('timer').innerHTML=hours+"hr"+minutes+"min"+seconds+"sec";
			if(distance<0){
				clearInterval(x);
				document.getElementById("timer").innerHTML="EXPIRED";
			}},1000);
