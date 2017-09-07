/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : yunaj

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-07-30 18:17:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yunaj_build
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_build`;
CREATE TABLE `yunaj_build` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `proj_id` int(20) unsigned NOT NULL COMMENT '外键 小区项目id',
  `name` varchar(10) NOT NULL COMMENT '楼栋名称',
  `code` int(3) DEFAULT NULL COMMENT '楼栋编码',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_project_yunaj_build` (`proj_id`),
  CONSTRAINT `fk_yunaj_project_yunaj_build` FOREIGN KEY (`proj_id`) REFERENCES `yunaj_project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_build
-- ----------------------------
INSERT INTO `yunaj_build` VALUES ('1', '1', '2栋', '2');
INSERT INTO `yunaj_build` VALUES ('2', '1', '8栋', '8');
INSERT INTO `yunaj_build` VALUES ('3', '4', '10栋', '10');
INSERT INTO `yunaj_build` VALUES ('4', '2', '7栋', '7');
INSERT INTO `yunaj_build` VALUES ('17', '4', '7栋', '7');
INSERT INTO `yunaj_build` VALUES ('21', '25', '44栋', '44');
INSERT INTO `yunaj_build` VALUES ('22', '1', '11栋', '11');
INSERT INTO `yunaj_build` VALUES ('23', '1', '82栋', '82');
INSERT INTO `yunaj_build` VALUES ('24', '25', '8栋', '8');
INSERT INTO `yunaj_build` VALUES ('25', '26', '8栋', '8');
INSERT INTO `yunaj_build` VALUES ('26', '26', '5栋', '5');
INSERT INTO `yunaj_build` VALUES ('27', '2', '2栋', '2');
INSERT INTO `yunaj_build` VALUES ('28', '4', '2栋', '2');
INSERT INTO `yunaj_build` VALUES ('29', '27', '35', '35');
INSERT INTO `yunaj_build` VALUES ('30', '1', '35栋', '35');
INSERT INTO `yunaj_build` VALUES ('31', '1', '10栋', '10');
INSERT INTO `yunaj_build` VALUES ('32', '2', '5栋', '5');
INSERT INTO `yunaj_build` VALUES ('33', '28', '6栋', '6');
INSERT INTO `yunaj_build` VALUES ('34', '28', '2栋', '2');
INSERT INTO `yunaj_build` VALUES ('35', '28', '1栋', '1');
INSERT INTO `yunaj_build` VALUES ('36', '1', '4栋', '4');
INSERT INTO `yunaj_build` VALUES ('37', '26', '1栋', '1');
INSERT INTO `yunaj_build` VALUES ('38', '29', '7', '7');
INSERT INTO `yunaj_build` VALUES ('39', '30', '8', '8');
INSERT INTO `yunaj_build` VALUES ('40', '31', '11', '11');
INSERT INTO `yunaj_build` VALUES ('41', '1', '7栋', '7');
INSERT INTO `yunaj_build` VALUES ('42', '26', '66栋', '66');
INSERT INTO `yunaj_build` VALUES ('43', '26', '2栋', '2');

-- ----------------------------
-- Table structure for yunaj_checkaudilog
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_checkaudilog`;
CREATE TABLE `yunaj_checkaudilog` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `check_id` int(20) unsigned NOT NULL COMMENT '检查记录id',
  `audituserid` int(20) DEFAULT NULL COMMENT '审核人id',
  `auditusername` varchar(20) DEFAULT NULL COMMENT '审核人姓名',
  `audittime` int(11) DEFAULT NULL COMMENT '审核时间',
  `status` tinyint(1) DEFAULT NULL COMMENT '审核状态',
  `remark` varchar(50) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_checkinfo_yunaj_checkaudilog` (`check_id`),
  CONSTRAINT `fk_yunaj_checkinfo_yunaj_checkaudilog` FOREIGN KEY (`check_id`) REFERENCES `yunaj_checkinfo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_checkaudilog
-- ----------------------------

