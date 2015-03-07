<?php

require_once 'simple_html_dom.php';
require_once 'cssparser.php';

$html = file_get_html('test.html');
$stylesheet_url = 'test.css';
$css =  parse($stylesheet_url);

foreach(array_keys($css) as $cssitem)
	echo $cssitem . ":". (null !==($html->find(trim(explode(':', $cssitem, 2)[0]), 0)) ? 'used': 'unused') . "<br>";
	
/*
$a = "a : hover";
echo trim(explode(':', $cssitem, 2)[0]);*/	

