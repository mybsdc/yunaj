<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:35:"app/home\view\audit_check\test.html";i:1498472285;}*/ ?>
<div class="table-responsive">
    <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>序号</th>
                <th>地址</th>
                <th>房号</th>
                <th>用户编号</th>
                <th>姓名</th>
                <th>联系电话</th>
                <th>气表类型</th>
                <th>品牌</th>
                <th>进气方向</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            <?php if(is_array($listData) || $listData instanceof \think\Collection || $listData instanceof \think\Paginator): $i = 0; $__LIST__ = $listData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr class="<?php echo $vo['id']; ?>">
                <td class="center">
                    <?php echo $vo['id']; ?>
                </td>
                <td><?php echo $vo['areaName']; ?><?php echo $vo['xqName']; ?></td>
                <td><?php echo $vo['dong']; ?><?php echo $vo['unit']; ?>单元<?php echo $vo['room']; ?></td>
                <td><?php echo $vo['cstcode']; ?></td>
                <td><?php echo $vo['cstname']; ?></td>
                <td class="hidden-480">
                    <?php echo $vo['telphone']; ?>
                </td>
                <td class="hidden-480">
                    <?php echo $vo['typeName']; ?>
                </td>
                <td class="hidden-480">
                    <?php echo $vo['brandName']; ?>
                </td>
                <td class="hidden-480">
                    <?php echo $vo['direction']; ?>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <tr style="background-color: #f5f5f5;">
                <td></td>
                <td colspan="10">
                    <button class="icon-cloud-download" style="background-color: #17a3ff;color: #FFF;border-style: none ;padding: 5px 10px;float: right;margin-left: 1%;cursor: pointer">
                        导出数据
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="padding-top:10px ;background-color: #f0f3f8;width: 100%;height: 50px">
        <div class="col-sm-4">
                <div class="dataTables_info" id="sample-table-2_info">
                    当前
                    <?php if($pageCount == 0): ?>
                    0
                    <?php else: ?>
                    <?php echo $page; endif; ?>
                    /
                    <?php if($pageCount == ''): ?>
                    0
                    <?php else: ?>
                    <?php echo $pageCount; endif; ?>
                    页，共
                    <?php if($count == ''): ?>
                    0
                    <?php else: ?>
                    <?php echo $count; endif; ?>
                    条
                </div>
            </div>
        <div class="col-sm-8">
            <div class="dataTables_paginate paging_bootstrap">
                <ul class="pagination" id="userPageU1">
                    <li><a href="#">首页</a></li>
                    <li><a href="#">上一页</a></li>
                    <?php $__FOR_START_3203__=1;$__FOR_END_3203__=$pageCount+1;for($i=$__FOR_START_3203__;$i < $__FOR_END_3203__;$i+=1){ ?>
                    <li><a href="#"><?php echo $i; ?></a></li>
                    <?php } ?>
                    <li><a href="#">下一页</a></li>
                    <li><a href="#">尾页</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--  <div class="row" style="background-color: #f0f3f8; line-height: 70px;">
        <div class="col-sm-4">
            <div class="dataTables_info" id="sample-table-2_info">
                第&nbsp;0&nbsp;/&nbsp;0&nbsp;页，共&nbsp;0&nbsp;条
            </div>
        </div>
        <div class="col-sm-8">
            <div class="dataTables_paginate paging_bootstrap">
				<div id="layer-pages"></div>
            </div>
        </div>
    </div> -->
</div>
