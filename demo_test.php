<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017\12\14 0014
 * Time: 14:08
 */

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$time = date('r');

ob_flush();
flush();

sleep(2);
echo "data: The server time is: {$time}\n\n";
ob_end_flush();

