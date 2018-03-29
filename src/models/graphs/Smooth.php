<?php

/*
 * Written by Jeff Jones (jeff@socalbioinformatics.com)
 * Copyright (2016) SoCal Bioinformatics Inc.
 *
 * See LICENSE.txt for the license.
 */
namespace ProxyMVC\graphs;

use ProxyChart\Plotly;
use ProxyIO\File\Delim\ReadDelim;

class Smooth
{

    private $imports;

    private $plot;

    function __construct()
    {
        $csv = new ReadDelim('../dat/cereal.csv');
        $ply = new Plotly();
        
        $this->imports = $ply->getImports();
        
        $table_array = $csv->getTableArray();
        
        $ply->data($table_array, 'rating', 'potass');
//         $ply->groupby('mfr');
        $ply->point();
        $ply->smooth();
        
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