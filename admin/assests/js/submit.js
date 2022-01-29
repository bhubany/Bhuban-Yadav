function showResult() {
	var s=document.getElementById('showResult');
	var h=document.getElementById('hideResult');
 	var r=document.getElementById("res");
 	r.style.display="block";
 	r.style.border="2px solid #1222B5";
 	r.style.border.width="5px";
 	s.style.display="none";
 	h.style.display="block";

 }
 function hideResult() {
	var s=document.getElementById('showResult');
	var h=document.getElementById("hideResult");
 	var r=document.getElementById("res");
 	r.style.display="none";
 	s.style.display="block";
 	h.style.display="none";

 }
 function submitted() {
 	var f=document.getElementById("feedback");
 	var s=document.getElementById("feedbackSubmitted");
  	f.style.display="none";
 	s.style.display="block";
  }
 function showUQuestions() {
	var s=document.getElementById('showUQuestions');
	var h=document.getElementById('hideUQuestions');
 	var r=document.getElementById("unregistered");
 	r.style.display="block";
 	r.style.border="2px solid #1222B5";
 	r.style.border.width="5px";
 	s.style.display="none";
 	h.style.display="block";

 }
 function hideUQuestions() {
	var s=document.getElementById('showUQuestions');
	var h=document.getElementById("hideUQuestions");
 	var r=document.getElementById("unregistered");
 	r.style.display="none";
 	s.style.display="block";
 	h.style.display="none";

 }
  function showRQuestions() {
	var s=document.getElementById('showRQuestions');
	var h=document.getElementById('hideRQuestions');
 	var r=document.getElementById("registered");
 	r.style.display="block";
 	r.style.border="2px solid #1222B5";
 	r.style.border.width="5px";
 	s.style.display="none";
 	h.style.display="block";

 }
 function hideRQuestions() {
	var s=document.getElementById('showRQuestions');
	var h=document.getElementById("hideRQuestions");
 	var r=document.getElementById("registered");
 	r.style.display="none";
 	s.style.display="block";
 	h.style.display="none";

 }