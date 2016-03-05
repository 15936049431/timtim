//Created by Action Script Viewer - http://www.buraks.com/asv
package view {
    import flash.events.*;
    import model.*;
    import events.*;
    import flash.display.*;
    import flash.utils.*;
    import com.adobe.images.*;
    import com.adobe.serialization.json.*;
    import view.avatar.*;
    import view.localpic.*;
    import view.camera.*;
    import view.browse.*;
    import view.checkBox.*;
    import flash.net.*;
    import flash.external.*;
    import flash.geom.*;

    public class CutView extends Sprite {

        private var _loadingPanel:Sprite;
        private var _avatarAreaMove:Boolean;// = true
        private var _sourcePID:String;// = ""
        public var avatarModel:AvatarModel;
        public var splitLines:Shape;
        public var avatarArea:AvatarArea;
        public var localPicArea:LocalPicArea;
        public var cameraArea:CameraComp;
        public var browseComp:BrowseComp;
        public var cameraBtn:MovieClip;
        public var saveBtn:SK_Save;
        public var cancleBtn:SK_Cancel;
        public var checkBox:CheckBoxLabel;

        public function CutView(_arg1:AvatarModel){
            this.avatarModel = _arg1;
            if (stage){
                this.init();
            } else {
                addEventListener(Event.ADDED_TO_STAGE, this.init);
            };
        }
        private function init(_arg1:Event=null):void{
            removeEventListener(Event.ADDED_TO_STAGE, this.init);
            var _local2:Main = (this.parent as Main);
            this.splitLines = new Shape();
            this.splitLines.graphics.lineStyle(1, 0xE5E5E5);
            this.splitLines.graphics.lineTo(0, 310);
            this.splitLines.x = 349.5;
            this.splitLines.y = 90;
            this.browseComp = new BrowseComp(this.avatarModel);
            this.browseComp.x = 20;
            this.browseComp.y = 5;
            this.checkBox = new CheckBoxLabel();
            this.checkBox.x = 20;
            this.checkBox.y = 68;
            this.cameraBtn = (new SK_Camera() as MovieClip);
            this.cameraBtn.x = 155;
            this.cameraBtn.y = 5;
            this.cameraBtn.buttonMode = true;
            this.cameraBtnAddEvents();
            this.avatarArea = new AvatarArea();
            this.avatarArea.y = 94;
            this.avatarArea.x = 360;
            this.localPicArea = new LocalPicArea();
            this.localPicArea.x = 20;
            this.localPicArea.y = 100;
            addChild(this.localPicArea);
            this.avatarModel.addEventListener(UploadEvent.IMAGE_CHANGE, this.changeAvatars);
            this.avatarModel.addEventListener(UploadEvent.IMAGE_INIT, this.initAvatars);
            var _local3:Number = 700;
            var _local4:Number = 500;
            this._loadingPanel = new Sprite();
            this._loadingPanel.graphics.beginFill(0, 0.4);
            this._loadingPanel.graphics.drawRect(0, 0, _local3, _local4);
            this._loadingPanel.graphics.endFill();
            var _local5:MovieClip = (new SK_Loading() as MovieClip);
            _local5.mouseEnabled = false;
            _local5.x = ((_local3 - _local5.width) * 0.5);
            _local5.y = ((_local4 - _local5.height) * 0.5);
            this._loadingPanel.addChild(_local5);
            this._loadingPanel.mouseChildren = false;
            addChild(this.splitLines);
            addChild(this.browseComp);
            addChild(this.checkBox);
            addChild(this.avatarArea);
            addChild(this.cameraBtn);
        }
        public function cameraBtnAddEvents():void{
            this.cameraBtn.addEventListener(MouseEvent.MOUSE_OVER, this.changeCameraBtnStatus);
            this.cameraBtn.addEventListener(MouseEvent.MOUSE_OUT, this.changeCameraBtnStatus);
            this.cameraBtn.addEventListener(MouseEvent.CLICK, this.showCameraArea);
        }
        private function cameraBtnRemoveEvents():void{
            this.cameraBtn.removeEventListener(MouseEvent.MOUSE_OUT, this.changeCameraBtnStatus);
            this.cameraBtn.removeEventListener(MouseEvent.MOUSE_OVER, this.changeCameraBtnStatus);
            this.cameraBtn.removeEventListener(MouseEvent.CLICK, this.showCameraArea);
        }
        private function changeAvatars(_arg1:UploadEvent):void{
            this.addSaveBtns();
            this.localPicArea.loaddingUI.visible = false;
            if (((!((this.cameraArea == null))) && ((this.cameraArea.visible == true)))){
                this.cameraArea.visible = false;
                this.cameraBtn.mouseEnabled = true;
                this.cameraBtn.gotoAndStop(1);
                this.cameraBtnAddEvents();
            };
            this.localPicArea.visible = true;
            this.localPicArea.setLocalPicSize(this.avatarModel.bmd);
        }
        private function initAvatars(_arg1:UploadEvent):void{
            this.avatarArea.initAvatars(this.avatarModel.bmd);
        }
        private function changeCameraBtnStatus(_arg1:MouseEvent):void{
            if (_arg1.type == MouseEvent.MOUSE_OVER){
                this.cameraBtn.gotoAndStop(2);
            } else {
                this.cameraBtn.gotoAndStop(1);
            };
        }
        public function showCameraArea(_arg1:MouseEvent):void{
            this.cameraBtnRemoveEvents();
            this.cameraBtn.mouseEnabled = false;
            this.cameraBtn.gotoAndStop(3);
            this.browseComp.btnBrowse.gotoAndStop(1);
            this.browseComp.btnBrowsAddEvents();
            if (this.cameraArea == null){
                this.cameraArea = new CameraComp(this);
                this.cameraArea.x = 199;
                this.cameraArea.y = 80;
                addChild(this.cameraArea);
            } else {
                if (this.cameraArea.visible == false){
                    this.cameraArea.visible = true;
                };
            };
            this.browseComp.label.visible = false;
            this.checkBox.visible = false;
            this.localPicArea.visible = false;
            this.avatarArea.visible = false;
            this.splitLines.visible = false;
            if (((!((this.saveBtn == null))) && ((this.saveBtn.visible == true)))){
                this.saveBtn.visible = (this.cancleBtn.visible = false);
            };
        }
        public function addSaveBtns():void{
            if (this.saveBtn == null){
                this.saveBtn = new SK_Save();
                this.saveBtn.x = 20;
                this.saveBtn.y = 450;
                this.cancleBtn = new SK_Cancel();
                this.cancleBtn.x = 100;
                this.cancleBtn.y = 450;
                addChild(this.saveBtn);
                addChild(this.cancleBtn);
            };
            this.saveBtn.mouseEnabled = true;
            this.saveBtn.addEventListener(MouseEvent.CLICK, this.updateAvatar);
            this.cancleBtn.addEventListener(MouseEvent.CLICK, this.cancelProgramm);
        }
        public function updateAvatar(_arg1:MouseEvent):void{
            this.saveBtn.mouseEnabled = false;
            this.saveBtn.alpha = 0.5;
            if ((((Param.limited == null)) || ((Param.limited == "1")))){
                if (ExternalInterface.available){
                    ExternalInterface.call(Param.jsFunc, "M01106");
                };
                return;
            };
            if (((!((Param.verifyCode == null))) && ((Param.verifyCode == "4")))){
                if (ExternalInterface.available){
                    ExternalInterface.addCallback("beginUploadAvatar", this.beginUploadAvatar);
                    ExternalInterface.call("App.verifyCode", {cb:"beginUploadAvatar", type:"flash"});
                };
            } else {
                this.beginUploadAvatar();
            };
        }
        private function beginUploadAvatar():void{
            addChild(this._loadingPanel);
            var _local1:Timer = new Timer(300);
            _local1.addEventListener(TimerEvent.TIMER, this.onTimerEvt);
            _local1.start();
        }
        private function onTimerEvt(_arg1:TimerEvent):void{
            var _local2:Timer = (_arg1.target as Timer);
            _local2.removeEventListener(TimerEvent.TIMER, this.onTimerEvt);
            _local2.stop();
            if (this.avatarModel.type == 2){
                if (this.checkBox.needSourcePic){
                    this.uploadSourcePic();
                } else {
                    this.uploadAvatar();
                };
            } else {
                this.uploadAvatar();
            };
        }
        private function uploadSourcePic():void{ 
            var _local1:String = Param.verifycode;
            var _local2:String = ((((Param.sourcePicURL + "?s=json&app=cloudsoft&data=1&mime=image/jpeg&ticket=") + _local1) + "&ct=") + new Date().getTime());
            Param.ticket.shift();
            Param.getTicket();
            var _local3:ByteArray = this.avatarModel.imgData;
            var _local4:URLRequestHeader = new URLRequestHeader("Content-type", "application/octet-stream");
            var _local5:URLRequest = new URLRequest(_local2);
            _local5.requestHeaders.push(_local4);
            _local5.method = URLRequestMethod.POST;
            _local5.data = _local3;
            var _local6:URLLoader = new URLLoader();
            _local6.addEventListener(Event.COMPLETE, this.uploadSourceComplete);
            _local6.addEventListener(IOErrorEvent.IO_ERROR, this.sourceErrorHandler);
            _local6.load(_local5);
        }
        private function sourceErrorHandler(_arg1:IOErrorEvent):void{
            var _local2:URLLoader = (_arg1.target as URLLoader);
            _local2.removeEventListener(Event.COMPLETE, this.uploadSourceComplete);
            _local2.removeEventListener(IOErrorEvent.IO_ERROR, this.sourceErrorHandler);
            if (ExternalInterface.available){
                ExternalInterface.call(Param.jsFunc, "M00004");
            };
        }
        private function uploadSourceComplete(_arg1:Event):void{
            var _local2:URLLoader = (_arg1.target as URLLoader);
            _local2.removeEventListener(Event.COMPLETE, this.uploadSourceComplete);
            _local2.removeEventListener(IOErrorEvent.IO_ERROR, this.sourceErrorHandler);
            var _local3:String = _local2.data.match(/\{.+\}/)[0];
            var _local4:Object = JSON.decode(_local3);
            if (_local4["code"] == "A00006"){
                this._sourcePID = _local4["data"]["pics"]["pic_1"]["pid"];
                this.uploadAvatar();
            } else {
                if (ExternalInterface.available){
                    ExternalInterface.call(Param.jsFunc, "M00004");
                };
            };
        }
        private function uploadAvatar():void{
            var _local1:String = Param.verifyCode;
            var _local2:String = ((((((Param.imgUrl + "?oldver=") + Param.ver) + "&product=cloudsoft&activityKey=") + _local1) + "&ct=") + new Date().getTime());
            Param.ticket.shift();
            Param.getTicket();
            var _local3:Bitmap = this.avatarArea.bigPic;
            var _local4:BitmapData = _local3.bitmapData;
            var _local5:Number = _local4.width;
            var _local6:Number = _local4.height;
            var _local7:BitmapData = new BitmapData(180, 180);
            _local7.draw(_local4, new Matrix(_local3.scaleX, 0, 0, _local3.scaleX, 0, 0), null, null, new Rectangle(0, 0, 180, 180));
            var _local8:JPGEncoder = new JPGEncoder(100);
            var _local9:ByteArray = _local8.encode(_local7);
            var _local10:URLRequestHeader = new URLRequestHeader("Content-type", "application/octet-stream");
            var _local11:URLRequest = new URLRequest(_local2);
            _local11.requestHeaders.push(_local10);
            _local11.method = URLRequestMethod.POST;
            _local11.data = _local9;
            var _local12:URLLoader = new URLLoader();
            _local12.addEventListener(Event.COMPLETE, this.uploadComplete);
            _local12.addEventListener(IOErrorEvent.IO_ERROR, this.errorHandler);
            _local12.load(_local11);
        }
        private function uploadComplete(_arg1:Event):void{
            var _delurl:* = null;
            var _suc:* = false;
            var _ticket:* = null;
            var evt:* = _arg1;
            if (contains(this._loadingPanel)){
                removeChild(this._loadingPanel);
            };
            var loader:* = (evt.target as URLLoader);
            loader.removeEventListener(Event.COMPLETE, this.uploadComplete);
            loader.removeEventListener(IOErrorEvent.IO_ERROR, this.errorHandler);
            var _json:* = loader.data.match(/\{.+\}/)[0];
            var returnData:* = JSON.decode(_json);
            var delAndVersion:* = new URLLoader();
            if (returnData["ret"] == "1"){
                _suc = true;
            } else {
                _suc = false;
            };
            if (_suc){
				try {
                    ExternalInterface.call(Param.jsFunc, "uploadComplete");
                } catch(e:Error) {
                };
				
                /*_ticket = Param.verifyCode;
                Param.ticket.shift();
                Param.getTicket();
                _delurl = ((((((((((Param.delUrl + "?ver=") + returnData["ver"]) + "&status=1&ticket=") + _ticket) + "&type=") + this.avatarModel.type) + "&pid=") + this._sourcePID) + "&ct=") + new Date().getTime());
				delAndVersion.load(new URLRequest(_delurl));
                delAndVersion.addEventListener(Event.COMPLETE, this.delComplete);*/
            } else {
                try {
                    ExternalInterface.call(Param.jsFunc, "M00004");
                } catch(e:Error) {
                };
            };
        }
        private function delComplete(_arg1:Event):void{
            var evt:* = _arg1;
            var delAndVersion:* = (evt.target as URLLoader);
            delAndVersion.removeEventListener(Event.COMPLETE, this.delComplete);
            var requestJson:* = JSON.decode(delAndVersion.data);
            if (requestJson["code"] == "A00006"){
                try {
                    ExternalInterface.call(Param.jsFunc, "A00006");
                } catch(e:Error) {
                };
            } else {
                try {
                    ExternalInterface.call(Param.jsFunc, "M00004");
                } catch(e:Error) {
                };
            };
        }
        private function errorHandler(_arg1:IOErrorEvent):void{
            var _local2:URLLoader = (_arg1.target as URLLoader);
            _local2.removeEventListener(IOErrorEvent.IO_ERROR, this.errorHandler);
        }
        private function cancelProgramm(_arg1:MouseEvent):void{
            var _local2:URLRequest = new URLRequest("javascript:window.location.reload(true)");
            navigateToURL(_local2, "_self");
        }

    }
}//package view 
