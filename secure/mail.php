<?php
// $to      = $email; // Send email to our user
$subject='VERIFY YOUR ONLINE ENTRANCE ACCOUNT';
$name='bhuban Yadav';

function sendMail($to,$name,$otp,$subject,$msg)
{
$message = '
'.$msg.'TO verify your email address, please use the following One Time Password(OTP):

						 *************************
					   |	   OE-	'.$otp.'      |  
						 *************************
 
Do not share this OTP with anyone. We take your account security very seriously. We will never ask you 
to disclose or verify your ONLINE ENTRANCE password, OTP, creditcard, or banking account number. IF you
receive a suspicious email with a link to update account information, do not click on the link.

						Thank you for connecting with us!
'; // Our message above including the link
                     
$headers = 'From:info@bhubanesh.ml' . "\r\n"; // Set from headers
$value=mail($to, $subject, $message, $headers); // Send our email
if ($value==1) {
	return(1);
}
else{
	return(0);
}
}
?>