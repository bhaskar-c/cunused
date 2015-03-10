<?php

$b = "<br>";

require_once 'simple_html_dom.php';
require_once 'cssparser.php';

$html = file_get_html('test.html');
$stylesheet_url = 'test.css';
$css =  parse($stylesheet_url);

$used = array();
$unused = array();
foreach(array_keys($css) as $cssitem) 
	(null !==($html->find(trim(explode(':', $cssitem, 2)[0]), 0)) ? array_push($used, $cssitem) : array_push($unused, $cssitem));
/*	
echo "<h2>Used items </h2>";

foreach($used as $useditem)
	echo $useditem.$b;


echo "<h2>Unused items </h2>";

foreach($unused as $unuseditem)
	echo $unuseditem.$b;
*/


$cssfile = file_get_contents('test.css');
$cssfile = preg_replace('!/\*.*?\*/!s', '', $cssfile); // remove all multiline comments

foreach($unused as $unuseditem) {
	$unuseditem = preg_quote($unuseditem, '/'); 
	
	if(preg_match('/[^a-zA-Z {}]+(?![^{]*})/', $unuseditem)) {
	$cssfile = preg_replace("~\b" .$unuseditem. "\b~", '', $cssfile);} // replace '' with 'someoword' to see its effect
	
	$unuseditem = '(?:(?<=^|\s)(?=\S|$)|(?<=^|\S)(?=\s|$))'.$unuseditem.'(?:(?<=^|\s)(?=\S|$)|(?<=^|\S)(?=\s|$))';
    $cssfile = preg_replace('/'.$unuseditem.'/', "", $cssfile);
}

//working remover of definitions with no selector elements
do {
    $cssfile = preg_replace('/}\s*,?\s*{[^}]*}/S', "}", $cssfile, -1, $count); 
} while ($count);


$cssfile = str_replace('}',"}<br>", $cssfile);
echo $cssfile;


/*
 * partly working
 * foreach($unused as $unuseditem) {
	if (preg_match('/^\w/', $unuseditem))
		$unuseditem = '\b'.$unuseditem;
	if (preg_match('/\w$/', $unuseditem))
    $unuseditem = $unuseditem.'\b';
    //$unuseditem = preg_quote($unuseditem, '.'); 
$cssfile = preg_replace('/'.$unuseditem.'/', "", $cssfile);
*/
