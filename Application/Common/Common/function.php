<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017\12\6 0006
 * Time: 18:08
 */
require_once VENDOR_PATH.'/AliyunOss/autoload.php';
use OSS\OssClient;
use OSS\Core\OssException;
function Aliyun_Oss(){

    $accessKeyId = "LTAIOm1dp8BxHuPE";
    $accessKeySecret = "dBCJRxA2ZAzZXjiWhP1lBkbP4GngMP";
    $endpoint = "oss-cn-beijing.aliyuncs.com";

    $bucket = "puyunjun";

    $object = "a.jpg";

    try {
        $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);
        $position = $ossClient->appendFile($bucket, $object, __FILE__, 0);
        $position = $ossClient->appendFile($bucket, $object, __FILE__, $position);
    } catch (OssException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    var_dump($position);
}