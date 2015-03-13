<?php
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
$cssfile = str_replace(',', ' ,', $cssfile); // important - this is making all the difference to regex working and not working



foreach($unused as $unuseditem) {
	if(strpos($unuseditem, ' ') > 0){ // if it has child selectorsm
		$pieces = explode(' ', $unuseditem);
		//echo $unuseditem.'----'.$pieces[0]."<br>";
		$pieces[0] = preg_quote($pieces[0], '/'); 
		$cssfile = preg_replace('/(\s*)'.$pieces[0].' +.+[^,{]{/', "{", $cssfile);	
		$unused = array_diff($unused, array($unuseditem));	
	}

}
foreach($unused as $unuseditem) {
	//echo $unuseditem."<br>";
	$unuseditem = preg_quote($unuseditem, '/'); 
	$unuseditem = '(?:(?<=^|\s)(?=\S|$)|(?<=^|\S)(?=\s|$))'.$unuseditem.'(?:(?<=^|\s)(?=\S|$)|(?<=^|\S)(?=\s|$))';
    $cssfile = preg_replace('/'.$unuseditem.'/', "", $cssfile);
	
}

//echo $cssfile;


$cssfile = preg_replace("/(,\s*){2,}/", ",", $cssfile);  // remove multiple instances of comma
$cssfile = preg_replace("/}\s*?,/", "}", $cssfile); // remove deinitions with only comma left as selector

do {
    $cssfile = preg_replace('/}\s*,?\s*{[^}]*}/S', "}", $cssfile, -1, $count); //remove definitions with no selector elements
} while ($count);


do {
    $cssfile = preg_replace('/{\s*,?\s*{[^}]*}/S', "}", $cssfile, -1, $count);// handle 1st unused definition within media query format like ' { {some definitions here }'
} while ($count);


$cssfile = preg_replace("/,\s*{/", "{", $cssfile); //remove instances like ', {' 
$cssfile = preg_replace("/{\s*,/", "{", $cssfile); //remove instances like '{ ,' 


$cssfile = str_replace(' ,', ',', $cssfile); // 
$cssfile = str_replace('}',"}<br>", $cssfile); 
echo $cssfile;


