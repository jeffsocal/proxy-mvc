<?php

/*
 * Copyright (2018) SoCal Bioinformatics Inc. All rights reserved.
 * This script is the confidential and proprietary product
 * of SoCal Bioinformatics Inc. Any Unauthorized reproduction or
 * transfer of the contents herein is strictly prohibited.
 *
 * AUTH: Jeff Jones | SoCal Bioinformatics Inc
 * DATE: 2018.03.28
 * OWNER: SoCal Bioinformatics Inc
 * PROJECT: pelican.socalmetrix.com
 * DESC:
 */
use ProxyTime\Timer;

/*
 * TEST SETUP
 */
$include_path = __DIR__ . "/../../../";
set_include_path($include_path);

require_once $include_path . './vendor/autoload.php';
require_once $include_path . './src/autoload/Functions.php';

$tmr = new Timer();
/*
 * Variables
 */
$ini = parse_ini_file($include_path . 'ini/config.ini');

$server_name = $ini['server_name'];
$email_from_name = $ini['site_name'];
$email_from = $ini['site_email'];
$email_to_name = 'Jeff Jones';
$email_to = 'jjones@socalbioinformatics.com';

$email_title = "Email Test " . randomString(5, 'nA');
$email_body = "TEST MESSAGE FROM " . $server_name;

print_message('server_name', $server_name);
print_message('email_from_name', $email_from_name);
print_message('email_from', $email_from);
print_message('email_to_name', $email_to_name);
print_message('email_to', $email_to);
print_message('email_title', $email_title);
print_message('email_body', $email_body);

print_message('Create the Transport via Sendmail');
$transport = new \Swift_SendmailTransport('/usr/sbin/sendmail -bs');

print_message('Create the Mailer using your created Transport');
$mailer = new \Swift_Mailer($transport);

print_message('Create a message');
$message = (new \Swift_Message($email_title))->setFrom([
    $email_from => $email_from_name
])
    ->setTo([
    $email_to
])
    ->setBody($email_body);

$message->setContentType("text/html");

print_message('Send the message');
$result = $mailer->send($message);

print_r($result);
echo PHP_EOL;
echo $tmr->timeinstr(TRUE) . PHP_EOL;
?>