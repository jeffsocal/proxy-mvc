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
 * DESC: The construct for the User Invite Acceptance Page
 */

/*
 * INSTANTIATE OBJECTS
 */
use ProxyHTML\Bootstrap;
use ProxyHTML\Construct;
use ProxyHTML\Authentication\Authenticate;
use ProxyHTML\Authentication\Invites;
use ProxyHTML\UserInterface\Forms;
use ProxyHTML\UserInterface\Navbar;

$cns = new Construct();
$htm = new Bootstrap($cns->getMain(), $cns->getBody());
$nav = new Navbar();

/*
 * CREATE VIEW
 */
$htm->addToSection("subtitle", $htm->pageheader("Accept User"));
$htm->addToSection("navbar", $nav->getNavbar());
$htm->addToSection("footer", $cns->getFooter());

$ath = new Authenticate('localhost', 'authorizations');
$inv = new Invites('localhost', 'authorizations');
$frm = new Forms(false);

/*
 * INPUTS
 */
$arg_id = $frm->getVariable("id");

$arg_s = $frm->getVariable("submit");
$arg_l = $frm->getVariable("new_login");
$arg_p = $frm->getVariable("new_password");
$arg_pm = $frm->getVariable("new_password_match");

$new_user_success = false;

/*
 * MAIN
 */
if (is_false($arg_l = $inv->isInviteValid($arg_id))) {
    //
    $htm->addToContent($htm->alert("Fail", "Invite invalid", "danger"));
    echo $htm->finalHTML();
    exit();
} else {}

if ($arg_s == 'Go') {
    $insert_new = true;
    
    if ($arg_p == '' or $arg_p != $arg_pm) {
        $htm->addToContent($htm->alert("Fail", "Password Missmatch", "danger"));
        $insert_new = false;
    }
    
    if (is_false(filter_var($arg_l, FILTER_VALIDATE_EMAIL))) {
        $htm->addToContent($htm->alert("Fail", "Not a valid email", "danger"));
        $insert_new = false;
    }
    
    if (is_true($insert_new)) {
        if (is_true($ath->createNewUser($arg_l, $arg_p))) {
            
            $htm->addToContent($htm->alert("Success", "User added.", "success"));
            $new_user_success = true;
            
            if (is_true($ath->isUserValid($arg_l, $arg_p))) {
                
                $htm->addToContent($htm->pageheader("Access Granted"));
                $htm->addToContent($htm->button('Main', "?page=Default") . ' page');
                
                echo $htm->finalHTML();
                exit();
            }
        } else {
            
            $htm->addToContent($htm->alert("Fail", "User could not be added.", "danger"));
        }
    }
}
$html = "";
$html .= $htm->header('Login: will be the email address');
$html .= $htm->header('<b>' . $arg_l . '</b>', 5);
$html .= $frm->hidden("new_login", $arg_l);
$html .= $frm->hidden("id", $arg_id);
$html .= $htm->header('Password: 10-24 characters [0-9, a-z, A-Z, !@#$&]');
$html .= $frm->passwordline("new_password");
$html .= $htm->header('confirm', 6);
$html .= $frm->passwordline("new_password_match");
$html .= $frm->submit("submit", "Go");

if (is_false($new_user_success)) {
    $htm_this = $frm->form($html);
    $htm->addToContent($htm->panel("Information", $htm_this));
}
/*
 * PUSH VIEW
 */
echo $htm->finalHTML();

?>