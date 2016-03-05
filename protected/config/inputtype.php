<?php
    class Inputtype{
        public static function getinput($type=0){
            if(empty($type)){
                return false;
            }
            $typelist =  array(
                '1'=>'
                    <div class="control-group">
                        <label class="control-label required" for="{ly}post_name{ly}_{ly}field_alias{ly}">{ly}field_name{ly}</label>
                        <div class="controls">
                                <input class="input-xlarge" placeholder="请输入{ly}field_name{ly}" name="{ly}post_name{ly}[{ly}field_alias{ly}]" id="{ly}post_name{ly}_{ly}field_alias{ly}" type="text" value="{ly}field_value{ly}" maxlength="32">
                                <span class="help-inline">{ly}field_desc{ly}</span>
                        </div>
                    </div>',//短文本框
                '2'=>'<div class="control-group">
                        <label class="control-label required" for="{ly}post_name{ly}_{ly}field_alias{ly}">{ly}field_name{ly}</label>
                        <div class="controls">
                            <textarea class="span4" rows="5" name="{ly}post_name{ly}[{ly}field_alias{ly}]" id="{ly}post_name{ly}_{ly}field_alias{ly}">{ly}field_value{ly}</textarea>
                            <span class="help-inline">{ly}field_desc{ly}</span>
                        </div>
                      </div>', //文本域
                '3'=>'<div class="control-group">
                        <label class="control-label" for="{ly}post_name{ly}_{ly}field_alias{ly}">{ly}field_name{ly}</label>
                        <div class="controls">
                            <select class="input-xlarge" name="{ly}post_name{ly}[{ly}field_alias{ly}]" id="{ly}post_name{ly}_{ly}field_alias{ly}">
                                {lc:select}{ly}
                            </select>
                            <span class="help-inline">{ly}field_desc{ly}</span>
                        </div>
                    </div>',//下拉框
                '4'=>'<div class="control-group">
                        <label class="control-label">{ly}field_name{ly}</label>
                        <div class="controls">
                            {lc:radio}{ly}
                        </div>
                      </div>',//单选框
                '5'=>'<div class="control-group">
                        <label class="control-label">{ly}field_name{ly}</label>
                        <div class="controls">
                            {lc:checkbox}{ly}
                        </div>
                      </div>',//复选框
                '6'=>'<div class="control-group">
                        <label class="control-label required" for="{ly}post_name{ly}_{ly}field_alias{ly}">{ly}field_name{ly}</label>
                        <div class="controls">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="{lc:fileimg}{ly}" alt="">
                            </div>
                            <div class="fileupload fileupload-new" data-provides="fileupload" style="margin-top:10px;">
                                <div class="input-append">
                                   <div class="uneditable-input">
                                        <i class="icon-file fileupload-exists"></i> 
                                        <span class="fileupload-preview"></span>
                                   </div>
                                   <span class="btn btn-file">
                                        <span class="fileupload-new">选择文件</span>
                                        <span class="fileupload-exists">更换</span>
                                        <input type="file" name="{ly}post_name{ly}[{ly}field_alias{ly}]" id="{ly}post_name{ly}_{ly}field_alias{ly}" class="default">
                                        <input type="hidden" name="{ly}post_name{ly}[{ly}field_alias{ly}][hidden]" value="{ly}field_value{ly}">
                                   </span>
                                   <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">删除</a>
                                </div>
                                <span class="help-inline">{ly}field_desc{ly}</span>
                            </div>
                        </div>
                      </div>',//上传类型
                
            );
            if(isset($typelist[intval($type)])){
                return $typelist[intval($type)];
            }else{
                return '没有此控件类型';
            }
        }
        
    }