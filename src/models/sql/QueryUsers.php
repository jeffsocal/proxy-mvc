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

class QueryUsers extends Transaction
{

    //
    public function __construct($server)
    {
        parent::__construct($server);
    }

    //
    public function listUsers()
    {
        $sql_query = 'select login
						from authorizations.credentials
						order by login desc';
        
        $this_table = $this->sqlGet($sql_query);
        
        return $this_table['login'];
    }

    //
    public function resetUser($user)
    {
        $sql_query = 'delete
						from authorizations.credentials
						where login = "' . $user . '"';
        
        $this_update = $this->sqlDel($sql_query);
        
        /*
         * boolean T/F
         */
        if (is_false($this_update))
            return $this_update;
        
        $sql_query = 'delete
						from authorizations.invites
						where email = "' . $user . '"';
        
        $this_update = $this->sqlDel($sql_query);
        return $this_update;
    }
}

?>