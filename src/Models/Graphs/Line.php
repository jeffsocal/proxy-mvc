<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyMVC\Graphs;

use ProxyChart\Plotly;
use ProxyIO\File\Delim\ReadDelim;

class Line
{

    private $imports;

    private $plot;

    function __construct()
    {
        $csv = new ReadDelim('../dat/test/camera.csv');
        $ply = new Plotly();
        
        $this->imports = $ply->getImports();
        
        $table_array = $csv->getTableArray();
        
        $ply->data($table_array, 'Release date', 'Price');
        $ply->line();
        
        $this->plot = $ply->plot();
    }

    function getImports()
    {
        return $this->imports;
    }

    function getPlot()
    {
        return $this->plot;
    }
}

?>