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
 * DESC: The construct for the Login Page
 */

/*
 * INSTANTIATE OBJECTS
 */
use ProxyHTML\Bootstrap;
use ProxyHTML\Construct;
use ProxyHTML\Authentication\Authenticate;
use ProxyHTML\IO\Input;
use ProxyHTML\UserInterface\Forms;
use ProxyHTML\UserInterface\Navbar;

$cns = new Construct();
$htm = new Bootstrap($cns->getMain(), $cns->getBody());
$nav = new Navbar();

/*
 * CREATE VIEW
 */
$htm->addToSection("subtitle", $htm->pageheader("Login"));
$htm->addToSection("navbar", $nav->getNavbar());
$htm->addToSection("footer", $cns->getFooter());

$ath = new Authenticate();
$frm = new Forms();
$arg = new Input();

/*
 * INPUTS
 */
$arg_l = $arg->getVariable("login");
$arg_p = $arg->getVariable("password");

/*
 * MAIN
 */
if ($arg_l != "" & is_false(filter_var($arg_l, FILTER_VALIDATE_EMAIL))) {
    $htm->addToContent($htm->alert("Fail", "Authentication invalid", "danger"));
} else {
    $ath->isUserValid($arg_l, $arg_p);
}

if ($ath->isAuthenticated()) {
    $htm->redirect(".?page=Default");
    exit();
} elseif ($arg_l != "") {
    $htm->addToContent($htm->alert("Fail", "Authentication invalid", "danger"));
}

$ui = "";
$ui .= $htm->text("<br>Email", 1);
$ui .= $frm->textline("login", 'webmaster@yoursite.com', 40);
$ui .= $htm->text("<br>Password", 1);
$ui .= $frm->passwordline("password", 'abcde12345!', 40);
$ui .= $frm->submit("submit", "Go");

$htm_this = $frm->form($ui);

$htm->addToContent($htm->panel("Credentials", $htm_this));

/*
 * PUSH VIEW
 */
echo $htm->finalHTML();

?>