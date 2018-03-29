<?php
/*
 * Copyright (2017) SoCal Bioinformatics Inc. All rights reserved.
 * This script is the confidential and proprietary product
 * of SoCal Bioinformatics Inc. Any Unauthorized reproduction or
 * transfer of the contents herein is strictly prohibited.
 *
 * AUTH: Jeff Jones | SoCal Bioinformatics Inc.
 * EMAIL: jeff@socalbioinformatics.com
 * DATE: 2018.01.23
 * OWNER: SoCal Bioinformatics Inc.
 * PROJECT: midnightbaseball.com
 * DESC:
 */

/*
 * IMPORT MAIN CLASSES
 */
use ProxyHTML\UserInterface\Viewer;
use ProxyHTML\UserInterface\Action;

require_once get_include_path() . './vendor/autoload.php';
require_once get_include_path() . './src/autoload/Functions.php';
/*
 * Logging event key
 */
$_ENV['PID'] = uniqueId();

/*
 * CONTROLLER
 */
$ui = new Action();
require_once $ui->getPagePath();

/*
 * Run after sending page to not delay action to the user
 */
$vwr = new Viewer();
$vwr->track();
$vwr->whois();

?>