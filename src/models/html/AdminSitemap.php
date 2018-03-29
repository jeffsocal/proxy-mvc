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

use ProxyHTML\Sitemap;

class AdminSitemap extends Sitemap
{

    private $articles;

    public function __construct()
    {
        $this->articles = new ArticlesList('articles');
    }

    public function getSitemap()
    {
        $this->addUrl("", date('Y-m-d'), 'weekly', 1);
        $this->addUrl("?page=About", strftime("%Y-%m-%d", filemtime('./content/About.md')));
        
        foreach ($this->articles->get(100) as $article) {
            $this->addUrl($article['link'], strftime("%Y-%m-%d", filemtime('./content/About.md')), 'monthly');
        }
        
        return $this->getXml();
    }
}

?>