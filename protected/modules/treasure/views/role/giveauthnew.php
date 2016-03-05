<?php
    $this->page_title = '角色授权';
    $this->page_desc = $authitem->name.'授权';
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 角色分配</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                
                <div class="control-group">
                    <label class="control-label">角色</label>
                    <div class="controls">
                       <label class="checkbox inline">
                          <input type="checkbox" value=""> 平台编辑
                       </label>
                       <label class="checkbox inline">
                          <input type="checkbox" value=""> 客服人员
                       </label>
                    </div>
                 </div>
                
                
            </div>
        </div>
        
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> 详细分配</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                
                <div class="control-group">
                    <label class="control-label">文章管理</label>
                    <div class="controls">
                       <label class="checkbox inline">
                          <input type="checkbox" value=""> 文章编辑
                       </label>
                       <label class="checkbox inline">
                          <input type="checkbox" value=""> 文章发布
                       </label>
                       <label class="checkbox inline">
                          <input type="checkbox" value=""> 文章查看
                       </label>
                    </div>
                 </div>
                
                <div class="control-group">
                    <label class="control-label">友链管理</label>
                    <div class="controls">
                       <label class="checkbox inline">
                          <input type="checkbox" value=""> 友链编辑
                       </label>
                       <label class="checkbox inline">
                          <input type="checkbox" value=""> 友链发布
                       </label>
                       <label class="checkbox inline">
                          <input type="checkbox" value=""> 友链查看
                       </label>
                       <label class="checkbox inline">
                          <input type="checkbox" value=""> 友链删除
                       </label>
                    </div>
                 </div>
                
            </div>
        </div>
    </div>
</div>