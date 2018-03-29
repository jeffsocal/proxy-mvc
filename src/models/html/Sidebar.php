<?php
/*
 * Copyright (2017) SoCal Bioinformatics Inc. All rights reserved.
 * This script is the confidential and proprietary product
 * of SoCal Bioinformatics Inc. Any Unauthorized reproduction or
 * transfer of the contents herein is strictly prohibited.
 *
 * AUTH: Jeff Jones | SoCal Bioinformatics Inc
 * DATE: 2017.01.10
 * OWNER: SoCal Bioinformatics Inc
 * PROJECT: midnightbaseball.com
 * DESC:
 */

use ProxyHTML\Bootstrap;
use ProxyIO\Directory;
use ProxyIO\File\Read;

class Sidebar extends Bootstrap
{

    public function __construct($title = '', $main = '', $body = '')
    {
        parent::__construct($title, $main, $body);
    }

    public function get($topic = 'news', $items = 5)
    {
        $array = array();
        
        $path = './content/' . $topic . '/';
        
        $fld = new Directory($path);
        $articles = $fld->getContents($items);
        foreach ($articles as $n => $name) {
            $md = new Read($path . $name . '/main.md');
            $mdp = new Parsedown();
            
            preg_match("/^[0-9]+/", $name, $date);
            preg_match_all("/\d\d/", $date[0], $date);
            $date = date('jS M, `y', mktime(0, 0, 0, $date[0][1], $date[0][2], $date[0][0]));
            
            preg_match_all("/\#.+/", $md->getContents(), $shorts);
            
            $title = '';
            $descr = '';
            if (key_exists(0, $shorts[0]))
                $title = preg_replace("/#+\s*/", "", $shorts[0][0]);
            
            if (key_exists(1, $shorts[0]))
                $descr = preg_replace("/#+\s*/", "", $shorts[0][1]);
            
            $array[$n]['link'] = '?page=Articles&s=' . strtotitle($topic) . '&a=' . $name;
            $array[$n]['head'] = $this->header($title,3);
            $array[$n]['text'] = $this->text($date) . ' ' . $descr;
        }
        return $this->listgrouptext($array);
    }
}
?>
