<?php

session_start();

date_default_timezone_set("UTC"); 


$path='../tmp/';//sesion files folder
$file_name='sess_'.$_COOKIE['PHPSESSID'];
$file=$path.$file_name;
$atime=300;//5 min

function inc_count($path,$file,$atime)
{
    !is_dir($path)?mkdir($path,0755,true):false;
    !file_exists($file)?fopen($file, "w"):false;
    $time=file_get_contents($file);
    empty($time)?file_put_contents($file, (time()+$atime)):false;
    if($time<=time())
    {
    file_put_contents($file, time()+$atime);
    }
    if ($handle = opendir($path))
    {
	while (false !== ($entry = readdir($handle)))
	{
	    if ($entry != "." && $entry != "..")
	    {
		$time=file_get_contents($path.$entry);
		if($time<=time())
		{
		unlink($path.$entry);
		}
	    }
	}
	return 'There is<b> '.(count(scandir($path))-2).' </b>online users. (based on users active over the past '.($atime / 60).' minutes)';
	closedir($handle);
    }
}
//usage
echo inc_count($path,$file,$atime);












