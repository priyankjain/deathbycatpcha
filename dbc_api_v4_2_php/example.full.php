<?php
/**
 * Death by Captcha PHP API full usage example
 *
 * @package DBCAPI
 * @subpackage PHP
 */

/**
 * DBC API clients
 */
require_once 'deathbycaptcha.php';


$username = $argv[1];
$password = $argv[2];

// Put your DBC username & password here.
// Use DeathByCaptcha_HttpClient() class if you want to use HTTP API.
$client = new DeathByCaptcha_SocketClient($username, $password);
$client->is_verbose = true;

echo "Your balance is {$client->balance} US cents\n";

for ($i = 3, $l = count($argv); $i < $l; $i++) {
    $captcha_filename = $argv[$i];

    // Put your CAPTCHA image file name, file resource, or vector of bytes,
    // and optional solving timeout (in seconds) here; you'll get CAPTCHA
    // details array on success.
    if ($captcha = $client->upload($captcha_filename)) {
        echo "CAPTCHA {$captcha['captcha']} uploaded\n";

        sleep(DeathByCaptcha_Client::DEFAULT_TIMEOUT);

        // Poll for CAPTCHA text:
        if ($text = $client->get_text($captcha['captcha'])) {
            echo "CAPTCHA {$captcha['captcha']} solved: {$text}\n";

            // Report an incorrectly solved CAPTCHA.
            // Make sure the CAPTCHA was in fact incorrectly solved!
            //$client->report($captcha['captcha']);
        }
    }
}
