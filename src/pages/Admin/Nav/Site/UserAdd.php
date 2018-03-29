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
 * DESC: The construct for the User Create Invite Page
 */

/*
 * INSTANTIATE OBJECTS
 */
use ProxyHTML\Bootstrap;
use ProxyHTML\Construct;
use ProxyHTML\IO\Input;
use ProxyHTML\UserInterface\Forms;
use ProxyHTML\UserInterface\Navbar;
use ProxyMVC\user\UserInvite;

$cns = new Construct();
$htm = new Bootstrap($cns->getMain(), $cns->getBody());
$nav = new Navbar();

/*
 * CREATE VIEW
 */
$htm->addToSection("subtitle", $htm->pageheader("Add New User"));
$htm->addToSection("navbar", $nav->getNavbar());
$htm->addToSection("footer", $cns->getFooter());

$inv = new UserInvite();
$frm = new Forms();
$arg = new Input();

/*
 * INPUTS
 */
$arg_e = $arg->getVariable("new_email");
$arg_s = $arg->getVariable("submit");

/*
 * MAIN
 */
if ($arg_s == 'Go') {
    $insert_new = true;

    if (is_false(filter_var($arg_e, FILTER_VALIDATE_EMAIL))) {
        $htm->addToContent($htm->alert("Fail", "Not a valid email", "danger"));
        $insert_new = false;
    }

    if (is_true($insert_new)) {

        if (is_false($inv->setRecipent($arg_e))) {
            $htm->addToContent($htm->alert("Fail", "User could not be invited.", "danger"));
        } else {
            $inv->sendInvite ();
            $htm->addToContent($htm->alert("Success", "User was sent an invitation.", "success"));
        }
    }
}

$html = "";
$html .= $htm->header('Email: use email address');
$html .= $frm->textline("new_email", '', 50);
$html .= $frm->submit("submit", "Go");

$htm_this = $frm->form($html);

$htm->addToContent($htm->panel("New User", $htm_this));

/*
 * PUSH VIEW
 */
echo $htm->finalHTML();

?>
