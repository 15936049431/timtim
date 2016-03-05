
	function pointermsg(msg,url,type,ico){
		url = (url==null) ? "/" : url ;
		msg = (msg==null) ? "无" : msg ;
		type= (type==null) ? 1 : type ;
		ico = (ico == null) ? 1 : ico ;
		alert(msg);
		setTimeout(function(){
			window.location.href=url;
		},1000);
	}
	
	function pointermsgpar(msg,url,type,ico){
		url = (url==null) ? "/" : url ;
		msg = (msg==null) ? "无" : msg ;
		type= (type==null) ? 1 : type ;
		ico = (ico == null) ? 1 : ico ;
		alert(msg);
		setTimeout(function(){
			parent.window.location.href=url;
		},1000);
	}
	
	function sendmsg(id,url,btn){
		var phone = $("#"+id).val();
		if(!(/^1[0-9]{10}$/.test(phone))){ 
			alert('不是完整的11位手机号或者正确的手机号前七位');
			return false;
		} else{
			url = (url==null) ? "" : url ; 
			$.post(url+"&phone="+phone,{},function(data){
	            var obj = eval("("+data+")");
	            if(obj.status == 1){
	                alert(obj.msg);
	            }else{
	            	alert(obj.msg);
	            }
	        });
		}
	}
	
	function pointererror(error){
		alert(error);
	}
	
	function openWindow(name,width,height,src){
		$.layer({
		    type: 2,
		    title: [name,'background:#fff;height:50px;line-height:50px;font-size:16px;text-indent:20px;'],
		    shadeClose: true,
		    closeBtn: [0, false],
		    shade: [0.8, '#000'],
		    closeBtn : [0 , true],
		    border: [0],
		    offset: [(($(window).height() - height)/2) +'px',''],
		    area: [width, height],
		    iframe: {src: src}
		});
    }

	
