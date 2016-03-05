//Created by Action Script Viewer - http://www.buraks.com/asv
package {
    import flash.events.*;
    import flash.ui.*;
    import model.*;
    import flash.display.*;
    import view.*;
    import com.sina.utils.*;
    import flash.system.*;

    public class Main extends Sprite {

        private var swfStage:Stage;
        public var avatarModel:AvatarModel;
        public var cutView:CutView;
        public var fpVersion:int;
        public var parameter:Object;
        public var uid:String;
        public var initImgURL:String;
        public var uploadURL:String;
        public var tempUploadURL:String;

        public function Main():void{
            if (stage){
                this.init();
            } else {
                addEventListener(Event.ADDED_TO_STAGE, this.init);
            };
        }
        private function init(_arg1:Event=null):void{
            removeEventListener(Event.ADDED_TO_STAGE, this.init);
            Security.allowDomain("*");
            this.swfStage = this.stage;
            this.swfStage.align = StageAlign.TOP_LEFT;
            this.swfStage.scaleMode = StageScaleMode.NO_SCALE;
            //var _local2:ContextMenu = ContextMenuVersion.version("HeadPic4cloudsoft", "1.00");
            //this.contextMenu = _local2;
            this.parameter = this.loaderInfo.parameters;
            Param.s = this.swfStage;
            Param.limited = this.parameter["limited"];
            Param.uid = this.parameter["uid"];
            Param.ver = this.parameter["ver"];
            Param.uidUrl = (this.parameter["uidurl"]) ? this.parameter["uidurl"] : "http://www.cloudbility.com/pub/defaultIcon/user/1.jpg";
            Param.tmpUrl = (this.parameter["tmpurl"]) ? this.parameter["tmpurl"] : "http://www.cloudbility.com/";
            Param.tmpImgUrl = this.parameter["tmpimgurl"];
            Param.jsFunc = this.parameter["jsfunc"];
            Param.imgUrl = (this.parameter["imgurl"]) ? this.parameter["imgurl"] : "http://www.cloudbility.com/";
            Param.delUrl = (this.parameter["delurl"]) ? this.parameter["delurl"] : "http://www.cloudbility.com/";
            Param.sourcePicURL = (this.parameter["sourcepicurl"]) ? this.parameter["sourcepicurl"] : "http://www.cloudbility.com/";
            Param.albumURL = (this.parameter["albumurl"]) ? this.parameter["albumurl"] : "http://www.cloudbility.com/";
            Param.verifyCode = ((this.parameter["verifycode"]) || ("1"));
            Param.initLanguage();
            this.fpVersion = this.getVersion();
            this.avatarModel = new AvatarModel();
            this.avatarModel.loaderPic(Param.uidUrl);
            this.cutView = new CutView(this.avatarModel);
            addChild(this.cutView);
        }
        private function getVersion():int{
            var _local1:String = Capabilities.version;
            var _local2:Array = _local1.split(",", 1);
            _local1 = (_local2[0] as String);
            return (int(_local1.slice(4)));
        }

    }
}//package 
