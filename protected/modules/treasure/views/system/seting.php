<?php
    $this->page_title = $systemcat_info->systemcat_name.'设置';
    $this->page_desc = $systemcat_info->systemcat_desc;
    $this->css = array('assets/bootstrap-fileupload/bootstrap-fileupload','assets/bootstrap-switch/static/stylesheets/bootstrap-switch');
    $this->js = array('assets/bootstrap-fileupload/bootstrap-fileupload.min');
?>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><i class="icon-reorder"></i> <?php echo $systemcat_info->systemcat_name; ?>设置</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="icon-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <?php $form = $this->beginWidget('CActiveForm',array(
                    'htmlOptions'=>array(
                        'class'=>'form-horizontal',
                        'enctype'=>'multipart/form-data',
                    ),
                )); ?>
                <?php foreach($seting_list as $k => $v){ ?>
                    <?php 
                        $input_value = Inputtype::getinput($v->input_type);
                        $input_value = str_replace('{ly}field_name{ly}', $v->system_name, $input_value);
                        $input_value = str_replace('{ly}field_value{ly}', $v->system_value, $input_value);
                        $input_value = str_replace('{ly}post_name{ly}', $v->systemcat->systemcat_alias, $input_value);
                        $input_value = str_replace('{ly}field_alias{ly}', $v->system_alias, $input_value);
                        $input_value = str_replace('{ly}field_desc{ly}', $v->system_desc, $input_value);
                        if(preg_match('/{lc:select}{ly}/', $input_value)){
                            $data = json_decode($v->data);
                            if(!empty($data)){
                                $options_html = null;
                                foreach($data as $a => $b){
                                    if($a == $v->system_value){
                                        $options_html .= '<option value="'.$a.'" selected=true>'.$b.'</option>';
                                    }else{
                                        $options_html .= '<option value="'.$a.'">'.$b.'</option>';
                                    }
                                }
                                $input_value = str_replace('{lc:select}{ly}', $options_html, $input_value);
                            }
                        }
                        if(preg_match('/{lc:radio}{ly}/', $input_value)){
                            $data = json_decode($v->data);
                            if(!empty($data)){
                                $radio_html = null;
                                foreach($data as $a => $b){
                                    if($a == $v->system_value){
                                        $radio_html .= '<label class="radio inline">';
                                        $radio_html .= '<input type="radio" checked=true name="'.$v->systemcat->systemcat_alias.'['.$v->system_alias.']" value="'.$a.'"> '.$b;
                                        $radio_html .= '</label>';
                                    }else{
                                        $radio_html .= '<label class="radio inline">';
                                        $radio_html .= '<input type="radio" name="'.$v->systemcat->systemcat_alias.'['.$v->system_alias.']" value="'.$a.'"> '.$b;
                                        $radio_html .= '</label>';
                                    }
                                }
                                $input_value = str_replace('{lc:radio}{ly}', $radio_html, $input_value);
                            }
                        }
                        if(preg_match('/{lc:checkbox}{ly}/', $input_value)){
                            $v->system_value = json_decode($v->system_value);
                            $data = json_decode($v->data);
                            if(!empty($data)){
                                $checkbox_html = null;
                                foreach($data as $a => $b){
                                    $ischecked = 0;
                                    if(!empty($v->system_value)){
                                        foreach($v->system_value as $c => $d){
                                            if($a == $d){
                                                $ischecked = 1;
                                            }
                                        }
                                    }
                                    $checkbox_html .= '<label class="checkbox inline">';
                                    $checkbox_html .= '<input type="checkbox" '.($ischecked?'checked=true':'').' name="'.$v->systemcat->systemcat_alias.'['.$v->system_alias.'][]" value="'.$a.'"> '.$b;
                                    $checkbox_html .= '</label>';
                                }
                                $input_value = str_replace('{lc:checkbox}{ly}', $checkbox_html, $input_value);
                            }
                        }
                        if(preg_match('/{lc:fileimg}{ly}/', $input_value)){
                            $imgpath = null;
                            if(!empty($v->system_value)){
                                $imgpath = SITE_UPLOAD.'servers/'.$v->system_value;
                            }else{
                                $imgpath = "http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";
                            }
                            $input_value = str_replace('{lc:fileimg}{ly}', $imgpath, $input_value);
                        }
                        echo $input_value;
                    ?>
                <?php } ?>
                    
                    




                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="提交">
                        <button type="reset" class="btn">重置</button>
                    </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
                </div>