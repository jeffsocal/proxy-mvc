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
 * DESC: The construct for the Login Page
 */

/*
 * INSTANTIATE OBJECTS
 */
use ProxyHTML\Bootstrap;
use ProxyHTML\Construct;
use ProxyHTML\Authentication\Authenticate;
use ProxyHTML\UserInterface\Forms;
use ProxyHTML\UserInterface\Navbar;

$cns = new Construct();
$htm = new Bootstrap($cns->getMain(), $cns->getBody());
$nav = new Navbar();

/*
 * CREATE VIEW
 */
$htm->addToSection("navbar", $nav->getNavbar());
$htm->addToSection("footer", $cns->getFooter());

$ath = new Authenticate('localhost','authorizations');
$frm = new Forms(false);

/*
 * INPUTS
 */
$arg_l = $frm->getVariable("login");
$arg_p = $frm->getVariable("password");

/*
 * MAIN
 */
if (! is_null($arg_l) & ! is_null($arg_l)) {
    if (is_false(filter_var($arg_l, FILTER_VALIDATE_EMAIL))) {

        $htm->addToContent($htm->alert("", "Invalid email", "danger"));
    } elseif (is_true($ath->isUserValid($arg_l, $arg_p))) {

        if (is_true($ath->isAuthenticated())) {
            $htm->redirect(".?page=Default");
            exit();
        } else {
            $htm->addToContent($htm->alert('', $ath->getErrorMessage(), "danger"));
        }
    } else {
        $htm->addToContent($htm->alert('', $ath->getErrorMessage(), "danger"));
    }
}

$ui = "";
$ui .= $htm->text("<br>Email", 1);
$ui .= $frm->textline("login", $arg_l, 40);
$ui .= $htm->text("<br>Password", 1);
$ui .= $frm->passwordline("password", '', 40);
$ui .= $frm->submit("submit", "Go");

$htm_this = $frm->form($ui);

$htm->addToContent($htm->panel("Login", $htm_this));

/*
 * PUSH VIEW
 */
echo $htm->finalHTML();

?>
