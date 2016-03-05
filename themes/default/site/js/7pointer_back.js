
	function pointermsg(msg,url,type,ico){
		layer.config({
		    extend: ['skin/moon/style.css'], //加载新皮肤
		    skin: 'layer-ext-myskin' //一旦设定，所有弹层风格都采用此主题。
		});
		url = (url==null) ? "/" : url ;
		msg = (msg==null) ? "无" : msg ;
		type= (type==null) ? 1 : type ;
		ico = (ico == null) ? 1 : ico ;
		layer.alert(msg, 
			 {
				title: '温馨提示',
		     	skin: 'layer-ext-moon',
		     	shift: type, 
		     	icon:ico
		     },
		     function(index){
		    	window.location.href=url;
				layer.close(index);
		     }
		);
		setTimeout(function(){
			window.location.href=url;
		},1500);
	}
	
	function pointermsgpar(msg,url,type,ico){
		layer.config({
		    extend: ['skin/moon/style.css'], //加载新皮肤
		    skin: 'layer-ext-myskin' //一旦设定，所有弹层风格都采用此主题。
		});
		url = (url==null) ? "/" : url ;
		msg = (msg==null) ? "无" : msg ;
		type= (type==null) ? 1 : type ;
		ico = (ico == null) ? 1 : ico ;
		layer.alert(msg, 
			 {
				title: '温馨提示',
		     	skin: 'layer-ext-moon',
		     	shift: type,
		     	icon:ico
		     },
		     function(index){
		    	parent.window.location.href=url;
				layer.close(index);
		     }
		);
		setTimeout(function(){
			parent.window.location.href=url;
		},1500);
	}
	
	function sendmsg(id,url,btn){
		var phone = $("#"+id).val();
		if(!(/^1[0-9]{10}$/.test(phone))){ 
			layer.msg('不是完整的11位手机号或者正确的手机号前七位', {shift: 6});
			return false;
		} else{
			url = (url==null) ? "" : url ; 
			$.post(url+"&phone="+phone,{},function(data){
	            var obj = eval("("+data+")");
	            if(obj.status == 1){
	                layer.msg(obj.msg, {shift: 1});
	            }else{
	            	layer.msg(obj.msg, {shift: 6});
	            }
	        });
		}
	}
	
	function pointererror(error,type){
		type = (type==null) ? 6 : type; 
		layer.msg(error, {shift: type});
	}
	
	function openWindow(name,width,height,src){
	   	 layer.open({
	   		type: 2,
	   		title: [name,'background:#fff;height:50px;line-height:50px;font-size:16px;padding-left:20px;'],
	   		shadeClose: true,
	   		shade: 0.5,
	   		area: [width+'px', height+'px'],
	   		content: [src,'no'],
	   		yes:function(index){
	   			layer.close(index);
	   		}
  		}); 
    }
	
