﻿//Created by Action Script Viewer - http://www.buraks.com/asv
package view.checkBox {
    import flash.events.*;
    import model.*;
    import flash.display.*;
    import flash.text.*;
    import utils.*;

    public class CheckBoxLabel extends Sprite {

        private var _checkbox:MovieClip;
        private var _tf:TextField;
        public var needSourcePic:Boolean;// = true

        public function CheckBoxLabel(){
			this.needSourcePic = false;
            /*this._checkbox = (new SK_CheckBox() as MovieClip);
            this._checkbox.gotoAndStop(3);
            this._checkbox.addEventListener(MouseEvent.MOUSE_OVER, this.onCheckboxMouseOver);
            this._checkbox.addEventListener(MouseEvent.MOUSE_OUT, this.onCheckboxMouseOut);
            this._checkbox.addEventListener(MouseEvent.CLICK, this.onCheckboxClicked);
            addChild(this._checkbox);
            var _local1 = "p{color:#666666;} a{color:#0363a0;} a:hover{color:#0b5f8e;} a:active{color:#0b5f8e}";
            var _local2:StyleSheet = new StyleSheet();
            _local2.parseCSS(_local1);
            this._tf = new TextField();
            this._tf.selectable = false;
            this._tf.mouseWheelEnabled = false;
            this._tf.autoSize = TextFieldAutoSize.LEFT;
            this._tf.x = 18;
            this._tf.y = -3;
            this._tf.styleSheet = _local2;
            this._tf.htmlText = "<p>上传原始图片，在 <a href=\"event:0\">头像相册</a> 中显示</p>";
            this._tf.addEventListener(TextEvent.LINK, this.onTextEvent);
            addChild(this._tf);*/
        }
        private function onCheckboxMouseOut(_arg1:MouseEvent):void{
            if (this._checkbox.currentFrame == 3){
                return;
            };
            this._checkbox.gotoAndStop(1);
        }
        private function onCheckboxClicked(_arg1:MouseEvent):void{
            if (this._checkbox.currentFrame == 3){
                this._checkbox.gotoAndStop(1);
                this.needSourcePic = false;
            } else {
                this.needSourcePic = true;
                this._checkbox.gotoAndStop(3);
            };
        }
        private function onCheckboxMouseOver(_arg1:MouseEvent):void{
            if (this._checkbox.currentFrame == 3){
                return;
            };
            this._checkbox.gotoAndStop(2);
        }
        private function onTextEvent(_arg1:TextEvent):void{
            NavigateUtils.openURL(Param.albumURL);
        }

    }
}//package view.checkBox 
