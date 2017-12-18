<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model {


    protected  $tableName  = 'user';


    //添加数据
    /*
     * @param  $data array 需要添加的数组
     * */
    public function add_info($data){

        if( $uid = $this->create($data)->add()){

            return $uid;

        }else{

            return false;
        }
    }

    //保存用户添加的媒体文件
    /*
     * @param $uid      int    用户uid
     * @param $url_link string 媒体文件url地址
     * */
    public function update_url($uid,$url_link){
        //条件控制
        $map = array();
        $map['uid'] = $uid;

        $url_link_arr = explode(',',$url_link);

        $model = M('media_info');

        foreach($url_link_arr as $val){
            $model->create(array('photo_url'=>$val,'uid'=>$uid));//创建数据对象
            $res  = $model->add();
           if(!$res){
               return false;
           }else{
               continue;
           }
        }
        return $uid;
    }
}