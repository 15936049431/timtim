//Created by Action Script Viewer - http://www.buraks.com/asv
package view.ui {
    import flash.display.*;

    public class Flag extends Sprite {

        private var _width:Number;
        private var _height:Number;

        public function Flag(_arg1:Number=6, _arg2:Number=6){
            this._width = _arg1;
            this._height = _arg2;
            this.init();
        }
        private function init():void{
            var _local1:Number = (-((this._width = (this._width + 1))) * 0.5);
            var _local2:Number = (-((this._height = (this._height + 1))) * 0.5);
            this.graphics.lineStyle(1, 0xEEEEEE);
            this.graphics.beginFill(0x333333, 0.5);
            this.graphics.drawRect(_local1, _local2, this._width, this._height);
            this.graphics.endFill();
        }

    }
}//package view.ui 
