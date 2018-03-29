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

class ArticlesList extends Directory
{

    private $path;

    private $htm;

    public function __construct($topic)
    {
        $this->path = './content/' . $topic . '/';
        parent::__construct($this->path);
        $this->htm = new Bootstrap('', '', '');
    }

    public function get($items = 100)
    {
        $articles = $this->getContents($items);
        foreach ($articles as $n => $name) {
            
            if (! preg_match("/\d{6}/", $name))
                continue;
            
            $md = new Read($this->path . $name . '/main.md');
            
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
            
            $layout[] = array(
                'title' => $title,
                'date' => $date,
                'description' => $descr,
                'link' => '?page=Article&a=' . $name,
                'image' => $this->path . $name . '/clip.png'
            );
        }
        return $layout;
    }
}
?>
