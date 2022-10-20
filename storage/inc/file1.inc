<?php

// comment ...
// comment ...
// comment ...
$ary = array(
	array(
		'name' => '', 
		'width' => 178, 
		'height' => '', 
		'exp' => '.jpg'
	), 
	array(
		'name' => '_1', 
		'width' => 110, 
		'height' => '', 
		'exp' => '.jpg'
	)
);
// 公開領域のルートパス（HTTP）
define("HTTP_ROOT", "http://cms230.dev1.local/");
// 公開領域のルートパス（内部）
define("DOCUMENT_ROOT", "/htdocs/training222222");
// 本サーバのルートパス
define("REAL_ROOT", "/htdocs/real_root");
setDefineArray('IMAGE_TEST', $ary);
// comment ...
// comment ...

$ary = array(
	array(
		'name' => 'img_1', 
		'width' => 178, 
		'height' => '', 
		'exp' => '.jpg'
	), 
	array(
		'name' => '_1', 
		'width' => 110, 
		'height' => '', 
		'exp' => '.jpg'
	)
);
setDefineArray('IMAGE_TEST_2222', $ary);
// comment ...
if (isset($_SERVER['SERVER_NAME'])) {
	define("SERVER_NAME", "training.xxx");
}
else {
	define("SERVER_NAME", "training_test.xxx");
}