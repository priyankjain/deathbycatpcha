<?php
$string="https://www.paypal.com/cgi-bin/gs_web/dqwOimz7Zpw7mRFzNBHkKbbydiK.J0kKhKLjCcNoYi8CbacGOq5l-Iq37YEVcMYGsUck1Q/secret.jpeg?version=";
function getimg($url) {         
    $headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';              
    $headers[] = 'Connection: Keep-Alive';         
    $headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';         
    $user_agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)';         
    $process = curl_init($url);         
    curl_setopt($process, CURLOPT_HTTPHEADER, $headers);         
    curl_setopt($process, CURLOPT_HEADER, 0);         
    curl_setopt($process, CURLOPT_USERAGENT, $user_agent);         
    curl_setopt($process, CURLOPT_TIMEOUT, 30);         
    curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);         
    curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);         
    $return = curl_exec($process);         
    curl_close($process);         
    return $return;     
} 
	echo "ys";	
	$image = getimg($string); 
	imagejpeg(imagecreatefromstring($image),"test1.jpeg");

?>
