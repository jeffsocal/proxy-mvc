<?php
/*
 * Copyright (YYYY) ***YourCompany***. All rights reserved.
 * This script is the confidential and proprietary product
 * of ***YourCompany***. Any Unauthorized reproduction or
 * transfer of the contents herein is strictly prohibited.
 *
 * AUTH: YourSelf | YourCompany
 * DATE: YYYY.MM.DD
 * OWNER: Whomever
 * PROJECT: YourSite
 * DESC: The construct for the Logout Page
 */

/*
 * INSTANTIATE OBJECTS
 */
use ProxyHTML\Display;
use ProxyHTML\Authentication\Authenticate;

$htm = new Display();
$ath = new Authenticate();

/*
 * MAIN
 */
$ath->end();

/*
 * PUSH VIEW
 */
$htm->redirect(".");

?>