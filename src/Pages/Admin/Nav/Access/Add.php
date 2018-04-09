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
 * DESC: The construct for the User Create Invite Page
 */

/*
 * INSTANTIATE OBJECTS
 */
use ProxyHTML\Bootstrap;
use ProxyHTML\Construct;
use ProxyHTML\UserInterface\Forms;
use ProxyHTML\UserInterface\Navbar;
use ProxyMVC\User\UserInvite;

$cns = new Construct();
$htm = new Bootstrap($cns->getMain(), $cns->getBody());
$nav = new Navbar();

/*
 * CREATE VIEW
 */
$htm->addToSection("navbar", $nav->getNavbar());
$htm->addToSection("footer", $cns->getFooter());

$inv = new UserInvite('localhost','authorizations');
$frm = new Forms(false);

/*
 * INPUTS
 */
$arg_e = $frm->getVariable("new_email");
$arg_s = $frm->getVariable("submit");

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
$html .= $htm->header('Login ID: invite someone using their email address');
$html .= $frm->textline("new_email", '', 50);
$html .= $frm->submit("submit", "Go");

$htm_this = $frm->form($html);

$htm->addToContent($htm->panel("New User", $htm_this));

/*
 * PUSH VIEW
 */
echo $htm->finalHTML();

?>