-- ----------------------------
-- Table structure for yunaj_checkinfo
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_checkinfo`;
CREATE TABLE `yunaj_checkinfo` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` int(20) unsigned NOT NULL COMMENT '房间id',
  `cstcode` varchar(10) NOT NULL COMMENT '用户编号',
  `cstname` varchar(20) DEFAULT NULL COMMENT '姓名',
  `telphone` varchar(50) DEFAULT NULL COMMENT '联系电话 多个,分割',
  `type` varchar(20) DEFAULT NULL COMMENT '气表类型',
  `brand` varchar(20) DEFAULT NULL COMMENT '气表品牌',
  `direction` varchar(5) DEFAULT NULL COMMENT '进气方向',
  `basenumber` int(10) DEFAULT NULL COMMENT '表底数',
  `checkuserid` int(20) DEFAULT NULL COMMENT '查表人id',
  `checktime` int(11) DEFAULT NULL COMMENT '查表时间',
  `status` tinyint(1) DEFAULT NULL COMMENT '状态 0未审核 -1未通过 1通过',
  `audituserid` int(20) DEFAULT NULL COMMENT '审核人id',
  `audittime` int(11) DEFAULT NULL COMMENT '审核时间',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_room_yunaj_checkinfo` (`room_id`),
  CONSTRAINT `fk_yunaj_room_yunaj_checkinfo` FOREIGN KEY (`room_id`) REFERENCES `yunaj_room` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_checkinfo
-- ----------------------------

-- ----------------------------
-- Table structure for yunaj_checkphoto
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_checkphoto`;
CREATE TABLE `yunaj_checkphoto` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `check_id` int(20) unsigned NOT NULL COMMENT '检查记录id',
  `url` varchar(100) NOT NULL COMMENT '照片存放路径',
  `name` varchar(100) NOT NULL COMMENT '文件实际名称',
  `showname` varchar(100) DEFAULT NULL COMMENT '显示名称',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_checkinfo_yunaj_checkphoto` (`check_id`),
  CONSTRAINT `fk_yunaj_checkinfo_yunaj_checkphoto` FOREIGN KEY (`check_id`) REFERENCES `yunaj_checkinfo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_checkphoto
-- ----------------------------

-- ----------------------------
-- Table structure for yunaj_checkproblem
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_checkproblem`;
CREATE TABLE `yunaj_checkproblem` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `check_id` int(20) unsigned NOT NULL,
  `question` varchar(50) NOT NULL COMMENT '问题',
  `answername` varchar(20) DEFAULT NULL COMMENT '答案名称',
  `answer` tinyint(1) DEFAULT NULL COMMENT '答案 0正常 1异常',
  `remark` varchar(50) DEFAULT NULL COMMENT '异常描述',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_checkinfo_yunaj_checkproblem` (`check_id`),
  CONSTRAINT `fk_yunaj_checkinfo_yunaj_checkproblem` FOREIGN KEY (`check_id`) REFERENCES `yunaj_checkinfo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=197 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_checkproblem
-- ----------------------------

-- ----------------------------
-- Table structure for yunaj_city2zzjg
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_city2zzjg`;
CREATE TABLE `yunaj_city2zzjg` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `xzqy_id` int(20) unsigned NOT NULL COMMENT '城市id',
  `zzjg_id` int(20) unsigned NOT NULL COMMENT '公司id',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_xzqy_yunaj_city2zzjg` (`xzqy_id`),
  KEY `fk_yunaj_zzjg_yunaj_city2zzjg` (`zzjg_id`),
  CONSTRAINT `fk_yunaj_xzqy_yunaj_city2zzjg` FOREIGN KEY (`xzqy_id`) REFERENCES `yunaj_xzqy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_yunaj_zzjg_yunaj_city2zzjg` FOREIGN KEY (`zzjg_id`) REFERENCES `yunaj_zzjg` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='城市组织架构对应表-luolongf';

-- ----------------------------
-- Records of yunaj_city2zzjg
-- ----------------------------
INSERT INTO `yunaj_city2zzjg` VALUES ('1', '1', '1');
INSERT INTO `yunaj_city2zzjg` VALUES ('7', '2', '3');
INSERT INTO `yunaj_city2zzjg` VALUES ('8', '1', '5');
INSERT INTO `yunaj_city2zzjg` VALUES ('9', '2', '5');

-- ----------------------------
-- Table structure for yunaj_csdetail
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_csdetail`;
CREATE TABLE `yunaj_csdetail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ywcs_id` int(10) unsigned NOT NULL COMMENT '业务参数注册ID  外键',
  `name` varchar(50) NOT NULL COMMENT '名称',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_ywcs_yunaj_csdetail` (`ywcs_id`),
  CONSTRAINT `fk_yunaj_ywcs_yunaj_csdetail` FOREIGN KEY (`ywcs_id`) REFERENCES `yunaj_ywcs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_csdetail
