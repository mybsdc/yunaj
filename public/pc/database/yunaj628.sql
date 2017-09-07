/*
Navicat MySQL Data Transfer

Source Server         : pp
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : yunaj

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-06-28 18:09:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `yunaj_build`
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

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

-- ----------------------------
-- Table structure for `yunaj_checkaudilog`
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
-- Table structure for `yunaj_checkinfo`
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
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_checkinfo
-- ----------------------------
INSERT INTO `yunaj_checkinfo` VALUES ('265', '14', '4645645', '黄渤', '164564654', '4', '1', '下', '456456', '7', '1498108410', '1', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('266', '1', '5201314', '罗小飞', '18281615631', '5', '2', '下', '233123', '7', '1498126752', '0', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('267', '6', '11111', '宋江', '11111111', '3', '2', '下', '1112123', '7', '1498112744', '0', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('268', '2', '2620000', '王兰', '18154642123', '3', '2', '上', '266131', '7', '1498118221', '1', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('269', '2', '2620000', '王兰', '18154642123', '3', '2', '上', '266131', '7', '1498118549', '1', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('270', '2', '2620000', '王兰', '18154642123', '3', '2', '上', '266131', '7', '1498118992', '0', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('271', '8', '23333', '刘艳玲', '15454545541', '4', '1', '下', '6546545', '7', '1498119057', '0', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('272', '3', '2620110', '刘婷', '15864561234', '4', '1', '左', '2501322', '7', '1498119424', '0', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('273', '14', '4645645', '黄渤', '164564654', '4', '1', '下', '456456', '7', '1498119745', '0', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('274', '28', '666111', '胡歌', '18281615631', '5', '2', '左', '123456', '7', '1498120980', '0', null, null);
INSERT INTO `yunaj_checkinfo` VALUES ('275', '29', '123', '罗大佑', '12345678', '3', '1', '上', '222', '7', '1498121826', '0', null, null);

-- ----------------------------
-- Table structure for `yunaj_checkphoto`
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
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_checkphoto
-- ----------------------------
INSERT INTO `yunaj_checkphoto` VALUES ('92', '274', '/public/mobile/uploads/20170622/d3cb85f4be7d0c7187636f04949abc2b.jpg', 'd3cb85f4be7d0c7187636f04949abc2b', 'XzKG_150610052612_1 - 副本 (2)');
INSERT INTO `yunaj_checkphoto` VALUES ('93', '274', '/public/mobile/uploads/20170622/06ca6ca66ba54255d4c714b915a0871f.jpg', '06ca6ca66ba54255d4c714b915a0871f', 'XzKG_150610052612_1 - 副本');
INSERT INTO `yunaj_checkphoto` VALUES ('94', '274', '/public/mobile/uploads/20170622/e08700730f3bc7df2c70880870979ae1.jpg', 'e08700730f3bc7df2c70880870979ae1', 'XzKG_150610052612_1');

-- ----------------------------
-- Table structure for `yunaj_checkproblem`
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
) ENGINE=InnoDB AUTO_INCREMENT=1364 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_checkproblem
-- ----------------------------
INSERT INTO `yunaj_checkproblem` VALUES ('1287', '265', '户内管道是否改动', '未改动|改动', '1', '小黄表现超级好啦');
INSERT INTO `yunaj_checkproblem` VALUES ('1288', '265', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1289', '265', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1290', '265', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1291', '265', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1292', '265', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1293', '265', '室内通风情况', '良好|不好', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1294', '266', '户内管道是否改动', '未改动|改动', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1295', '266', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1296', '266', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1297', '266', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1298', '266', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1299', '266', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1300', '266', '室内通风情况', '良好|不好', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1301', '267', '户内管道是否改动', '未改动|改动', '0', '哈哈哈');
INSERT INTO `yunaj_checkproblem` VALUES ('1302', '267', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1303', '267', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1304', '267', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1305', '267', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1306', '267', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1307', '267', '室内通风情况', '良好|不好', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1308', '268', '户内管道是否改动', '未改动|改动', '0', '啦啦啦啦');
INSERT INTO `yunaj_checkproblem` VALUES ('1309', '268', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1310', '268', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1311', '268', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1312', '268', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1313', '268', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1314', '268', '室内通风情况', '良好|不好', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1315', '269', '户内管道是否改动', '未改动|改动', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1316', '269', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1317', '269', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1318', '269', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1319', '269', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1320', '269', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1321', '269', '室内通风情况', '良好|不好', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1322', '270', '户内管道是否改动', '未改动|改动', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1323', '270', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1324', '270', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1325', '270', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1326', '270', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1327', '270', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1328', '270', '室内通风情况', '良好|不好', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1329', '271', '户内管道是否改动', '未改动|改动', null, '');
INSERT INTO `yunaj_checkproblem` VALUES ('1330', '271', '燃气阀门是否开关自如', '是|否', null, '');
INSERT INTO `yunaj_checkproblem` VALUES ('1331', '271', '户内管道（燃气表）漏气检查', '正常|漏气', null, '');
INSERT INTO `yunaj_checkproblem` VALUES ('1332', '271', '燃气器具安装是否规范', '是|否', null, '');
INSERT INTO `yunaj_checkproblem` VALUES ('1333', '271', '燃气器具有无熄火保护装置', '有|无', null, '');
INSERT INTO `yunaj_checkproblem` VALUES ('1334', '271', '链接软管老化情况', '正常|老化', null, '');
INSERT INTO `yunaj_checkproblem` VALUES ('1335', '271', '室内通风情况', '良好|不好', null, '');
INSERT INTO `yunaj_checkproblem` VALUES ('1336', '272', '户内管道是否改动', '未改动|改动', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1337', '272', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1338', '272', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1339', '272', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1340', '272', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1341', '272', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1342', '272', '室内通风情况', '良好|不好', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1343', '273', '户内管道是否改动', '未改动|改动', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1344', '273', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1345', '273', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1346', '273', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1347', '273', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1348', '273', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1349', '273', '室内通风情况', '良好|不好', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1350', '274', '户内管道是否改动', '未改动|改动', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1351', '274', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1352', '274', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1353', '274', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1354', '274', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1355', '274', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1356', '274', '室内通风情况', '良好|不好', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1357', '275', '户内管道是否改动', '未改动|改动', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1358', '275', '燃气阀门是否开关自如', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1359', '275', '户内管道（燃气表）漏气检查', '正常|漏气', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1360', '275', '燃气器具安装是否规范', '是|否', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1361', '275', '燃气器具有无熄火保护装置', '有|无', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1362', '275', '链接软管老化情况', '正常|老化', '1', '');
INSERT INTO `yunaj_checkproblem` VALUES ('1363', '275', '室内通风情况', '良好|不好', '1', '');

-- ----------------------------
-- Table structure for `yunaj_city2zzjg`
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='城市组织架构对应表-luolongf';

-- ----------------------------
-- Records of yunaj_city2zzjg
-- ----------------------------
INSERT INTO `yunaj_city2zzjg` VALUES ('1', '1', '1');
INSERT INTO `yunaj_city2zzjg` VALUES ('7', '2', '3');

-- ----------------------------
-- Table structure for `yunaj_csdetail`
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_csdetail`;
CREATE TABLE `yunaj_csdetail` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ywcs_id` int(10) unsigned NOT NULL COMMENT '业务参数注册ID  外键',
  `name` varchar(50) NOT NULL COMMENT '名称',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_ywcs_yunaj_csdetail` (`ywcs_id`),
  CONSTRAINT `fk_yunaj_ywcs_yunaj_csdetail` FOREIGN KEY (`ywcs_id`) REFERENCES `yunaj_ywcs` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

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

-- ----------------------------
-- Table structure for `yunaj_fun`
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='功能模块表-luolongf';

-- ----------------------------
-- Records of yunaj_fun
-- ----------------------------
INSERT INTO `yunaj_fun` VALUES ('1', '检查执行', '0', '0', null, null);
INSERT INTO `yunaj_fun` VALUES ('2', '检查记录审核管理', '0', '0', null, null);
INSERT INTO `yunaj_fun` VALUES ('3', '台账', '0', '0', null, null);
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
INSERT INTO `yunaj_fun` VALUES ('20', '安全检查维度', '5', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('21', '燃气用户库', '5', '1', null, null);
INSERT INTO `yunaj_fun` VALUES ('22', '业务参数', '5', '1', null, null);

-- ----------------------------
-- Table structure for `yunaj_project`
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='小区项目（街道）表-luolongf';

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

-- ----------------------------
-- Table structure for `yunaj_role`
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_role`;
CREATE TABLE `yunaj_role` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `zzjg_id` int(20) unsigned NOT NULL COMMENT '组织架构id，自关联',
  `r_id` int(3) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_zzjg_yunaj_role` (`zzjg_id`),
  CONSTRAINT `fk_yunaj_zzjg_yunaj_role` FOREIGN KEY (`zzjg_id`) REFERENCES `yunaj_zzjg` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='角色（岗位表）-luolongf';

-- ----------------------------
-- Records of yunaj_role
-- ----------------------------
INSERT INTO `yunaj_role` VALUES ('1', '2', '2');
INSERT INTO `yunaj_role` VALUES ('2', '2', '3');
INSERT INTO `yunaj_role` VALUES ('3', '2', '4');
INSERT INTO `yunaj_role` VALUES ('15', '21', '3');
INSERT INTO `yunaj_role` VALUES ('16', '21', '4');
INSERT INTO `yunaj_role` VALUES ('23', '1', '3');
INSERT INTO `yunaj_role` VALUES ('24', '4', '2');
INSERT INTO `yunaj_role` VALUES ('25', '4', '4');

-- ----------------------------
-- Table structure for `yunaj_role2func`
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_role2func`;
CREATE TABLE `yunaj_role2func` (
  `id` int(20) NOT NULL,
  `role_id` int(20) unsigned NOT NULL COMMENT '角色id',
  `func_id` int(20) unsigned NOT NULL COMMENT '功能模块id',
  PRIMARY KEY (`id`),
  KEY `fk_yunaj_role_yunaj_role2func` (`role_id`),
  KEY `fk_yunaj_function_role2func` (`func_id`),
  CONSTRAINT `fk_yunaj_function_role2func` FOREIGN KEY (`func_id`) REFERENCES `yunaj_fun` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_yunaj_role_yunaj_role2func` FOREIGN KEY (`role_id`) REFERENCES `yunaj_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色功能模块对应关系表-luolongf';

-- ----------------------------
-- Records of yunaj_role2func
-- ----------------------------

-- ----------------------------
-- Table structure for `yunaj_role2user`
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='角色用户对应关系表-luolongf';

-- ----------------------------
-- Records of yunaj_role2user
-- ----------------------------
INSERT INTO `yunaj_role2user` VALUES ('1', '1', '4');
INSERT INTO `yunaj_role2user` VALUES ('3', '1', '7');
INSERT INTO `yunaj_role2user` VALUES ('9', '15', '8');
INSERT INTO `yunaj_role2user` VALUES ('10', '16', '1');
INSERT INTO `yunaj_role2user` VALUES ('11', '16', '2');
INSERT INTO `yunaj_role2user` VALUES ('12', '2', '4');
INSERT INTO `yunaj_role2user` VALUES ('13', '3', '6');
INSERT INTO `yunaj_role2user` VALUES ('14', '15', '7');
INSERT INTO `yunaj_role2user` VALUES ('15', '15', '4');
INSERT INTO `yunaj_role2user` VALUES ('16', '15', '6');
INSERT INTO `yunaj_role2user` VALUES ('17', '16', '7');
INSERT INTO `yunaj_role2user` VALUES ('18', '16', '8');
INSERT INTO `yunaj_role2user` VALUES ('21', '25', '7');

-- ----------------------------
-- Table structure for `yunaj_roles`
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
-- Table structure for `yunaj_room`
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
  `cstcode` varchar(10) DEFAULT NULL COMMENT '用户编号',
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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_room
-- ----------------------------
INSERT INTO `yunaj_room` VALUES ('1', '1', '2', '17', '22', '06', '2206', '5201314', '罗小飞', '18281615631', '5', '2', '下', '233123', '1');
INSERT INTO `yunaj_room` VALUES ('2', '4', '3', '123', '11', '22', '1122', '2620000', '王兰', '18154642123', '3', '2', '上', '266131', '0');
INSERT INTO `yunaj_room` VALUES ('3', '1', '2', '17', '22', '05', '2205', '2620110', '刘婷', '15864561234', '4', '1', '左', '2501322', '0');
INSERT INTO `yunaj_room` VALUES ('4', '2', '4', '520', '5', '3', '503', '2454545', '老李', '17454542144', '3', '2', '右', '546512', '0');
INSERT INTO `yunaj_room` VALUES ('5', '1', '2', '17', '12', '11', '1211', '24547', '诸葛亮', '11111111111', '3', '2', '左', '23333', '0');
INSERT INTO `yunaj_room` VALUES ('6', '1', '2', '17', '11', '02', '1102', '11111', '宋江', '11111111', '3', '2', '下', '1112123', '0');
INSERT INTO `yunaj_room` VALUES ('7', '1', '2', '17', '10', '03', '1003', '45645', '老王', '13254315', '4', '2', '上', '645645', '0');
INSERT INTO `yunaj_room` VALUES ('8', '1', '2', '17', '22', '16', '2216', '23333', '刘艳玲', '15454545541', '4', '1', '下', '6546545', '0');
INSERT INTO `yunaj_room` VALUES ('13', '4', '3', '1', '16', '16', '1616', '4644654', '老罗', '1542223114', '4', '1', '左', '644125', '1');
INSERT INTO `yunaj_room` VALUES ('14', '1', '2', '16', '9', '6', '906', '4645645', '黄渤', '164564654', '4', '1', '下', '456456', '0');
INSERT INTO `yunaj_room` VALUES ('16', '4', '3', '3', '20', '11', '2011', '266428', '袁琪琪', '18281615631', '4', '2', '下', '12345', '0');
INSERT INTO `yunaj_room` VALUES ('17', '4', '3', '4', '44', '04', '4404', '12345', '陈奕迅', '18281615631', '4', '2', '左', '44444', '0');
INSERT INTO `yunaj_room` VALUES ('18', '25', '21', '1', '21', '36', '2136', '12346', '周杰伦', '911', '3', '2', '上', '233333', '1');
INSERT INTO `yunaj_room` VALUES ('24', '2', '4', '2', '2', '05', '205', '12347', '郭德纲', '15883638651', '4', '2', '右', '83638651', '1');
INSERT INTO `yunaj_room` VALUES ('27', '26', '26', '4', '23', '06', '2306', '888', '王尼玛', '18281615631', '5', '2', '左', '520666', '0');
INSERT INTO `yunaj_room` VALUES ('28', '2', '27', '2', '33', '03', '3303', '666111', '胡歌', '18281615631', '5', '2', '左', '123456', '0');
INSERT INTO `yunaj_room` VALUES ('29', '4', '28', '1', '11', '01', '1101', '123', '罗大佑', '12345678', '3', '1', '上', '222', '0');

-- ----------------------------
-- Table structure for `yunaj_roomlog`
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
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_roomlog
-- ----------------------------
INSERT INTO `yunaj_roomlog` VALUES ('78', '1', '5', '1', '2', '17', '22', '06', '2206', '8', '1', '1497172954', '0', null, null);
INSERT INTO `yunaj_roomlog` VALUES ('79', '1', '10', '25', '24', '17', '22', '06', '2206', '8', '1', '1497173236', '0', null, null);
INSERT INTO `yunaj_roomlog` VALUES ('80', '1', '5', '1', '2', '17', '22', '06', '2206', '8', '1', '1497173458', '0', null, null);
INSERT INTO `yunaj_roomlog` VALUES ('81', '1', '5', '26', '25', '17', '22', '06', '2206', '8', '1', '1497174418', '1', null, null);
INSERT INTO `yunaj_roomlog` VALUES ('82', '13', '6', '4', '3', '1', '16', '16', '1616', '10', '1', '1497319486', '1', null, null);

-- ----------------------------
-- Table structure for `yunaj_task2czr`
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_task2czr`;
CREATE TABLE `yunaj_task2czr` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `taskid` int(20) DEFAULT NULL COMMENT '任务id',
  `type` tinyint(1) NOT NULL COMMENT '对应人类型，0检查人 1审核人',
  `czrid` int(20) NOT NULL COMMENT '操作人id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_task2czr
-- ----------------------------

-- ----------------------------
-- Table structure for `yunaj_task2ywmx`
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_task2ywmx`;
CREATE TABLE `yunaj_task2ywmx` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `taskid` int(20) NOT NULL COMMENT '任务id',
  `ywid` int(20) NOT NULL COMMENT '业务id，记录的是楼栋id、小区id、县镇区id中的一个',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_task2ywmx
-- ----------------------------

-- ----------------------------
-- Table structure for `yunaj_taskset`
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_taskset`;
CREATE TABLE `yunaj_taskset` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '任务名字',
  `bgndate` int(11) DEFAULT NULL COMMENT '开始日期，时间戳',
  `enddate` int(11) DEFAULT NULL COMMENT '截止日期，时间戳',
  `checkrange` tinyint(1) DEFAULT NULL COMMENT '检查范围，1区县镇  2街道小区  3楼栋',
  `createdtime` int(11) DEFAULT NULL COMMENT '创建时间，时间戳格式保存的时间（精确到秒）',
  `createdbyid` int(10) DEFAULT NULL COMMENT '创建人id',
  `status` enum('0','1') DEFAULT '1' COMMENT '1正常 0作废',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yunaj_taskset
-- ----------------------------

-- ----------------------------
-- Table structure for `yunaj_user`
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='用户表-luolongf';

-- ----------------------------
-- Records of yunaj_user
-- ----------------------------
INSERT INTO `yunaj_user` VALUES ('1', '袁检查员', 'yuanjcy', '12345678900', 'test', '1', '2017', 'test');
INSERT INTO `yunaj_user` VALUES ('2', '测试', 'ces', '15122399568', '202cb962ac59075b964b07152d234b70', '0', '2017', '1');
INSERT INTO `yunaj_user` VALUES ('4', '测试3', 'ces32', '15133654788', '202cb962ac59075b964b07152d234b70', '1', '2017', '22');
INSERT INTO `yunaj_user` VALUES ('6', '李伯伯', 'lbb', '1234560', '1', '1', '2011', '111');
INSERT INTO `yunaj_user` VALUES ('7', '隔壁老王', 'admin', '1588', 'e10adc3949ba59abbe56e057f20f883e', '1', '2011', '2018');
INSERT INTO `yunaj_user` VALUES ('8', '刘德华', 'liudh', '13669968854', '202cb962ac59075b964b07152d234b70', '1', '1498467794', null);

-- ----------------------------
-- Table structure for `yunaj_xzqy`
-- ----------------------------
DROP TABLE IF EXISTS `yunaj_xzqy`;
CREATE TABLE `yunaj_xzqy` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '名称',
  `parent_id` int(20) DEFAULT NULL COMMENT '父级id，自关联',
  `type` tinyint(20) NOT NULL COMMENT '类型，0城市、1区\\镇',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='行政区域设置表-luolongf';

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

-- ----------------------------
-- Table structure for `yunaj_ywcs`
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
-- Table structure for `yunaj_zzjg`
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='组织架构表-luolongf';

-- ----------------------------
-- Records of yunaj_zzjg
-- ----------------------------
INSERT INTO `yunaj_zzjg` VALUES ('1', '成都燃气公司', '0', '2', '0');
INSERT INTO `yunaj_zzjg` VALUES ('2', '燃气检查部门', '1', '3', '1');
INSERT INTO `yunaj_zzjg` VALUES ('3', '德阳燃气公司', '0', '2', '0');
INSERT INTO `yunaj_zzjg` VALUES ('4', '燃气检查部门', '3', '3', '1');
INSERT INTO `yunaj_zzjg` VALUES ('5', '绵阳燃气公司', '0', '0', '0');
INSERT INTO `yunaj_zzjg` VALUES ('21', '燃气审核部门', '5', '3', '1');

-- ----------------------------
-- View structure for `yunaj_roomview`
-- ----------------------------
DROP VIEW IF EXISTS `yunaj_roomview`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `yunaj_roomview` AS select `a`.`id` AS `id`,`a`.`proj_id` AS `proj_id`,`a`.`bld_id` AS `bld_id`,`a`.`unit` AS `unit`,`a`.`floor` AS `floor`,`a`.`no` AS `no`,`a`.`room` AS `room`,`a`.`cstcode` AS `cstcode`,`a`.`cstname` AS `cstname`,`a`.`telphone` AS `telphone`,`a`.`type` AS `type`,`a`.`brand` AS `brand`,`a`.`direction` AS `direction`,`a`.`basenumber` AS `basenumber`,`a`.`is_change` AS `is_change` from (`yunaj_room` `a` left join `yunaj_build` `b` on((`a`.`bld_id` = `b`.`id`))) ;
