<?php
ini_set('display_errors', 'On');

require_once 'format.php';
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json; charset=utf-8');

$id = isset($_GET['id']) ? $_GET['id'] : 'wIKx3OO5Stc';
$url = 'https://youtube.com/watch?v=' . $id;
$cmd = "youtube-dl {$url} --dump-single-json | jq -r .";
//$cmd = "C:\\Users\\Eissa\\Downloads\\youtube-dl.exe  {$url} -F" ;// --dump-single-json | jq-win64.exe -r .";
//$cmd = "youtube-dl.exe   {$url} --dump-single-json | jq-win64.exe -r .";
$res = [];

$exec = exec($cmd, $res);
//die(print_r($res));
$jsonText = '';
try {
	foreach ($res as $str) {
		$jsonText .= $str;
	}
	$jsonText = "[{$jsonText}]";
	//die($jsonText);
	$data = json_decode($jsonText, true);
	if (! isset($data[0]['formats'])) {
		http_response_code(500);
		die(json_encode([
			'status' => '500',
			'message' => 'Error, please enter a valid youtube video ID'
		]));
	} else {
		$info = ['title' => $data[0]['title'], 'duration' => $data[0]['duration']];
		$data = $data[0]['formats'];
	}
	$format = new Format($data, $info, $url);
	echo json_encode($format->format());
} catch (Exception $e) {
	echo json_encode([
		'message' => $e->getMessage()
	]);
}

// C:\Users\Eissa\Downloads\youtube-dl.exe
// https://www.youtube.com/watch?v=wIKx3OO5Stc
// C:\\Users\\Eissa\\Downloads\\youtube-dl.exe  https://www.youtube.com/watch?v=wIKx3OO5Stc --dump-single-json