-- ----------------------------
INSERT INTO `yunaj_csdetail` VALUES ('1', '1', '老虎牌');
INSERT INTO `yunaj_csdetail` VALUES ('2', '1', '狮子牌');
INSERT INTO `yunaj_csdetail` VALUES ('3', '2', '卡表');
INSERT INTO `yunaj_csdetail` VALUES ('4', '2', '智能表');
INSERT INTO `yunaj_csdetail` VALUES ('5', '2', '测试表');
INSERT INTO `yunaj_csdetail` VALUES ('6', '3', '户内管道是否改动|未改动|改动');
INSERT INTO `yunaj_csdetail` VALUES ('7', '3', '燃气阀门是否开关自如|是|否');
INSERT INTO `yunaj_csdetail` VALUES ('8', '3', '户内管道（燃气表）漏气检查|正常|漏气');
INSERT INTO `yunaj_csdetail` VALUES ('9', '3', '燃气器具安装是否规范|是|否');
INSERT INTO `yunaj_csdetail` VALUES ('10', '3', '燃气器具有无熄火保护装置|有|无');
INSERT INTO `yunaj_csdetail` VALUES ('11', '3', '链接软管老化情况|正常|老化');
INSERT INTO `yunaj_csdetail` VALUES ('12', '3', '室内通风情况|良好|不好');
INSERT INTO `yunaj_csdetail` VALUES ('13', '2', '大王表');
INSERT INTO `yunaj_csdetail` VALUES ('14', '1', '漏气');
INSERT INTO `yunaj_csdetail` VALUES ('15', '2', '乌龟表');
INSERT INTO `yunaj_csdetail` VALUES ('16', '1', '牛牛牌');

-- ----------------------------
-- Table structure for yunaj_fun
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_fun`;
CREATE TABLE `yunaj_fun` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '模块名称',
  `parent_id` int(20) DEFAULT NULL COMMENT '父级id，自关联',
  `is_Enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用，1启用，0禁用',
  `createdate` int(11) DEFAULT NULL COMMENT '创建日期，时间戳形式存储的时间，自动保存',
  `remark` varchar(255) DEFAULT NULL COMMENT '描述备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='功能模块表-luolongf';

