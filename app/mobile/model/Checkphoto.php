<?php
/**
 * 该模型对应yunaj_checkphoto表
 * 
 */

namespace app\mobile\model;

use think\Model;

class Checkphoto extends Model
{
    protected $table = 'yunaj_checkphoto'; // 最好指定下表明，防止命名不规范不能识别之情况
    
    /**
     * 添加图片记录信息
     * @param array $imgData 已经封装好的数组
     * @return Object saveAll方法返回对象
     * 
     */
    public function addImgInfo($imgData)
    {
        return $this->saveAll($imgData);
    }
    
    /**
     * 更新图片记录信息
     * @param array $data 已经封装好的数组
     * @return int 影响条数
     *
     */
    public function updateImgInfo($data)
    {
        
    }
    
    
    /**
     * 删除图片以及图片信息
     * @param $url 图片路径
     * @return bool
     * 
     */
    public function deleteImg($url)
    {
        $this->where('url',$url)->delete(); // url是唯一的，删除数据表中信息
        $url = substr($url, 1); // 去除首个“/”，表示与index.php同级目录unlink，若要删上级目录下内容，就../
        if (!file_exists($url)){ // 判断是否存在
            return '图片不存在';
        }
        if(!unlink($url)){ // 删除文件
            return '删除失败';
        } else {
            return 1;
        }
    }
    
    /**
     * 穿透查询获取图片地址
     * @param int $check_id 检查记录ID
     * @return array
     * 
     */
    public function getImgUrl($check_id)
    {
        return db('checkphoto')->field('url')->where(['check_id' => $check_id])->select(); // $this返回对象，故返回数组用db助手函数吧        
    }
}