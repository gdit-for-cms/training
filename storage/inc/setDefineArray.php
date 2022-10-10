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
}

function setTempGlobal($variableGLOBALS, $globalsVarName, $tempGlobal){
    foreach($variableGLOBALS as $each){
        $globalsVarName[] = $each;
        $tempGlobal[$each] = $GLOBALS[$each];
        unset($GLOBALS[$each]);
    }
    return array( $globalsVarName, $tempGlobal );
}