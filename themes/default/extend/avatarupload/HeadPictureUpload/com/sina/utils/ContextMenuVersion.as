﻿//Created by Action Script Viewer - http://www.buraks.com/asv
package com.sina.utils {
    import flash.ui.*;

    public class ContextMenuVersion {

        public static function version(_arg1:String, _arg2:String="1.0", _arg3:Boolean=true):ContextMenu{
            _arg1 = (_arg1 + ((":v" + _arg2) + "."));
            var _local4:ContextMenuItem = new ContextMenuItem(_arg1, false, false);
            var _local5:ContextMenu = new ContextMenu();
            if (_arg3){
                _local5.hideBuiltInItems();
            };
            _local5.customItems.push(_local4);
            return (_local5);
        }

    }
}//package com.sina.utils 
