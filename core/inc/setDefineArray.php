<?php

function setDefineArray($name, $ary) {
	if ($name == "") return;
	global $$name;
	if (isset($$name)) return;
	$temp = array();
	foreach ($ary as $key => $value) {
		$temp[$key] = $value;
	}
	$$name = $temp;
	return $$name;
	
	// return 1;
}