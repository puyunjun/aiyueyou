
CREATE DATABASE IF NOT EXISTS aiyueyou DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
/*
用户注册基本信息表
*/
CREATE TABLE IF NOT EXISTS `user`(
  `id` INT (11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '主键',
  `nickname` VARCHAR (50)  NOT NULL COMMENT '用户站内昵称',
  `weight` CHAR(3) NOT NULL COMMENT '用户体重',
  `stature` CHAR(3) NOT NULL COMMENT '用户身高',
  `qq_info` VARCHAR(11) NOT NULL COMMENT '用户qq',
  `head_img` VARCHAR(100) NOT NULL COMMENT '用户头像',
  `login_time` CHAR(10) NOT NULL COMMENT '登陆时间',
  `create_time` CHAR(10) NOT NULL COMMENT '注册时间'
);


/*
用户授权认证表
*/
 CREATE TABLE IF NOT EXISTS `user_auth`(
  `id` INT (11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '主键',
  `uid` INT (11) NOT NULL COMMENT '关联用户表主键',
  `identity_type` VARCHAR (20) NOT NULL COMMENT '登录类型（手机号 邮箱 用户名）或第三方应用名称（微信 微博等）',
  `identifier`  VARCHAR (50)   NOT NULL  UNIQUE COMMENT '标识（手机号 邮箱 用户名或第三方应用的唯一标识）',
  `credential`  VARCHAR (50) NOT NULL COMMENT '密码凭证（站内的保存密码，站外的不保存或保存token)',
  `status` TINYINT(1) NOT NULL DEFAULT 1 COMMENT '用户状态,4=>用户被禁用,1=>正常用户',
  `create_time` CHAR(10) NOT NULL COMMENT '注册时间'
 );


/*
用户上传图片，视频，音频等url单独表
*/

CREATE TABLE IF NOT EXISTS `media_info`(
  `id` INT (11) NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT '主键',
  `uid` INT (11) NOT NULL COMMENT '关联用户表主键',
   `photo_url` CHAR(100) NOT NULL COMMENT '用户上传的图片连接'
);