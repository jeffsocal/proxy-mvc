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
 * DESC: The construct for the About Page
 */

/*
 * INSTANTIATE OBJECTS
 */
use ProxyMVC\graphs\Scatter;
use ProxyHTML\Bootstrap;
use ProxyHTML\Construct;
use ProxyHTML\UserInterface\Navbar;

$cns = new Construct();
$htm = new Bootstrap($cns->getMain(), $cns->getBody());
$nav = new Navbar();

/*
 * CREATE VIEW
 */
$htm->addToSection("subtitle", $htm->pageheader("Scatter Plot"));
$htm->addToSection("navbar", $nav->getNavbar());
$htm->addToSection("footer", $cns->getFooter());

$ply = new Scatter();
$htm->addToJS('<script src="' . $ply->getImports() . '"></script>');
$htm->addToContent($htm->card('Scatter Plot', $ply->getPlot()));

/*
 * PUSH VIEW
 */
echo $htm->finalHTML();

?>