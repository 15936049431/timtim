﻿//Created by Action Script Viewer - http://www.buraks.com/asv
package view.localpic {
    import flash.events.*;
    import flash.ui.*;
    import flash.display.*;
    import view.ui.*;
    import view.*;
    import view.avatar.*;
    import flash.geom.*;

    public class LocalPicArea extends Sprite {

        private const MAX_WIDTH:Number = 300;
        private const MAX_HEIGHT:Number = 300;

        private var swfStage:Stage;
        private var flagVY:Number;
        private var flagVX:Number;
        private var flagCurX:Number;
        private var flagCurY:Number;
        private var _h:Number;// = 10
        private var _w:Number;// = 10
        private var _cutAreaBg:RectBox;
        private var _cursorMove:SK_CursorMove;
        private var _cursorScale:SK_CursorScale;
        private var _turnLeft:SK_TurnLeft;
        private var _turnRight:SK_TurnRight;
        private var _sourceBMD:BitmapData;
        private var _picRate:Number;
        private var _picX:Number;
        private var _picY:Number;
        private var _avatar:AvatarArea;
        private var _picContainer:Sprite;
        private var _cutBox:CutBox;
        public var loaddingUI:MovieClip;
        public var tip:MovieClip;

        public function LocalPicArea(){
            this.init();
        }
        private function init():void{
            this._cutAreaBg = new RectBox(this.MAX_WIDTH, this.MAX_HEIGHT);
            this._picContainer = new Sprite();
            this._cursorMove = new SK_CursorMove();
            this._cursorMove.mouseEnabled = false;
            this._cursorMove.visible = false;
            this._cursorScale = new SK_CursorScale();
            this._cursorScale.mouseEnabled = false;
            this._cursorScale.visible = false;
            this.tip = (new SK_Tip() as MovieClip);
            this.tip.x = (this.tip.y = 1);
            this.tip.stop();
            this.tip.mouseEnabled = false;
            this._turnLeft = new SK_TurnLeft();
            this._turnLeft.y = 312;
            this._turnLeft.addEventListener(MouseEvent.CLICK, this.rotationPicLeft);
            this._turnRight = new SK_TurnRight();
            this._turnRight.x = 220;
            this._turnRight.y = 312;
            this._turnRight.addEventListener(MouseEvent.CLICK, this.rotationPicRight);
            this.showTunBtns(false);
            this.createLoaddingUI();
            addChild(this._cutAreaBg);
            addChild(this.tip);
            addChild(this._picContainer);
            addChild(this._turnLeft);
            addChild(this._turnRight);
            addChild(this.loaddingUI);
            this.addEventListener(Event.ADDED_TO_STAGE, this.addedToStage);
        }
        private function createLoaddingUI():void{
            this.loaddingUI = (new SK_Loading() as MovieClip);
            this.loaddingUI.x = 151;
            this.loaddingUI.y = 130;
            this.loaddingUI.stop();
            this.loaddingUI.visible = false;
        }
        private function addedToStage(_arg1:Event):void{
            this.swfStage = this.stage;
            var _local2:CutView = (this.parent as CutView);
            this._avatar = _local2.avatarArea;
            this.removeEventListener(Event.ADDED_TO_STAGE, this.addedToStage);
        }
        public function showTunBtns(_arg1:Boolean):void{
            this._turnLeft.visible = (this._turnRight.visible = _arg1);
        }
        public function setLocalPicSize(_arg1:BitmapData):void{
            var _local7:Bitmap;
            if (this.tip != null){
                removeChild(this.tip);
                this.tip = null;
            };
            this._sourceBMD = _arg1;
            var _local2:Bitmap = new Bitmap(_arg1);
            var _local3:Number = (this.MAX_WIDTH / _local2.width);
            var _local4:Number = (this.MAX_HEIGHT / _local2.height);
            this._picRate = ((_local3)<_local4) ? _local3 : _local4;
            _local2.width = (_local2.width * this._picRate);
            _local2.scaleY = _local2.scaleX;
            if (_local3 < _local4){
                _local2.height = int(_local2.height);
            } else {
                _local2.width = int(_local2.width);
            };
            while (this._picContainer.numChildren) {
                _local7 = (this._picContainer.removeChildAt((this._picContainer.numChildren - 1)) as Bitmap);
                _local7 = null;
            };
            var _local5:BitmapData = (this._sourceBMD = _local2.bitmapData);
            var _local6:Bitmap = new Bitmap(_local5);
            _local6.width = _local2.width;
            _local6.height = _local2.height;
            this._picContainer.addChild(_local2);
            _local2.alpha = 0.5;
            this._picContainer.addChild(_local6);
            this._picX = (this._picContainer.x = (((this.MAX_WIDTH - _local2.width) * 0.5) + 1));
            this._picY = (this._picContainer.y = (((this.MAX_HEIGHT - _local2.height) * 0.5) + 1));
            this.addCutBox(_local6);
            this.showTunBtns(true);
        }
        public function addCutBox(_arg1:Bitmap):void{
            var _local2:Number;
            if (this._cutBox != null){
                removeChild(this._cutBox);
                this._cutBox = null;
            };
            if ((((_arg1.width < 180)) || ((_arg1.height < 180)))){
                _local2 = ((_arg1.width)>_arg1.height) ? _arg1.height : _arg1.width;
            } else {
                _local2 = 180;
            };
            this._cutBox = new CutBox(_local2, _local2);
            this._cutBox.x = (this._picContainer.x + ((this._picContainer.width - this._cutBox.cutArea.width) * 0.5));
            this._cutBox.y = (this._picContainer.y + ((this._picContainer.height - this._cutBox.cutArea.height) * 0.5));
            addChild(this._cutBox);
            addChild(this._cursorMove);
            addChild(this._cursorScale);
            _arg1.mask = this._cutBox.maskArea;
            this._cutBox.addEventListener(MouseEvent.MOUSE_OVER, this.changeCursor);
            var _local3:BitmapData = this.getAvatarBMD(this._picX, this._picY, this._picRate, this._cutBox);
            this._avatar.changeAvatars(_local3);
        }
        private function changeCursor(_arg1:MouseEvent):void{
            var _local2:Sprite = (_arg1.target as Sprite);
            if (_local2 == this._cutBox.cutArea){
                Mouse.hide();
                this._cursorMove.visible = true;
                this._cursorScale.visible = false;
                this._cursorMove.x = this.mouseX;
                this._cursorMove.y = this.mouseY;
            } else {
                if (_local2 == this._cutBox.flag){
                    Mouse.hide();
                    this._cursorScale.visible = true;
                    this._cursorMove.visible = false;
                    this._cursorScale.x = this.mouseX;
                    this._cursorScale.y = this.mouseY;
                };
            };
            this._cutBox.addEventListener(MouseEvent.MOUSE_MOVE, this.moveCursor);
            this._cutBox.addEventListener(MouseEvent.MOUSE_DOWN, this.changeCutBox);
            this._cutBox.addEventListener(MouseEvent.MOUSE_OUT, this.resetCursor);
        }
        private function resetCursor(_arg1:MouseEvent):void{
            Mouse.show();
            this._cursorMove.visible = false;
            this._cursorScale.visible = false;
            this._cutBox.removeEventListener(MouseEvent.ROLL_OUT, this.resetCursor);
            this._cutBox.removeEventListener(MouseEvent.MOUSE_MOVE, this.moveCursor);
            this._cutBox.removeEventListener(MouseEvent.MOUSE_DOWN, this.changeCutBox);
        }
        private function moveCursor(_arg1:MouseEvent):void{
            var _local3:Sprite;
            var _local2:Sprite = (_arg1.target as Sprite);
            switch (_local2){
                case this._cutBox.cutArea:
                    _local3 = (this._cursorMove as Sprite);
                    break;
                case this._cutBox.flag:
                    _local3 = (this._cursorScale as Sprite);
                    break;
            };
            this.cursorFollow(_local3);
            _arg1.updateAfterEvent();
        }
        private function cursorFollow(_arg1:Sprite):void{
            _arg1.x = this.mouseX;
            _arg1.y = this.mouseY;
        }
        private function changeCutBox(_arg1:MouseEvent):void{
            var _local2:Sprite = (_arg1.target as Sprite);
            switch (_local2){
                case this._cutBox.cutArea:
                    this.swfStage.addEventListener(MouseEvent.MOUSE_MOVE, this.moveCutBox);
                    this.swfStage.addEventListener(MouseEvent.MOUSE_UP, this.stopMoveCutBox);
                    break;
                case this._cutBox.flag:
                    this.flagVY = ((this.mouseY - this._cutBox.y) - this._cutBox.maskArea.height);
                    this.flagVX = ((this.mouseX - this._cutBox.x) - this._cutBox.maskArea.width);
                    this.flagCurX = this.mouseX;
                    this.flagCurY = this.mouseY;
                    this._cutBox.removeEventListener(MouseEvent.MOUSE_OVER, this.changeCursor);
                    this.swfStage.addEventListener(Event.ENTER_FRAME, this.resizeCutBox);
                    this.swfStage.addEventListener(MouseEvent.MOUSE_UP, this.stopResizeCutBox);
                    break;
            };
        }
        private function moveCutBox(_arg1:MouseEvent):void{
            this._cutBox.startDrag(false, new Rectangle((this._picContainer.x + 0.5), (this._picContainer.y + 0.5), ((this._picContainer.width - this._cutBox.maskArea.width) - 0.5), ((this._picContainer.height - this._cutBox.maskArea.height) - 0.5)));
            var _local2:BitmapData = this.getAvatarBMD(this._picX, this._picY, this._picRate, this._cutBox);
            this._avatar.changeAvatars(_local2);
        }
        private function stopMoveCutBox(_arg1:Event):void{
            this._cutBox.stopDrag();
            this.swfStage.removeEventListener(MouseEvent.MOUSE_MOVE, this.moveCutBox);
            this.swfStage.removeEventListener(MouseEvent.MOUSE_UP, this.stopMoveCutBox);
        }
        private function resizeCutBox(_arg1:Event):void{
            var _local2:Number;
            var _local3:Number;
            var _local4:Number;
            var _local5:Number;
            var _local6:BitmapData;
            Mouse.hide();
            this._cursorScale.x = this.mouseX;
            this._cursorScale.y = this.mouseY;
            this._cursorScale.visible = true;
            if (((!((this.mouseX == this.flagCurX))) || (!((this.mouseY == this.flagCurY))))){
                _local2 = ((this.mouseX - this._cutBox.x) - this.flagVX);
                _local3 = ((this.mouseY - this._cutBox.y) - this.flagVY);
                if (_local3 >= ((this._picContainer.y + this._picContainer.height) - this._cutBox.y)){
                    _local3 = (((this._picContainer.y + this._picContainer.height) - this._cutBox.y) - 0.5);
                };
                if (_local3 < this._h){
                    _local3 = this._h;
                };
                if (_local2 >= ((this._picContainer.x + this._picContainer.width) - this._cutBox.x)){
                    _local2 = (((this._picContainer.x + this._picContainer.width) - this._cutBox.x) - 0.5);
                };
                if (_local2 < this._w){
                    _local2 = this._w;
                };
                _local4 = (_local2 - this._cutBox.maskArea.width);
                _local5 = (_local3 - this._cutBox.maskArea.height);
                if (_local4 > _local5){
                    this._cutBox.maskArea.width = (this._cutBox.maskArea.height = _local3);
                } else {
                    this._cutBox.maskArea.width = (this._cutBox.maskArea.height = _local2);
                };
                this._cutBox.cutArea.width = this._cutBox.maskArea.width;
                this._cutBox.cutArea.height = this._cutBox.maskArea.height;
                this._cutBox.flag.x = this._cutBox.maskArea.width;
                this._cutBox.flag.y = this._cutBox.maskArea.height;
                _local6 = this.getAvatarBMD(this._picX, this._picY, this._picRate, this._cutBox);
                this._avatar.changeAvatars(_local6);
            };
        }
        private function stopResizeCutBox(_arg1:MouseEvent):void{
            Mouse.show();
            this._cursorScale.visible = false;
            this._cutBox.addEventListener(MouseEvent.MOUSE_OVER, this.changeCursor);
            this.swfStage.removeEventListener(Event.ENTER_FRAME, this.resizeCutBox);
            this.swfStage.removeEventListener(MouseEvent.MOUSE_UP, this.stopResizeCutBox);
        }
        private function getAvatarBMD(_arg1:Number, _arg2:Number, _arg3:Number, _arg4:CutBox):BitmapData{
            var _local5:Number = (_arg4.maskArea.width / _arg3);
            var _local6:Number = (180 / _local5);
            var _local7:BitmapData = new BitmapData(180, 180, false);
            var _local8:Number = int(((_arg4.x - _arg1) / _arg3));
            var _local9:Number = int(((_arg4.y - _arg2) / _arg3));
            _local7.draw(this._sourceBMD, new Matrix(_local6, 0, 0, _local6, (-(_local8) * _local6), (-(_local9) * _local6)), null, null, new Rectangle(0, 0, (_local5 * _local6), (_local5 * _local6)), false);
            return (_local7);
        }
        private function changeBmdRight(_arg1:BitmapData):BitmapData{
            var _local2:BitmapData = _arg1;
            var _local3:Number = _local2.width;
            var _local4:Number = _local2.height;
            var _local5:BitmapData = new BitmapData(_local4, _local3, false);
            var _local6:Matrix = new Matrix();
            _local6.rotate((Math.PI * 0.5));
            _local6.translate(_local4, 0);
            _local5.draw(_local2, _local6);
            return (_local5);
        }
        private function changeBmdLeft(_arg1:BitmapData):BitmapData{
            var _local2:BitmapData = _arg1;
            var _local3:Number = _local2.width;
            var _local4:Number = _local2.height;
            var _local5:BitmapData = new BitmapData(_local4, _local3, false);
            var _local6:Matrix = new Matrix();
            _local6.rotate((-(Math.PI) * 0.5));
            _local6.translate(0, _local3);
            _local5.draw(_local2, _local6);
            return (_local5);
        }
        private function rotationPicLeft(_arg1:MouseEvent):void{
            this._sourceBMD = this.changeBmdLeft(this._sourceBMD);
            this.setLocalPicSize(this._sourceBMD);
        }
        private function rotationPicRight(_arg1:MouseEvent):void{
            this._sourceBMD = this.changeBmdRight(this._sourceBMD);
            this.setLocalPicSize(this._sourceBMD);
        }

    }
}//package view.localpic 
