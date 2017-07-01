<?php
/**
 * 用户房间详情页面控制器
 *
 */

namespace app\mobile\controller;

use think\Controller;
use think\db\Query;

class UserInfo extends Base
{
    // 房间详情展示
    public function index()
    {
        $room = model('Room');
        $cs = model('Ywcs'); // 业务参数模型
        $check = model('CheckInfo'); // 检查记录模型
        $xzqy = model('Xzqy'); // 城市区域模型
        $project = model('Project'); // 小区模型
        $checkPro = model('Checkproblem'); // 检查问题记录表模型
        $photo = model('Checkphoto'); // 检查记录照片表模型
/*         $imgUrl = $photo->getImgUrl(252);
        p($imgUrl); */
//         p(getcwd());
        $area = $xzqy->getAllXzqy(1); // 所有区域
        $xq = $project->getAllXq(); // 所有小区

        // 判断是否传入客户编号
        if (input('get.cstcode') != ''){
            $cstcode = input('get.cstcode'); // 客户编号
            $roomInfo = $room->getRoomInfo($cstcode);
        } else { // 通过值来判断，一般走不到这个分支
            return $this->error('请输入客户编号');
        }
        
        $type = $cs->getCs('气表类型'); // 气表类型
        $brand = $cs->getCs('品牌'); // 品牌
        $problem = $cs->getCs('检查问题'); // 检查问题
        
        // 判断是否穿透查询
        if (input('?get.from') && input('get.from') === 'myLog'){
            $check_id = input('get.check_id/d'); // 检查记录id
            $status = input('get.status/d'); // 审核状态
            
            // 问题详情
            $toGetPro = $checkPro->toGetPro($check_id, $status);
            $this->assign('toGetPro', $toGetPro);
            $this->assign('logStatus', $status); // 该条记录审核状态
            
            // 获取图片地址
            $imgUrl = $photo->getImgUrl($check_id);
            $this->assign('imgUrl', $imgUrl);
        }
        
        $this->assign('xq', $xq);
        $this->assign('area', $area);
        $this->assign('type', $type);
        $this->assign('brand', $brand);
        $this->assign('problem', $problem);
        $this->assign('roomInfo', $roomInfo);
        return $this->fetch();
    }
    
    // 判断用户是否存在
    public function haveRoom()
    {
        $room = model('Room');
        $cstcode = input('get.cstcode'); // 客户编号
        $result = $room->haveUser($cstcode);
        if (!$result){
            echo 0; // 此房间不存在，提示新增
        } else {
            echo 1;
        }
    }
    
