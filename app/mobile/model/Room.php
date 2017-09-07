<?php
/**
 * 该模型对应yunaj_room表
 * 
 */

namespace app\mobile\model;

use think\Model;
use think\db\Query;
// use function think\where; 这个是编辑器自作聪明加的，服务器端会报错，先注释

class Room extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'yunaj_room'; // 实际上遵循规范会自动对应，无需此步
    
    /**
     * 获取所有楼层以及对应的房间
     * @param int $proj_id 小区/项目id
     * @param int $bld_id 楼栋id
     * @param int $unit 单元
     * return array
     * 
     */
    public function getRoomList($proj_id, $bld_id, $unit)
    {
        $where = ['proj_id' => $proj_id, 'bld_id' => $bld_id, 'unit' => $unit]; // 楼层条件
        $floorData = db('room')->group('floor')->field('floor')->where($where)->order('floor desc')->select(); // 所有楼层，数据去重
        foreach ($floorData as $k => $v){
            $whereRoom = array_merge($where, $v); // 房间条件
            $room = db('room')->where($whereRoom)->order('room desc')->select();
            $roomList[$v['floor']] = $room; // 该楼层下的所有房间
        }
        
        // $myRoom = db()->query('SELECT floor, GROUP_CONCAT(r.room) rooms FROM yunaj_room r JOIN yunaj_project p ON r.proj_id = p.id JOIN yunaj_build b ON b.id = r.bld_id WHERE p.id = 1 AND b.code = 8 AND r.unit = 17 GROUP BY floor');
        // p($myRoom);
        return $roomList;
    }
    
    /**
     * 获取小区内所有的单元与栋信息
     * @param int $xq_id 小区id
     * return array 拼接后的栋单元数组
     * 
     */
    public function getXqDongDy($xq_id)
    {
        $dongData = db('room')->group('bld_id')->field('bld_id')->where(['proj_id' => $xq_id])->order('bld_id desc')->select(); // 该小区下所有栋
        $dongDyList = []; // 定义下，防止报错
        foreach ($dongData as $k => $v){
            $whereDy = array_merge(['proj_id' => $xq_id], $v);
            $dy = db('room')->group('unit')->field('unit')->where($whereDy)->order('unit asc')->select(); // 该栋下所有单元
            $dong = db('build')->where(['id' => $v['bld_id']])->find(); // 栋id对应的真实栋
            
            foreach ($dy as $key => $value){
                $dongDyList[] = array_merge($dong, $value); // 拼接栋单元数组
            }
        }
        return $dongDyList;
    }
    
    /**
     * 拼接小区名栋名单元名
     * @param int $proj_id 小区/项目id
     * @param int $bld_id 楼栋id
     * @param int $unit 单元
     * return array
     * 
     */
    public function getName($proj_id, $bld_id, $unit)
    {
        // $isName = db()->query("SELECT p.name FROM yunaj_project p JOIN yunaj_build b ON p.id = b.proj_id WHERE b.id = $bld_id");
        $isName['proj'] = db('project')->where(['id' => $proj_id])->find()['name'];
        $isName['bld'] = db('build')->where(['id' => $bld_id])->find()['code'];
        $isName['unit'] = $unit;
        return $isName;
    }
    
    /**
     * 获取房间入户登记信息
     * @param int $cstcode 客户编号
     * return array
     * 
     */
    public function getRoomInfo($cstcode)
    {
        // 关联查询，区域小区栋单元用户信息
        $roomInfo = db()->query("SELECT x.name area, x.id xzqy_id, p.name xq, p.id xq_id, b.code, b.id bldID, r.id, r.unit, r.room, r.cstcode, r.basenumber, r.type, r.brand, r.direction, r.cstname, r.telphone, r.floor, r.no FROM yunaj_room r JOIN yunaj_build b ON r.bld_id = b.id JOIN yunaj_project p ON b.proj_id = p.id JOIN yunaj_xzqy x ON x.id = p.xzqy_id WHERE r.cstcode = '$cstcode'"); // where条件中的值最好用引号括起来，否则若传入字符串就会报错
//         p($roomInfo);
        /* $roomInfo[0]['typeCN'] = db('csdetail')->where(['id' => $roomInfo[0]['type']])->find()['name'];
        $roomInfo[0]['brandCN'] = db('csdetail')->where(['id' => $roomInfo[0]['brand']])->find()['name']; */
        if (empty($roomInfo[0])){
            return false; // 查无数据，新增模式
        }
        return $roomInfo[0];
    }
    
    /**
     * 判断该编号客户是否存在
     * @param int $cstcode 客户编号
     * return array
     *
     */
    public function haveUser($cstcode)
    {
        // $cstcode = (int)$cstcode; // 强制转为整型  // 考虑到编号可能出现英文，不转了
        return db('room')->where(['cstcode' => $cstcode])->find();
    }
    
    /**
     * 新增房间信息
     * @param mixed $data 房间各种信息数据
     * return int 新增主键id
     * 调用自建模型层不易过滤无用字段，故直接在控制器调用tp自带模型。此方法弃用。ps:直接$this调用即可。
     *
     */
    /* public function addUser($data)
    {
        //return $this->insertGetId($data);
    } */
    
    /**
     * 更新房间详细地址信息
     * @param int $cstcode 客户编号
     * @param array $data 最新客户房间信息
     * return int 影响条数
     * save(数据，条件) 根据官方文档，只有这种写法才能使allowField生效
     * 该方法只处理详细地址相关的字段，包括：小区项目、楼栋、单元、房号，详细地址中的区(镇)在控制器的其它方法中已处理
     * 
     */
    public function updateRoom($cstcode, $data)
    {
        return $this->allowField(['proj_id', 'bld_id', 'unit', 'floor', 'no', 'room', 'is_change'])->save($data, ['cstcode' => $data['cstcode']]);
    }
    
    /**
     * 判断房间详细地址是否被修改
     * @param int $cstcode 客户编号
     * @param array $where 构造查询条件
     * return int array
     * 
     */
    public function checkAddressInfo($cstcode, $where)
    {
        return $this->where($where)->find();
    }
}