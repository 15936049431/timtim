//Created by Action Script Viewer - http://www.buraks.com/asv
package view.browse {
    import flash.events.*;
    import model.*;
    import flash.display.*;
    import flash.text.*;
    import com.adobe.serialization.json.*;
    import view.*;
    import flash.net.*;
    import flash.system.*;
    import flash.external.*;

    public class BrowseComp extends Sprite {

        public var label:TextField;
        public var btnBrowse:MovieClip;
        private var _fileRef:FileReference;
        private var _imgFilter:FileFilter;
        private var _picLoader:Loader;
        private var _avatarModel:AvatarModel;
        private var _fpVersion:int;
        private var _parent:CutView;

        public function BrowseComp(_arg1:AvatarModel):void{
            this.init(_arg1);
            this.addEventListener(Event.ADDED_TO_STAGE, this.onStage);
        }
        private function init(_arg1:AvatarModel):void{
            var cutModel:* = _arg1;
            var labelFormat:* = new TextFormat("宋体,Arial,Helvetica", 12, 0x999999);
            this.label = new TextField();
            var _local3 = this.label;
            with (_local3) {
                selectable = false;
                autoSize = TextFieldAutoSize.LEFT;
                x = -3;
                y = 36;
                defaultTextFormat = labelFormat;
                text = ((Param.language["CX0193"]) || ("仅支持JPG、GIF、PNG图片文件，且文件小于5M"));
            };
            addChild(this.label);
            this.btnBrowse = (new SK_Browse() as MovieClip);
            this.btnBrowse.buttonMode = true;
            this.btnBrowsAddEvents();
            this._avatarModel = cutModel;
            this._fileRef = new FileReference();
            this._imgFilter = new FileFilter("Image Files (*.jpg, *.gif, *.jpeg, .*.png)", "*.jpg; *.gif; *.jpeg; *.png");
            addChild(this.btnBrowse);
            if (ExternalInterface.available){
                ExternalInterface.addCallback("setTicket", Param.setTicket);
            };
            Param.getTicket();
        }
        private function onStage(_arg1:Event):void{
            this.removeEventListener(Event.ADDED_TO_STAGE, this.onStage);
            var _local2:Main = (this.root as Main);
            this._fpVersion = _local2.fpVersion;
            this._parent = (this.parent as CutView);
        }
        public function btnBrowsAddEvents():void{
            this.btnBrowse.addEventListener(MouseEvent.CLICK, this.selectLocalPic);
            this.btnBrowse.addEventListener(MouseEvent.MOUSE_OVER, this.changeStatus);
            this.btnBrowse.addEventListener(MouseEvent.MOUSE_OUT, this.changeStatus);
        }
        private function changeStatus(_arg1:MouseEvent):void{
            if (_arg1.type == MouseEvent.MOUSE_OVER){
                this.btnBrowse.gotoAndStop(2);
            } else {
                this.btnBrowse.gotoAndStop(1);
            };
        }
        public function btnBrowsRemoveEvents():void{
            this.btnBrowse.removeEventListener(MouseEvent.MOUSE_OUT, this.changeStatus);
            this.btnBrowse.removeEventListener(MouseEvent.MOUSE_OVER, this.changeStatus);
            this.btnBrowse.gotoAndStop(3);
        }
        private function selectLocalPic(_arg1:MouseEvent):void{
            this.btnBrowsRemoveEvents();
            if (this._parent.localPicArea.visible == false){
                this._parent.localPicArea.visible = true;
                this._parent.avatarArea.visible = true;
                this._parent.splitLines.visible = true;
                this._parent.cameraArea.visible = false;
                this.label.visible = true;
                if (this._parent.saveBtn != null){
                    this._parent.saveBtn.visible = (this._parent.cancleBtn.visible = true);
                };
                this._parent.cameraBtn.mouseEnabled = true;
                this._parent.cameraBtnAddEvents();
                this._parent.localPicArea.setLocalPicSize(this._avatarModel.bmd);
            };
            this._parent.cameraBtn.gotoAndStop(1);
            this._parent.checkBox.visible = true;
            this._fileRef.browse([this._imgFilter]);
            this._fileRef.addEventListener(Event.SELECT, this.onFileSelected);
            this._fileRef.addEventListener(Event.CANCEL, this.onCancel);
        }
        private function onFileSelected(_arg1:Event):void{
            this._fileRef.removeEventListener(Event.SELECT, this.onFileSelected);
            this._fileRef.removeEventListener(Event.CANCEL, this.onCancel);
            if (this.getFile()){
                if (this._fpVersion == 9){
                    this._parent.localPicArea.loaddingUI.visible = true;
                    this._parent.localPicArea.loaddingUI.play();
                    if (this._parent.localPicArea.tip != null){
                        this._parent.localPicArea.tip.visible = false;
                    };
                    this.uploadFile();
                } else {
                    if (this._fpVersion > 9){
                        this._fileRef.load();
                        this._fileRef.addEventListener(Event.COMPLETE, this.refPicOK);
                    };
                };
            };
        }
        private function onCancel(_arg1:Event):void{
            this._fileRef.removeEventListener(Event.CANCEL, this.onCancel);
        }
        private function refPicOK(_arg1:Event):void{
            this._avatarModel.imgData = this._fileRef.data;
            this._picLoader = new Loader();
            this._picLoader.contentLoaderInfo.addEventListener(Event.COMPLETE, this.passImgToModel);
            this._picLoader.loadBytes(this._fileRef.data);
        }
        private function passImgToModel(_arg1:Event):void{
            var _local2:LoaderInfo = (_arg1.target as LoaderInfo);
            _local2.removeEventListener(Event.COMPLETE, this.passImgToModel);
            var _local3:Bitmap = (_local2.content as Bitmap);
            this._avatarModel.bmd = _local3.bitmapData;
            this._avatarModel.type = 2;
            _local2.loader.unload();
        }
        private function loadTempPic(_arg1:String):void{
            var _local2:URLRequest = new URLRequest(_arg1);
            var _local3:Loader = new Loader();
            var _local4:LoaderContext = new LoaderContext(true);
            _local3.contentLoaderInfo.addEventListener(Event.COMPLETE, this.passImgToModel);
            _local3.load(_local2, _local4);
        }
        private function uploadFile():void{
            var _ticket:* = null;
            if (Param.ticket.length != 0){
                _ticket = Param.verifyCode;
            } else {
                _ticket = "1";
            };
            var urlrequest:* = new URLRequest(((((Param.tmpUrl + "?ticket=") + _ticket) + "&ct=") + new Date().getTime()));
            Param.ticket.shift();
            Param.getTicket();
            try {
                this._fileRef.upload(urlrequest);
            } catch(e:Error) {
            };
            this._fileRef.addEventListener(DataEvent.UPLOAD_COMPLETE_DATA, this.startPhotoCut);
            this._fileRef.addEventListener(IOErrorEvent.IO_ERROR, this.upTmpPhotoError);
            this._fileRef.addEventListener(SecurityErrorEvent.SECURITY_ERROR, this.upTmpPhotoError);
        }
        private function getFile():Boolean{
            if (this._fileRef.size > 0x500000){
                try {
                    ExternalInterface.call(Param.jsFunc, "M01108");
                } catch(e:Error) {
                };
                return (false);
            };
            if (!/.+\.(jpg|png|gif|jpeg)$/i.test(this._fileRef.name)){
                try {
                    ExternalInterface.call(Param.jsFunc, "M01107");
                } catch(e:Error) {
                };
                return (false);
            };
            return (true);
        }
        private function startPhotoCut(_arg1:DataEvent):void{
            var evt:* = _arg1;
            this._fileRef.removeEventListener(DataEvent.UPLOAD_COMPLETE_DATA, this.startPhotoCut);
            this._fileRef.removeEventListener(IOErrorEvent.IO_ERROR, this.upTmpPhotoError);
            this._fileRef.removeEventListener(SecurityErrorEvent.SECURITY_ERROR, this.upTmpPhotoError);
            var jsons:* = JSON.decode(evt["data"]);
            if (jsons["code"] == "A00006"){
                if (jsons["data"]["url"]){
                    Param.tmpImgUrl = jsons["data"]["url"];
                };
                this.loadTempPic(((Param.tmpImgUrl + "?ct=") + new Date().getTime()));
            } else {
                try {
                    ExternalInterface.call(Param.jsFunc, jsons["code"]);
                } catch(e:Error) {
                };
                return;
            };
        }
        private function upTmpPhotoError(_arg1:IOErrorEvent):void{
            this._fileRef.removeEventListener(IOErrorEvent.IO_ERROR, this.upTmpPhotoError);
        }

    }
}//package view.browse 