    // 安全检查记录与入户登记信息接收处理
    public function doInfo()
    {
//         p($_POST);
        if (!input('?post.cstcode')){
            return $this->error('非法访问！');
        }
        
        $room = model('Room');
        $check = model('CheckInfo');
        $checkPro = model('Checkproblem'); // 检查问题记录表模型
        $project = model('Project'); // 小区表模型
        $build = model('Build'); // 栋表模型
        $roomlog = model('Roomlog'); // 房间历史信息表模型
        $photo = model('Checkphoto'); // 检查记录照片表模型

        // 数据准备
        $userData = input('post.');
        $checkuserid = session('checkuserid'); // 用于检查者识别码

        // 过滤数据，防止用户瞎球输入
        $userData['room'] = (int)$userData['room'];
        $userData['dong'] = (int)$userData['dong'];
        $userData['unit'] = (int)$userData['unit'];
        $userData['basenumber'] = (int)$userData['basenumber'];
//         $userData['cstcode'] = (int)$userData['cstcode']; // 考虑到用户编号可能含字母，故不转了
        $userData['telphone'] = (int)$userData['telphone'];
        $userData['proj_name'] = (string)$userData['proj_name'];
        $userData['checkuserid'] = $checkuserid; // 检查者id

        /**
         * 判断该房间信息是否存在，不存在则新增
         */
        $exist = $room->haveUser($userData['cstcode']);
        if (!$exist){ // 判断是否新增房间
            
            // 取楼层与编号
            if(strlen($userData['room']) == 3){
                $userData['floor'] = substr($userData['room'], 0, 1); // 取第一位
                $userData['no'] = substr($userData['room'], -2); // 取房间编号
            } else if (strlen($userData['room']) == 4) {
                $userData['floor'] = substr($userData['room'], 0, 2); // 取前两位
                $userData['no'] = substr($userData['room'], -2);
            }

            // 判断是否新增小区
            if (!$project->haveProj($userData['proj_name'])){
                $userData['proj_id'] = $project->addProj($userData['xzqy_id'], $userData['proj_name']); // 新增小区
                $userData['bld_id'] = $build->addDong($userData['dong'], $userData['proj_id']); // 新增栋信息
            } else {
                $userData['bld_id'] = $build->getBldId($userData['dong'], $userData['proj_id']);// 若非新增，根据已有信息取bld_id
                if (empty($userData['bld_id'])){ // bld_id取出不成功，楼栋信息漏录情况
                    $userData['bld_id'] = $build->addDong($userData['dong'], $userData['proj_id']); // 自动新增栋信息
                }
            }
            
            // 新增房间信息
            $addResult = $room->allowField(true)->save($userData);
            $userData['room_id'] = $room->id; // 更新room_id，后面检查问题记录会用到
            
            // 调用问题记录处理方法，并在该方法中return
            $this->doProInfo($userData);
        } else {
            
            /**
             * 编辑检查模式
             */
            
            // 确定bld_id与proj_id
            if (!$project->haveProj($userData['proj_name'])){ // 判断该小区名是否存在，精确查找
                $userData['proj_id'] = $project->addProj($userData['xzqy_id'], $userData['proj_name']); // 新增小区
                $userData['bld_id'] = $build->addDong($userData['dong'], $userData['proj_id']); // 新增栋信息
            } else {
                $userData['bld_id'] = $build->getBldId($userData['dong'], $userData['proj_id']);// 根据已有信息取bld_id
                if (empty($userData['bld_id'])){ // bld_id取出不成功，楼栋信息漏录情况
                    $userData['bld_id'] = $build->addDong($userData['dong'], $userData['proj_id']); // 自动新增栋信息
                }
            }
            
            // 判断房间详细地址是否被修改
            $whereFindRoom = ['proj_id' => $userData['proj_id'], 'bld_id' => $userData['bld_id'], 'unit' => $userData['unit'], 'room' => $userData['room']]; // 查询条件构造
            if (!$room->checkAddressInfo($userData['cstcode'], $whereFindRoom)){
                
                // 备份该房间之前信息
                $userInfoBefore = $room->getRoomInfo($userData['cstcode']);
                $userInfoBefore['room_id'] = $userInfoBefore['id'];
                unset($userInfoBefore['id']); // 此id非彼id，此处释放不会影响问题信息记录操作
                $userInfoBefore['proj_id'] = $userInfoBefore['xq_id'];
                $userInfoBefore['bld_id'] = $userInfoBefore['bldID'];
                $userInfoBefore['checkuserid'] = $checkuserid; // checkuserid从session中取
                $userInfoBefore['is_new'] = 1; // 默认此字段为1
                $userInfoBefore['checktime'] = time();
                $roomlog->backupRoom($userInfoBefore); // 备份操作
    
                // 更新房间数据准备
                if(strlen($userData['room']) == 3){ // 通过房号取楼层与编号
                    $userData['floor'] = substr($userData['room'], 0, 1); // 取第一位
                    $userData['no'] = substr($userData['room'], -2); // 取房间编号
                } else if (strlen($userData['room']) == 4) {
                    $userData['floor'] = substr($userData['room'], 0, 2); // 取前两位
                    $userData['no'] = substr($userData['room'], -2);
                }
                $userData['is_change'] = 1; // 改动标识
                $room->updateRoom($userData['cstcode'], $userData); // 房间详细地址改动操作
            }
                
            // 更新房间基本信息
            $roomBaseInfo = ['basenumber' => $userData['basenumber'], 'type' => $userData['type'], 'brand' => $userData['brand'], 'direction' => $userData['direction'], 'cstname' => $userData['cstname'], 'telphone' => $userData['telphone']];
            $room->allowField(true)->save($roomBaseInfo,['cstcode' => $userData['cstcode']]);
            
            // 判断是否穿透查询的提交事件
           if (input('?post.resetPro') && input('post.resetPro') == 1){ // post过来的resetPro是字符串类型
                $resetPro = [];
//                 p($_POST);
                $is_check_id = input('post.check_id'); // 用于穿透新增图片
                foreach ($userData as $k => $v){ // 组装批量更新数组
                   if (is_array($v) && $k !== 'image'){ // 问题详情记录数据
                       $v['id'] = $k;
                       $resetPro[] = $v;
                   }
                   if (is_array($v) && $k === 'image'){ // 图片数据
                       foreach ($v as $k2 => $v2){
                            $img[$k2]['url'] = str_replace(strrchr($v2, '.'), '', $v2);
                            $img[$k2]['showname'] = substr($v2, strrpos ($v2, '.') + 1);
                            $img[$k2]['name'] = substr(str_replace(strstr($v2, '.'), '', $v2), strrpos($v2, '/') + 1); // 替换法截取
                            $img[$k2]['check_id'] = $is_check_id;
                        }
            
                        // 新增图片记录
                        $photo->addImgInfo($img);
                   }
                }
                $proResult = $checkPro->resetPro($resetPro); // 更新问题详情记录表
                
                // 判断穿透更新问题记录成功与否
                if ($proResult !== false) {
                    // return $this->success('提交成功，返回首页，稍安毋躁。', 'mobile/index/index');
                    echo json_encode(1);exit; // 成功返回1，跳到可视化房间选择页
                } else {
                    // return $this->error('出了一点小状况。');
                    echo json_encode(0);exit;
                }
           } else {
               
               // 调用问题记录处理方法，并在该方法中return
               $this->doProInfo($userData);
           }
        }
    }
    
