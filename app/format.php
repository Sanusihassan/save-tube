<?php 
/*
	format: [
		'url' => 'https.../' (url),
		'ext' => 'mp4',
		'quality' => '720p',(format_note)
		'filesize' => '57.39MB',
		'isPhoneOnly' => boolean,
		'isVideo' => boolean
	]
*/
class Format
{
	public $data;
	public $info;
	private $fine = ['17','36','5','43','18','22', '299'];
	public $downloadData = [];
	// format_id = 298
	public $_720Size;
	public function __construct($data, $info, $url)
	{
		$this->url = $url;
		$this->info = $info;
		foreach ($data as $key => $d) {
			if (strpos($d['format'], 'audio only' !== false || $d['filesize'] == 0)) {
				unset($data[$key]);
			} else if (! in_array($d['format_id'], $this->fine)) {
				unset($data[$key]);
			}
		}
		$this->data = $data;
	}
	public function format()
	{
		// set the data
		$video = [];
		foreach ($this->data as $key => $value) {
			//if ($value['format_id'])
			// format_note => quality
			$video['quality'] = $value['format_note'];
			// url
			$video['url'] = $value['url'] . "&title={$this->info['title']}.{$value['ext']}";
			// filesize
			$video['filesize'] = $this->setFileSize($value['filesize'], $video['url']);
			// type (ext)
			$video['type'] = $value['ext'];
			//$video['format_id'] = $value['format_id'];

			// is phone
			$video['isPhone'] = $this->isPhone($video);
			// set label that can make the sort easy
			$video['qualilty_int'] = $this->qualityToInt($video['quality']);
			// push them to downloadData
			$this->downloadData[] = $video;
		}
		
		$download = $this->downloadData;
		$val = array_column($download, 'qualilty_int');

		array_multisort($val, SORT_DESC, $download);
		$this->downloadData = $download;
		//return $this->data;
		return $this->downloadData;
	}
	public function setFileSize($size, $url = '')
	{
		if (! $size && $url) {
			return ' HD';
			$size = $this->retrieve_remote_file_size($url);
		}
		$readable =  $size / ( 1024 * 1024 );
		if ($readable >= 1024) {
			return round($readable / 1024, 2) . 'GB';
		}
		return round($readable, 2) . 'MB';
	}
	public function isPhone($video)
	{
		try {
			$quality = str_replace('p', '', $video['quality']);
			$quality = intval($quality);

			if ($quality < 360 && $video['type'] == 'mp4') {
				return true;
			}
		} catch (Exception $e) {
			return false;
		}

		return false;
	}
	public function qualityToInt($q) 
	{
		return intval(str_replace('p', '', $q));
	}
	public function get720Size()
	{
		$cmd = "C:\\Users\\Eissa\\Downloads\\youtube-dl.exe -f best  {$this->url} --dump-single-json | jq-win64.exe -r .";
		$res = [];

		$exec = exec($cmd, $res);
		//die(print_r($res));
		$jsonText = '';
		foreach ($res as $str) {
			$jsonText .= $str;
		}
		$jsonText = "[{$jsonText}]";

		die($jsonText);
	}
	public function retrieve_remote_file_size($url)
	{
		$ch = curl_init($url);
   
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, TRUE);
		curl_setopt($ch, CURLOPT_NOBODY, TRUE);
   
		$data = curl_exec($ch);
		$size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
   
		curl_close($ch);
		return $size;
   }
}