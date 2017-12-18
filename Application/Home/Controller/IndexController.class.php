<?php
namespace Home\Controller;
use Think\Controller;
use Api\Controller\AliyunOss;
use Home\Model\UserModel;
use OSS\Core\OssUtil;
class IndexController extends Controller {

    private static $OssUpload;

    private  static $model;

    public function _initialize(){

        self::$OssUpload = AliyunOss::getinstance()->OssUpload();

        self::$model = new UserModel();
    }

    //过滤信息
    private function get_data(){
        $data = array();
        $data['nickname'] = I('post.nickname','','htmlspecialchars');
        $data['weight'] = I('post.weight','','int');
        $data['stature'] = I('post.stature','','int');
        $data['qq_info'] = I('post.qq','','int');
        $data['userPhoto'] = I('post.userPhoto','','htmlspecialchars');
        $data['head_img'] = '微信请求头像';
        $data['login_time'] = intval(time());
        $data['create_time'] = intval(time());
        $data['remarks'] = I('post.remarks','','htmlspecialchars');
        return $data;
    }
    public function index(){
        if(IS_POST){
            //存入数据
            //先保存基本信息
            $data = $this->get_data();
            unset($data['userPhoto']);
             if( $id  = self::$model->add($data)){
                    //保存媒体文件地址
                 if (self::$model->update_url($id, $this->get_data()['userPhoto'])){

                     $this->ajaxReturn(array('info'=>'保存成功'));
                 }else{

                     $this->ajaxReturn(array('info'=>'图片保存失败'));
                 }
             }else{
                 $this->ajaxReturn(array('info'=>'保存失败'));
             }

        }

        $this->display();
    }

    //上传接口
    public function uploadFile(){
        /*上传函数*/
        //调用上传接口
        $bucket = 'puyunjun'; //阿里云上传模版名
        $object = time().'.png';
        $filePath = $_FILES['file']['tmp_name'];
        try{
             $res = self::$OssUpload->uploadFile($bucket, $object, $filePath);
            //$res = $this->putObjectByRawApis(self::$OssUpload,$bucket,$object,$filePath);
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": FAILED\n");
            printf($e->getMessage() . "\n");
        }
        $this->ajaxReturn(array('info'=>$res));
        if($res === true){
            $this->ajaxReturn(array('info'=>$res));
        }else{
            $this->ajaxReturn(array('info'=>'图片上传失败'));
        }

    }


    //分片上传方法
   public function putObjectByRawApis($ossClient, $bucket, $object,$uploadFile)
    {

        /**
         *  step 1. 初始化一个分块上传事件, 也就是初始化上传Multipart, 获取upload id
         */
        try{
            $uploadId = $ossClient->initiateMultipartUpload($bucket, $object);
        } catch(OssException $e) {
            printf(__FUNCTION__ . ": initiateMultipartUpload FAILED\n");
            printf($e->getMessage() . "\n");
            return false;
        }

       // print(__FUNCTION__ . ": initiateMultipartUpload OK" . "\n");



        /*
         * step 2. 上传分片
         */
        $partSize = 1*1024* 1024;

        $uploadFileSize = filesize($uploadFile);
        $pieces = $ossClient->generateMultiuploadParts($uploadFileSize, $partSize);
        $responseUploadPart = array();
        $uploadPosition = 0;
        $isCheckMd5 = true;
        foreach ($pieces as $i => $piece) {
            $fromPos = $uploadPosition + (integer)$piece[$ossClient::OSS_SEEK_TO];
            $toPos = (integer)$piece[$ossClient::OSS_LENGTH] + $fromPos - 1;
            $upOptions = array(
                $ossClient::OSS_FILE_UPLOAD => $uploadFile,
                $ossClient::OSS_PART_NUM => ($i + 1),
                $ossClient::OSS_SEEK_TO => $fromPos,
                $ossClient::OSS_LENGTH => $toPos - $fromPos + 1,
                $ossClient::OSS_CHECK_MD5 => $isCheckMd5,
            );
            if ($isCheckMd5) {
                $contentMd5 = OssUtil::getMd5SumForFile($uploadFile, $fromPos, $toPos);
                $upOptions[$ossClient::OSS_CONTENT_MD5] = $contentMd5;
            }
            //2. 将每一分片上传到OSS
            try {
                $ossClient->uploadPart($bucket, $object, $uploadId, $upOptions);
            } catch(OssException $e) {
                printf(__FUNCTION__ . ": initiateMultipartUpload, uploadPart - part#{$i} FAILED\n");
                printf($e->getMessage() . "\n");
                return false;
            }



         //   printf(__FUNCTION__ . ": initiateMultipartUpload, uploadPart - part#{$i} OK\n");




        }
        $uploadParts = array();
        foreach ($responseUploadPart as $i => $eTag) {
            $uploadParts[] = array(
                'PartNumber' => ($i + 1),
                'ETag' => $eTag,
            );
        }
        /**
         * step 3. 完成上传
         */
        try {
           $res = $ossClient->completeMultipartUpload($bucket, $object, $uploadId, $uploadParts);
        }  catch(OssException $e) {
            printf(__FUNCTION__ . ": completeMultipartUpload FAILED\n");
            printf($e->getMessage() . "\n");
            return '';
        }
        return $res;
    }


    //请求上传进度

    public function uploadProgress(){
     $i = ini_get('session.upload_progress.name');
        $key = ini_get("session.upload_progress.prefix") . $_GET[$i];
        if (!empty($_SESSION[$key])) {
            $current = $_SESSION[$key]["bytes_processed"];
            $total = $_SESSION[$key]["content_length"];
            $progress = $current < $total ? ceil($current / $total * 100) : 100;
            $this->ajaxReturn(array('info'=>$progress));
        }else{
            $this->ajaxReturn(array('info'=>100));
        }
    }
}