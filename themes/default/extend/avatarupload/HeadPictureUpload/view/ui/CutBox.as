﻿//Created by Action Script Viewer - http://www.buraks.com/asv
package view.ui {
    import flash.display.*;
    import view.*;

    public class CutBox extends Sprite {

        private var swfStage:Stage;
        private var _w:Number;
        private var _h:Number;
        public var cutArea:Sprite;
        public var maskArea:Sprite;
        public var flag:Flag;
        public var flagVY:Number;
        public var flagVX:Number;
        public var flagCurX:Number;
        public var flagCurY:Number;
        public var _cutView:CutView;

        public function CutBox(_arg1:Number=180, _arg2:Number=180){
            this.init(_arg1, _arg2);
        }
        public function init(_arg1:Number, _arg2:Number):void{
            this._w = _arg1;
            this._h = _arg2;
            this.maskArea = new Sprite();
            this.cutArea = new Sprite();
            this.flag = new Flag();
            this.maskArea.graphics.clear();
            this.maskArea.graphics.beginFill(0, 0);
            this.maskArea.graphics.drawRect(0, 0, this._w, this._h);
            this.maskArea.graphics.endFill();
            this.cutArea.graphics.clear();
            this.cutArea.graphics.beginFill(0, 0);
            this.cutArea.graphics.drawRect(0, 0, this._w, this._h);
            this.cutArea.graphics.endFill();
            this.flag.x = this._w;
            this.flag.y = this._h;
            addChild(this.maskArea);
            addChild(this.cutArea);
            addChild(this.flag);
        }
        public function get w():Number{
            return (this._w);
        }
        public function get h():Number{
            return (this._h);
        }

    }
}//package view.ui 
