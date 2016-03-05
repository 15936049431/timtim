//Created by Action Script Viewer - http://www.buraks.com/asv
package model {
    import flash.events.*;
    import events.*;
    import flash.display.*;
    import flash.utils.*;
    import flash.net.*;
    import flash.system.*;

    public class AvatarModel extends EventDispatcher {

        private var _bmd:BitmapData;
        private var _type:int;// = 2
        private var _imgData:ByteArray;

        public function set bmd(_arg1:BitmapData):void{
            this._bmd = _arg1;
            this.dispatchEvent(new UploadEvent(UploadEvent.IMAGE_CHANGE));
        }
        public function set initBmd(_arg1:BitmapData):void{
            this._bmd = _arg1;
            this.dispatchEvent(new UploadEvent(UploadEvent.IMAGE_INIT));
        }
        public function get bmd():BitmapData{
            return (this._bmd);
        }
        public function get type():int{
            return (this._type);
        }
        public function set type(_arg1:int):void{
            this._type = _arg1;
        }
        public function get imgData():ByteArray{
            return (this._imgData);
        }
        public function set imgData(_arg1:ByteArray):void{
            this._imgData = _arg1;
        }
        public function loaderPic(_arg1:String):void{
            var _local2:URLRequest = new URLRequest(_arg1);
            var _local3:Loader = new Loader();
            var _local4:LoaderContext = new LoaderContext(true);
            _local3.contentLoaderInfo.addEventListener(Event.COMPLETE, this.initPicHandler);
            _local3.contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR, this.errorHandler);
            _local3.load(_local2, _local4);
        }
        private function initPicHandler(_arg1:Event):void{
            var _local2:LoaderInfo = (_arg1.target as LoaderInfo);
            _local2.removeEventListener(Event.COMPLETE, this.initPicHandler);
            _local2.removeEventListener(IOErrorEvent.IO_ERROR, this.errorHandler);
            var _local3:Loader = new Loader();
            _local3.contentLoaderInfo.addEventListener(Event.COMPLETE, this.initBMD);
            _local3.loadBytes(_local2.bytes);
        }
        private function initBMD(_arg1:Event):void{
            var _local2:LoaderInfo = (_arg1.target as LoaderInfo);
            _local2.removeEventListener(Event.COMPLETE, this.initBMD);
            var _local3:Loader = (_local2.loader as Loader);
            var _local4:BitmapData = new BitmapData(_local3.width, _local3.height);
            _local4.draw(_local3);
            this.initBmd = _local4;
            _local3.unload();
        }
        private function errorHandler(_arg1:IOErrorEvent):void{
        }

    }
}//package model 
