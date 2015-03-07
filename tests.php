<?php

/*CSS Tests passed OK*/
/*
function classOrIdOrOthers($entry) {
	// returns 1 for class, 2 for id, 3 for html element or mediaqueries
    return isset($entry[0]) ? ($entry[0] == '.' ? 1: ($entry[0] == '#' ? 2 :3)):null ;
}
*/
require_once 'simple_html_dom.php';
require_once 'cssparser.php';

$html = file_get_html('test.html');
$stylesheet_url = 'test.css';
$css =  parse($stylesheet_url);
//var_dump($css);
foreach(array_keys($css) as $cssitem)
	echo $cssitem . ":". (null !==($html->find($cssitem, 0)) ? 'used': 'unused') . "<br>";
		


/*html tests*/



//$html = htmlspecialchars(file_get_contents('test.html'));
//echo $html;


//$cssitem = '.myclass';
//echo ltrim($cssitem,".");
//echo startswith($cssitem, "#");
//echo $cssitem[0];
//echo classOrIdOrOthers(".left-content-right .primary-sidebar");


//$html = file_get_html('test.html');
//var_dump($html->find('main') );
//printf(null !==($html->find("#site", 0)) ? 'used': 'unused');

// Find all images
//foreach($html->find('main') as $element)
       //var_dump($element) . '<br>';




