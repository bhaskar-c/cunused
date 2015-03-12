<?php
require_once 'simple_html_dom.php';
require_once 'cssparser.php';
require_once 'debug.php';
$b = "<br>";
$html = file_get_html('test.html');
$stylesheet_url = 'test.css';
$css =  parse($stylesheet_url);
debug($css);

//var_dump($css);

$used = array();
$unused = array();
foreach(array_keys($css) as $cssitem) 
	(null !==($html->find(trim(explode(':', $cssitem, 2)[0]), 0)) ? array_push($used, $cssitem) : array_push($unused, $cssitem));
	
echo "<h2>Used items </h2>";

foreach ($used as $index => $selector) {
 echo $index.'->' .$selector. $b;


}
