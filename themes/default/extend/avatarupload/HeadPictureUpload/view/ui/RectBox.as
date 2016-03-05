//Created by Action Script Viewer - http://www.buraks.com/asv
package view.ui {
    import flash.display.*;

    public class RectBox extends Sprite {

        private var _w:Number;
        private var _h:Number;
        private var _borderColor:uint;
        private var _borderWidth:Number;

        public function RectBox(_arg1:Number, _arg2:Number, _arg3:uint=0xB2B2B2, _arg4:Number=1){
            this._w = (_arg1 + _arg4);
            this._h = (_arg2 + _arg4);
            this._borderColor = _arg3;
            this._borderWidth = _arg4;
            this.mouseEnabled = false;
            this.mouseChildren = false;
            this.init();
        }
        private function init():void{
            this.graphics.lineStyle(this._borderWidth, this._borderColor);
            this.graphics.lineTo(this._w, 0);
            this.graphics.lineTo(this._w, this._h);
            this.graphics.lineTo(0, this._h);
            this.graphics.lineTo(0, 0);
        }

    }
}//package view.ui 
