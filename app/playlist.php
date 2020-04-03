<?php 
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json; charset=utf-8');

$list = isset($_GET['list']) ? $_GET['list'] : null;
$url = "https://youtube.com/playlist?list={$list}";
if (! $list):
    http_response_code(500);
    die(json_encode([
        'status' => '500',
        'message' => 'Error, please enter a valid youtube List ID'
    ]));
endif;
$com = "youtube-dl.exe  {$url} --dump-single-json | jq-win64.exe -r .";
// ex youtube-dl.exe  https://www.youtube.com/watch?v=vjtVJWNNAN8 --dump-single-json | jq-win64.exe -r .


// $vi = 'https://save-tube.com/visitors.txt';

// $text = file_get_contents($vi);

// $array = explode (',', $text);
// $json = json_encode($array);
header("Access-Control-Allow-Origin: *");
header('Content-type: application/json; charset=utf-8');
$res = [];
$exec = exec($com, $res);

$jsonText = '';

foreach ($res as $str) {
    $jsonText .= $str;
}
$jsonText = "[{$jsonText}]";

$toArray = json_decode($jsonText, 1);
//die($jsonText);
$hds = [];

foreach ($toArray[0]['entries'] as $data) {
    foreach ($data['formats'] as $format) {
        if ($format['filesize'] === null) {
            $hds[] = [
                "url" => $format,
                "thumbnail" => $data['thumbnails'][0]['url'],
                "title" => $data['title'],
                "duration" => $data['duration']
            ];
        }
    }
} 
$json = json_encode($hds);
echo $json;