    // 处理问题记录
    public function doProInfo($data)
    {
        $check = model('CheckInfo');
        $checkPro = model('Checkproblem'); // 检查问题记录表模型
        $photo = model('Checkphoto'); // 检查记录照片表模型

        $data['checktime'] = time(); // 添加时间
        
        // 判断是否同一检查员对同一用户的上次检查记录没通过
        $lastStatus = $check->getStatus($data['checkuserid'], $data['cstcode'])['id']; // 取得该条记录id
        if ($lastStatus){ // 上次检查记录审核不通过，更新上次记录再审
            $check->updateCheckInfo($data, $lastStatus); // 更新检查记录表
            
            // 过滤无用数据
            $pro = []; // 问题详情
            $img = []; // 照片记录
            foreach ($data as $k => $v){
                if (is_array($v)){
                    if ($k !== 'image'){ // 根据key排除图片数据，拼装问题记录数据
                        $v['check_id'] = $lastStatus;
                        $pro[] = $v;
                    } else {
                        foreach ($v as $k2 => $v2){
                            $img[$k2]['url'] = str_replace(strrchr($v2, '.'), '', $v2);
                            $img[$k2]['showname'] = substr($v2, strrpos ($v2, '.') + 1);
                            $img[$k2]['name'] = substr(str_replace(strstr($v2, '.'), '', $v2), strrpos($v2, '/') + 1); // 替换法截取
                            $img[$k2]['check_id'] = $lastStatus;
                        }
            
                        // 新增图片记录
                        $photo->addImgInfo($img);
                    }
                }
            }
            
            // 更新问题记录详情，求审核通过
            $result = $checkPro->updateProLog($pro);
        }else {
            $check_id = $check->addCheckInfo($data); // 新增检查记录并返回自增id
            
            // 同上
            $pro = []; // 问题详情
            $img = []; // 照片记录
            foreach ($data as $k => $v){
                if (is_array($v)){
                    if ($k !== 'image'){ // 根据key排除图片数据，拼装问题记录数据
                        $v['check_id'] = $check_id;
                        $pro[] = $v;
                    } else {
                        foreach ($v as $k2 => $v2){
                            $img[$k2]['url'] = str_replace(strrchr($v2, '.'), '', $v2);
                            $img[$k2]['showname'] = substr($v2, strrpos ($v2, '.') + 1);
                            $img[$k2]['name'] = substr(str_replace(strstr($v2, '.'), '', $v2), strrpos($v2, '/') + 1); // 替换法截取
                            $img[$k2]['check_id'] = $check_id;
                        }

                        // 新增图片记录
                        $photo->addImgInfo($img);
                    }
                }
            }
            
            // 新增问题记录详情
            $result = $checkPro->inputProLog($pro); // 模型层已过滤非数据表字段
        }
        
//         p($data);
        // 判断添加问题记录成功与否
        if ($result !== false) {
            echo json_encode(1);exit; // 成功返回1，跳到可视化房间选择页
            // return $this->success('提交成功，返回首页，稍安毋躁。', 'mobile/index/index');
        } else {
            echo json_encode(0);exit;
            // return $this->error('出了一点小状况。');
        }
    }
    
    // 处理图片记录
    public function doImg()
    {
//         p($_FILES);
        /* $fileName = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];
        $size = $_FILES['image']['size'];
        $path = ROOT_PATH . 'public' . DS . 'mobile' . DS . 'uploads' . DS . $fileName;
        $path = str_replace('\\', '/', $path);
        move_uploaded_file($tmp_name, $path); */
        // fuck img
        // 获取表单上传文件
        $files = request()->file('image');
        $imgSaveUrl = [];
        foreach($files as $k => $file){
            
            // 移动uploads目录下
//             $info = $file->rule('uniqid')->move(ROOT_PATH . 'public/mobile/uploads/' . date('Y-m-d', time()) . '/');
            $info = $file->move(ROOT_PATH . 'public/mobile/uploads/');
//             p($info);
//                 $info = $file->move('/public/mobile/uploads/');
            if($info){
//                 $imgSaveInfo[$k]['url'] = str_replace('\\', '/', '/public/mobile' . DS . 'uploads'. DS . $info->getSaveName());
                $fileName = str_replace(strrchr($_FILES['image']['name'][$k], '.'), '', $_FILES['image']['name'][$k]); // strrchr返回'.'最后一次出现位置并替换为空
                $imgSaveUrl[]['url'] = str_replace('\\', '/', '/public/mobile/uploads/' . $info->getSaveName()) . '.' . $fileName;
            } else {
                
                // 上传失败获取错误信息
                echo $file->getError();exit;
            }
        }
        echo json_encode($imgSaveUrl);exit;
    }
    
    // 删除图片以及图片信息
    public function deleteImg()
    {
        $photo = model('Checkphoto'); // 检查记录照片表模型
        $url = input('get.nowImgUrl');
        $result = $photo->deleteImg($url);
        echo $result;exit;
    }
    
    // 历史记录
    public function history()
    {
        $check = model('CheckInfo');
        
        $cstcode = input('get.cstcode'); // 考虑到用户编号可能含字母，不强制转整型
        $log = $check->getCheckLog($cstcode); // 房间历史记录
//         p($log);
        echo json_encode($log);
    }
}