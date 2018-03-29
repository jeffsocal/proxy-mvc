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

use ProxyIO\File\Read;

class MarkdownContent extends Read {
	public function __construct($file_path) {
		parent::__construct ( $file_path );
	}

	public function get() {
		$md = new Parsedown ();

		$html = $md->text ( $this->getContents () );
		$html = preg_replace ( "/\<table\>/", '<table class="table">', $html );
		
		$html = preg_replace ( "/\<code\>/", '<div class="code">', $html );
		$html = preg_replace ( "/\<\/code\>/", '</div>', $html );
		
		$html = preg_replace ( "/\<img\s+src/", '<img class="image img-fluid center-block" 
                                                      src', $html );
		
		return $html;
	}
}
?>
