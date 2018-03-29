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

use ProxyMySQL\Transaction;

class AuthenticateShiny extends Transaction
{

    //
    public function __construct($server)
    {
        parent::__construct($server);
    }

    private function getLoginPK($login)
    {
        $query = 'SELECT pk FROM authorizations.credentials WHERE login = "' . $login . '"';
        $dat = $this->sqlGet($query);
        
        if (is_false($dat))
            return false;
        
        return $dat['pk'][0];
    }

    public function setShinyAuth($login)
    {
        if (is_false($pk = $this->getLoginPK($login)))
            return false;
        
        $ip = $this->getUserIPAddress() . randomString(5, 'A');
        
        $this->setSchema('auth_shiny');
        
        $query = 'INSERT INTO auth_shiny.logins (pk_credentials, login_ip) 
                    VALUES ("' . $pk . '","' . $ip . '") 
                    ON DUPLICATE KEY UPDATE login_ip = "' . $ip . '";';
        
        return $this->sqlPut($query);
    }
}
?>