-- ----------------------------
-- Records of yunaj_fun
-- ----------------------------
INSERT INTO `yunaj_fun` VALUES ('1', '检查执行', '0', '0', null, null);
INSERT INTO `yunaj_fun` VALUES ('2', '检查审核', '0', '0', null, null);
INSERT INTO `yunaj_fun` VALUES ('3', '检查台账', '0', '0', null, null);
INSERT INTO `yunaj_fun` VALUES ('4', '系统设置', '0', '0', null, null);
INSERT INTO `yunaj_fun` VALUES ('5', '数据初始化', '0', '0', null, null);
INSERT INTO `yunaj_fun` VALUES ('6', '任务管理', '0', '0', null, null);
INSERT INTO `yunaj_fun` VALUES ('7', '待检查', '1', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('8', '待审核', '1', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('9', '未通过审核', '1', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('10', '已通过审核', '1', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('11', '待检查', '2', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('12', '待审核', '2', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('13', '未通过审核', '2', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('14', '已通过审核', '2', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('15', '全部数据', '3', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('16', '用户管理', '4', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('17', '组织架构设置', '4', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('18', '权限管理模块', '4', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('19', '城市概况', '5', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('20', '业务参数', '5', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('21', '燃气用户库', '5', '1', null, null);

-- ----------------------------
-- Table structure for yunaj_project
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_project`;
CREATE TABLE `yunaj_project` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `xzqy_id` int(20) unsigned NOT NULL COMMENT '行政区域id',
  `name` varchar(20) NOT NULL COMMENT '小区\\街道\\项目名称',
  `projaddress` varchar(100) DEFAULT NULL COMMENT '地址全路径，城市-区域-项目名称拼接   比如：成都市-青羊区-万科金色领域',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_xzqy_yunaj_project` (`xzqy_id`),
  CONSTRAINT `fk_yunaj_xzqy_yunaj_project` FOREIGN KEY (`xzqy_id`) REFERENCES `yunaj_xzqy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='小区项目（街道）表-luolongf';

-- ----------------------------
-- Records of yunaj_project
-- ----------------------------
INSERT INTO `yunaj_project` VALUES ('1', '5', '半山怡景二期', '成都市-武侯区-半山怡景二期');
INSERT INTO `yunaj_project` VALUES ('2', '5', '山水前城一期', '成都市-武侯区-山水前城一期');
INSERT INTO `yunaj_project` VALUES ('3', '5', '山水前城二期', '成都市-武侯区-山水前城二期');
INSERT INTO `yunaj_project` VALUES ('4', '6', '环球中心四期', '成都市-锦江区-环球中心四期');
INSERT INTO `yunaj_project` VALUES ('22', '6', '花龙门小区', '成都市-锦江区-花龙门小区');
INSERT INTO `yunaj_project` VALUES ('24', '15', '未命名小区', '内江市-袁家区2-未命名小区');
INSERT INTO `yunaj_project` VALUES ('25', '10', '王尼玛小区', '德阳市-广汉区3-王尼玛小区');
INSERT INTO `yunaj_project` VALUES ('26', '5', '琪琪小区', '成都市-武侯区-琪琪小区');
INSERT INTO `yunaj_project` VALUES ('27', '5', '碧寒小区', '');
INSERT INTO `yunaj_project` VALUES ('28', '6', '小黄人小区', '成都市-锦江区-小黄人小区');
INSERT INTO `yunaj_project` VALUES ('29', '16', '中江小区3', null);
INSERT INTO `yunaj_project` VALUES ('30', '16', '中江小区4', null);
INSERT INTO `yunaj_project` VALUES ('31', '16', '中江小区7', null);

-- ----------------------------
-- Table structure for yunaj_role
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_role`;
CREATE TABLE `yunaj_role` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `zzjg_id` int(20) unsigned NOT NULL COMMENT '组织架构id，自关联',
  `r_id` int(3) DEFAULT NULL COMMENT '角色id',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_zzjg_yunaj_role` (`zzjg_id`),
  CONSTRAINT `fk_yunaj_zzjg_yunaj_role` FOREIGN KEY (`zzjg_id`) REFERENCES `yunaj_zzjg` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='角色（岗位表）-luolongf';

-- ----------------------------
-- Records of yunaj_role
-- ----------------------------
INSERT INTO `yunaj_role` VALUES ('6', '2', '2');
INSERT INTO `yunaj_role` VALUES ('7', '2', '3');
INSERT INTO `yunaj_role` VALUES ('10', '4', '2');
INSERT INTO `yunaj_role` VALUES ('11', '4', '4');
INSERT INTO `yunaj_role` VALUES ('16', '10', '3');
INSERT INTO `yunaj_role` VALUES ('17', '10', '4');
INSERT INTO `yunaj_role` VALUES ('23', '9', '2');
INSERT INTO `yunaj_role` VALUES ('24', '9', '4');
INSERT INTO `yunaj_role` VALUES ('25', '12', '3');

-- ----------------------------
-- Table structure for yunaj_role2func
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_role2func`;
CREATE TABLE `yunaj_role2func` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `role_id` int(20) unsigned NOT NULL COMMENT '角色id',
  `func_id` int(20) unsigned NOT NULL COMMENT '功能模块id',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_role_yunaj_role2func` (`role_id`),
  KEY `fk_yunaj_function_role2func` (`func_id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 COMMENT='角色功能模块对应关系表-luolongf';

-- ----------------------------
-- Records of yunaj_role2func
-- ----------------------------
INSERT INTO `yunaj_role2func` VALUES ('92', '3', '1');
INSERT INTO `yunaj_role2func` VALUES ('93', '3', '2');
INSERT INTO `yunaj_role2func` VALUES ('94', '3', '3');
INSERT INTO `yunaj_role2func` VALUES ('95', '3', '4');
INSERT INTO `yunaj_role2func` VALUES ('96', '3', '5');
INSERT INTO `yunaj_role2func` VALUES ('97', '3', '6');
INSERT INTO `yunaj_role2func` VALUES ('98', '4', '1');
INSERT INTO `yunaj_role2func` VALUES ('99', '4', '2');
INSERT INTO `yunaj_role2func` VALUES ('100', '4', '3');
INSERT INTO `yunaj_role2func` VALUES ('101', '4', '4');
INSERT INTO `yunaj_role2func` VALUES ('102', '4', '5');
INSERT INTO `yunaj_role2func` VALUES ('103', '4', '6');
INSERT INTO `yunaj_role2func` VALUES ('126', '2', '1');
INSERT INTO `yunaj_role2func` VALUES ('127', '2', '2');
INSERT INTO `yunaj_role2func` VALUES ('128', '2', '3');
INSERT INTO `yunaj_role2func` VALUES ('129', '2', '4');
INSERT INTO `yunaj_role2func` VALUES ('130', '2', '5');
INSERT INTO `yunaj_role2func` VALUES ('131', '2', '6');

-- ----------------------------
-- Table structure for yunaj_role2user
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_role2user`;
CREATE TABLE `yunaj_role2user` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(20) unsigned NOT NULL COMMENT '角色id',
  `user_id` int(20) unsigned NOT NULL COMMENT '用户id',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_role_yunaj_role2user` (`role_id`),
  KEY `fk_yunaj_user_yunaj_role2user` (`user_id`),
  CONSTRAINT `fk_yunaj_role_yunaj_role2user` FOREIGN KEY (`role_id`) REFERENCES `yunaj_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_yunaj_user_yunaj_role2user` FOREIGN KEY (`user_id`) REFERENCES `yunaj_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='角色用户对应关系表-luolongf';

-- ----------------------------
-- Records of yunaj_role2user
-- ----------------------------
INSERT INTO `yunaj_role2user` VALUES ('8', '6', '10');
INSERT INTO `yunaj_role2user` VALUES ('9', '7', '11');
INSERT INTO `yunaj_role2user` VALUES ('10', '7', '7');
INSERT INTO `yunaj_role2user` VALUES ('11', '10', '6');
INSERT INTO `yunaj_role2user` VALUES ('12', '6', '14');
INSERT INTO `yunaj_role2user` VALUES ('13', '6', '15');
INSERT INTO `yunaj_role2user` VALUES ('14', '7', '13');
INSERT INTO `yunaj_role2user` VALUES ('15', '7', '16');
INSERT INTO `yunaj_role2user` VALUES ('16', '6', '12');

-- ----------------------------
-- Table structure for yunaj_roles
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_roles`;
CREATE TABLE `yunaj_roles` (
  `id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '角色名称',
  `Function` tinyint(4) NOT NULL COMMENT '功能权限',
  `is_all` varchar(50) NOT NULL DEFAULT '0' COMMENT '0否，1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_roles
-- ----------------------------
INSERT INTO `yunaj_roles` VALUES ('1', '系统管理员', '0', '1');
INSERT INTO `yunaj_roles` VALUES ('2', '检查', '1', '0');
INSERT INTO `yunaj_roles` VALUES ('3', '审核', '2', '0');
INSERT INTO `yunaj_roles` VALUES ('4', '基础数据管理', '3', '0');

-- ----------------------------
-- Table structure for yunaj_room
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_room`;
CREATE TABLE `yunaj_room` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `proj_id` int(20) unsigned NOT NULL COMMENT '外键  项目id',
  `bld_id` int(20) unsigned NOT NULL COMMENT '楼栋id',
  `unit` int(3) DEFAULT NULL COMMENT '单元',
  `floor` int(3) DEFAULT NULL COMMENT '楼层',
  `no` varchar(5) DEFAULT NULL COMMENT '房号',
  `room` varchar(10) DEFAULT NULL COMMENT '房间',
  `cstcode` varchar(100) DEFAULT NULL COMMENT '用户编号',
  `cstname` varchar(20) DEFAULT NULL COMMENT '用户姓名',
  `telphone` varchar(50) DEFAULT NULL COMMENT '联系电话 多个用英文逗号分隔',
  `type` varchar(20) DEFAULT NULL COMMENT '气表类型',
  `brand` varchar(20) DEFAULT NULL COMMENT '气表品牌',
  `direction` varchar(5) DEFAULT NULL COMMENT '进气方向',
  `basenumber` int(10) DEFAULT NULL COMMENT '表底数',
  `is_change` tinyint(1) DEFAULT '0' COMMENT '信息是否改动 0否 1是',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_project_yunaj_room` (`proj_id`),
  KEY `fk_yunaj_build_yunaj_room` (`bld_id`),
  CONSTRAINT `fk_yunaj_build_yunaj_room` FOREIGN KEY (`bld_id`) REFERENCES `yunaj_build` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_yunaj_project_yunaj_room` FOREIGN KEY (`proj_id`) REFERENCES `yunaj_project` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_room
-- ----------------------------
INSERT INTO `yunaj_room` VALUES ('1', '1', '30', '11', '22', '05', '2205', '5201314', '罗小飞', '18281615631', '4', '1', '上', '66666', '0');
INSERT INTO `yunaj_room` VALUES ('2', '1', '30', '11', '22', '06', '2206', '2620000', '刘婷', '15885556811', '5', '1', '右', '777333', '0');
INSERT INTO `yunaj_room` VALUES ('8', '1', '31', '11', '22', '04', '2204', '23333', '马化腾', '123456', '5', '2', '左', '6969777', '0');
INSERT INTO `yunaj_room` VALUES ('33', '1', '1', '3', '11', '02', '1102', '99999', '马云', '119', '4', '2', '右', '789', '0');
INSERT INTO `yunaj_room` VALUES ('34', '2', '32', '6', '11', '03', '1103', '7777', '李彦宏', '748', '3', '1', '上', '124', '0');
INSERT INTO `yunaj_room` VALUES ('35', '28', '33', '9', '69', '69', '6969', '6363', '罗永浩', '6666', '3', '1', '上', '778899', '0');
INSERT INTO `yunaj_room` VALUES ('36', '28', '34', '3', '12', '06', '1206', '335566', '王尼玛', '45645', '3', '1', '上', '3344', '0');
INSERT INTO `yunaj_room` VALUES ('37', '28', '35', '1', '11', '09', '1109', '11111', '孙悟空', '3333332', '3', '1', '上', '0', '0');
INSERT INTO `yunaj_room` VALUES ('38', '1', '36', '6', '22', '07', '2207', '69683', '唐僧', '77777', '3', '1', '上', '73735', '0');
INSERT INTO `yunaj_room` VALUES ('39', '1', '36', '4', '44', '07', '4407', '362223', '猪八戒', '99999', '3', '1', '上', '6666', '0');
INSERT INTO `yunaj_room` VALUES ('40', '26', '37', '1', '11', '04', '1104', '36299', '沙僧', '333', '3', '1', '上', '9987', '0');
INSERT INTO `yunaj_room` VALUES ('41', '29', '38', '4', '14', '03', '1403', '30126', '望秋水', '555555', '4', '16', '下', '1160', null);
INSERT INTO `yunaj_room` VALUES ('42', '30', '39', '5', '15', '04', '1504', '30127', '中二', '9326', '13', '14', '左', '1960', null);
INSERT INTO `yunaj_room` VALUES ('43', '31', '40', '8', '18', '07', '1807', '30130', '中一', '10010', '15', '14', '上', '50', null);
INSERT INTO `yunaj_room` VALUES ('44', '1', '41', '7', '77', '07', '7707', '69999', '小伙子', '0', '3', '1', '上', '520333', '0');
INSERT INTO `yunaj_room` VALUES ('45', '26', '42', '99', null, null, '696969', '33', '罗大大', '36435416', '4', '2', '下', '22222', '0');
INSERT INTO `yunaj_room` VALUES ('46', '26', '43', '1', '22', '03', '2203', '76969', '大黄', '123456', '3', '2', '上', '778899', '0');

-- ----------------------------
-- Table structure for yunaj_roomlog
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_roomlog`;
CREATE TABLE `yunaj_roomlog` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `room_id` int(20) unsigned NOT NULL COMMENT '房间id 外键',
  `xzqy_id` varchar(20) NOT NULL COMMENT '行政区域id',
  `proj_id` int(20) NOT NULL COMMENT '行政区域id',
  `bld_id` int(20) NOT NULL COMMENT '楼栋id',
  `unit` int(3) DEFAULT NULL COMMENT '单元',
  `floor` int(3) DEFAULT NULL COMMENT '楼层',
  `no` varchar(5) DEFAULT NULL COMMENT '房号',
  `room` varchar(10) DEFAULT NULL COMMENT '房间',
  `code` varchar(10) DEFAULT NULL COMMENT '房间 如1402',
  `checkuserid` int(20) DEFAULT NULL COMMENT '检查人id',
  `checktime` int(11) DEFAULT NULL COMMENT '检查时间',
  `is_new` tinyint(1) DEFAULT '1' COMMENT '是否最新 1 是 0 否 ',
  `audituserid` int(20) DEFAULT NULL COMMENT '审核人id',
  `audittime` int(11) DEFAULT NULL COMMENT '审核时间',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_room_yunaj_roomlog` (`room_id`),
  CONSTRAINT `fk_yunaj_room_yunaj_roomlog` FOREIGN KEY (`room_id`) REFERENCES `yunaj_room` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_roomlog
-- ----------------------------

-- ----------------------------
-- Table structure for yunaj_task2czr
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_task2czr`;
CREATE TABLE `yunaj_task2czr` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `taskid` int(20) DEFAULT NULL COMMENT '任务id',
  `type` tinyint(1) NOT NULL COMMENT '对应人类型，0检查人 1审核人',
  `czrid` int(20) NOT NULL COMMENT '操作人id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_task2czr
-- ----------------------------
INSERT INTO `yunaj_task2czr` VALUES ('26', '11', '0', '10');
INSERT INTO `yunaj_task2czr` VALUES ('27', '11', '1', '7');
INSERT INTO `yunaj_task2czr` VALUES ('28', '12', '0', '10');
INSERT INTO `yunaj_task2czr` VALUES ('29', '12', '1', '7');

-- ----------------------------
-- Table structure for yunaj_task2ywmx
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_task2ywmx`;
CREATE TABLE `yunaj_task2ywmx` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT NULL COMMENT '1楼栋 2小区 3县镇区',
  `taskid` int(20) NOT NULL COMMENT '任务id',
  `ywid` int(20) NOT NULL COMMENT '业务id，记录的是楼栋id、小区id、县镇区id中的一个',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_task2ywmx
-- ----------------------------
INSERT INTO `yunaj_task2ywmx` VALUES ('19', '3', '11', '5');
INSERT INTO `yunaj_task2ywmx` VALUES ('20', '3', '12', '6');

-- ----------------------------
-- Table structure for yunaj_taskset
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_taskset`;
CREATE TABLE `yunaj_taskset` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '任务名字',
  `bgndate` int(11) DEFAULT NULL COMMENT '开始日期，时间戳',
  `enddate` int(11) DEFAULT NULL COMMENT '截止日期，时间戳',
  `checkrange` tinyint(1) DEFAULT NULL COMMENT '1楼栋 2小区 3县镇区',
  `createdtime` int(11) DEFAULT NULL COMMENT '创建时间，时间戳格式保存的时间（精确到秒）',
  `createdbyid` int(10) DEFAULT NULL COMMENT '创建人id',
  `status` enum('0','1') DEFAULT '1' COMMENT '1正常 0作废',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_taskset
-- ----------------------------
INSERT INTO `yunaj_taskset` VALUES ('11', '武侯区任务', '1499356800', '1504022400', '3', '1501408854', '7', '1', null);
INSERT INTO `yunaj_taskset` VALUES ('12', '锦江区任务', '1499356800', '1504108800', '3', '1501408892', '7', '1', '');

-- ----------------------------
-- Table structure for yunaj_user
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_user`;
CREATE TABLE `yunaj_user` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '用户名称',
  `code` varchar(10) NOT NULL COMMENT '用户代码，姓全拼+名首字母',
  `mobile` char(11) NOT NULL COMMENT '手机',
  `pwd` varchar(40) NOT NULL COMMENT '密码，加密字段',
  `is_Enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用，1启用，0禁用',
  `createdate` int(11) NOT NULL COMMENT '创建日期，时间戳形式存储的时间，自动保存',
  `openid` varchar(100) DEFAULT NULL COMMENT '微信openid',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`) USING BTREE,
  UNIQUE KEY `mobile` (`mobile`) USING BTREE,
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='用户表-luolongf';

-- ----------------------------
-- Records of yunaj_user
-- ----------------------------
INSERT INTO `yunaj_user` VALUES ('1', '袁检查员', 'yuanjcy', '12345678900', 'test', '1', '2017', 'test');
INSERT INTO `yunaj_user` VALUES ('2', '检查测试', 'jianccs', '15102233920', '2', '1', '2017', '1');
INSERT INTO `yunaj_user` VALUES ('4', '审核测试', 'shenhcs', '15102333920', '1', '1', '2017', '22');
INSERT INTO `yunaj_user` VALUES ('6', '李伯伯', 'lbb', '1234560', 'e10adc3949ba59abbe56e057f20f883e', '1', '2011', '111');
INSERT INTO `yunaj_user` VALUES ('7', '超级管理员', 'admin', '1588', 'e10adc3949ba59abbe56e057f20f883e', '1', '2011', '1234');
INSERT INTO `yunaj_user` VALUES ('8', '杨审核', 'y', '11', '1', '1', '2003', '64684');
INSERT INTO `yunaj_user` VALUES ('9', '地点测试', 'd', '11111', '11111111', '1', '11', '11');
INSERT INTO `yunaj_user` VALUES ('10', '小明', 'xm', '262', 'e10adc3949ba59abbe56e057f20f883e', '1', '2', '2222');
INSERT INTO `yunaj_user` VALUES ('11', '大葱', 'dc', '666', 'e10adc3949ba59abbe56e057f20f883e', '1', '0', '');
INSERT INTO `yunaj_user` VALUES ('12', '阳顶天', 'yangdt', '15102133920', 'e10adc3949ba59abbe56e057f20f883e', '1', '0', '3');
INSERT INTO `yunaj_user` VALUES ('13', '苏朵朵', 'duod', '13666365234', '202cb962ac59075b964b07152d234b70', '1', '1500543965', null);
INSERT INTO `yunaj_user` VALUES ('14', '王大力', 'wangdl', '14889756489', '202cb962ac59075b964b07152d234b70', '1', '1500544860', null);
INSERT INTO `yunaj_user` VALUES ('15', '王大锤', 'wangdc', '12530175940', '202cb962ac59075b964b07152d234b70', '1', '1500544890', null);
INSERT INTO `yunaj_user` VALUES ('16', '雪菲', 'xuef', '15102433920', '50905d7b2216bfeccb5b41016357176b', '1', '1500599877', null);

-- ----------------------------
-- Table structure for yunaj_xzqy
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_xzqy`;
CREATE TABLE `yunaj_xzqy` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '名称',
  `parent_id` int(20) DEFAULT NULL COMMENT '父级id，自关联',
  `type` tinyint(20) NOT NULL COMMENT '类型，0城市、1区\\镇',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='行政区域设置表-luolongf';

-- ----------------------------
-- Records of yunaj_xzqy
-- ----------------------------
INSERT INTO `yunaj_xzqy` VALUES ('1', '成都市', '0', '0');
INSERT INTO `yunaj_xzqy` VALUES ('2', '德阳市', '0', '0');
INSERT INTO `yunaj_xzqy` VALUES ('3', '绵阳市', '0', '0');
INSERT INTO `yunaj_xzqy` VALUES ('4', '内江市', '0', '0');
INSERT INTO `yunaj_xzqy` VALUES ('5', '武侯区', '1', '1');
INSERT INTO `yunaj_xzqy` VALUES ('6', '锦江区', '1', '1');
INSERT INTO `yunaj_xzqy` VALUES ('7', '双流区', '1', '1');
INSERT INTO `yunaj_xzqy` VALUES ('8', '广汉区1', '2', '1');
INSERT INTO `yunaj_xzqy` VALUES ('9', '广汉区2', '2', '1');
INSERT INTO `yunaj_xzqy` VALUES ('10', '广汉区3', '2', '1');
INSERT INTO `yunaj_xzqy` VALUES ('11', '游仙区1', '3', '1');
INSERT INTO `yunaj_xzqy` VALUES ('12', '游仙区2', '3', '1');
INSERT INTO `yunaj_xzqy` VALUES ('13', '游仙区3', '3', '1');
INSERT INTO `yunaj_xzqy` VALUES ('14', '袁家区1', '4', '1');
INSERT INTO `yunaj_xzqy` VALUES ('15', '袁家区2', '4', '1');
INSERT INTO `yunaj_xzqy` VALUES ('16', '中江县', '2', '1');

-- ----------------------------
-- Table structure for yunaj_ywcs
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_ywcs`;
CREATE TABLE `yunaj_ywcs` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '参数名称',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型 1公司（城市）2区域 3集团',
  `zzjg_id` int(20) unsigned NOT NULL COMMENT '组织架构id',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_zzjg_yunaj_ywcs` (`zzjg_id`),
  CONSTRAINT `fk_yunaj_zzjg_yunaj_ywcs` FOREIGN KEY (`zzjg_id`) REFERENCES `yunaj_zzjg` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_ywcs
-- ----------------------------
INSERT INTO `yunaj_ywcs` VALUES ('1', '品牌', '1', '1');
INSERT INTO `yunaj_ywcs` VALUES ('2', '气表类型', '1', '1');
INSERT INTO `yunaj_ywcs` VALUES ('3', '检查问题', '1', '1');

-- ----------------------------
-- Table structure for yunaj_zzjg
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_zzjg`;
CREATE TABLE `yunaj_zzjg` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '名称',
  `parent_id` int(20) DEFAULT NULL COMMENT '父级id，自关联',
  `type` tinyint(1) NOT NULL COMMENT '类型，0集团、1区域、2公司、3部门',
  `is_end` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否末级，0否，1是',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_zzjg_yunaj_role` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='组织架构表-luolongf';

-- ----------------------------
-- Records of yunaj_zzjg
-- ----------------------------
INSERT INTO `yunaj_zzjg` VALUES ('1', '成都燃气公司', '0', '2', '0');
INSERT INTO `yunaj_zzjg` VALUES ('2', '燃气检查部门', '1', '3', '1');
INSERT INTO `yunaj_zzjg` VALUES ('3', '德阳燃气公司', '0', '2', '0');
INSERT INTO `yunaj_zzjg` VALUES ('4', '燃气检查部门', '3', '3', '1');
INSERT INTO `yunaj_zzjg` VALUES ('5', '测试公司', '0', '2', '0');
INSERT INTO `yunaj_zzjg` VALUES ('9', '燃气检查部门', '5', '3', '1');
INSERT INTO `yunaj_zzjg` VALUES ('10', '燃气审核部门', '5', '3', '1');
INSERT INTO `yunaj_zzjg` VALUES ('12', '燃气审核部门', '1', '3', '1');
