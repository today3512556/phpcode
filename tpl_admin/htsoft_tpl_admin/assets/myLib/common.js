/**
 * 提示框，（有确实取消按钮）
 * @param {Object} info	提示信息
 * @param {Object} obj	点击对象
 * @param {Object} type	提示框标示
 * 确认回调函数：promptBoxSuccess(obj,index);
 * 取消回调函数：promptBoxFail(obj,index);
 */
function promptBox(obj,info,type) {
	var index = layer.confirm(info, {
		btn: ['确认', '取消'],
	}, function() {
		//点击确定的回调函数
		if (typeof promptBoxSuccess != "undefined") { 
			promptBoxSuccess(obj,index,type);
		}
	}, function() {
		//点击取消的回调函数
		if (typeof promptBoxFail != "undefined") { 
			promptBoxFail(obj,index,type);
		}
	});
}

/**
 * iframe弹出层 
 * @param {Object} url	弹出页面的url
 * @param {Object} title	弹出页面的标题
 * @param {Object} width	弹出层的宽度（只输入数字）
 * @param {Object} height	弹出层的高度（只输入数字）
 */
function iframe(url,title,width,height) {
	layer.open({
		type: 2,
		title: title,
		shadeClose: false,
		shade: 0.5,
		maxmin: true, 	//开启最大化最小化按钮
		area: [width+'px', height+'px'],
		content: url
	});
}


/**
 * 弹出层操作结果
 * @param {Object} info	提示信息
 * @param {Object} isReloadParent	是否刷新父页面
 * @param {Object} isCloseIframe	是否关闭弹出层
 */
function iframeResult(info,isReloadParent,isCloseIframe){
	layer.confirm(info, {
		btn: ['确认 '] //按钮
		}, function(){
			var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
			//刷新页面
			if(isReloadParent)	parent.location.reload();
			//关闭弹出层
			if(isCloseIframe)	parent.layer.close(index);
		}
	);
}

/**
 * 表单验证
 * 验证通过回调函数：submitForm(data);
 */
function validform(){
	$("form").Validform({
		tiptype:function(msg,o,cssctl){
		    //msg：提示信息;
		    //o:{obj:*,type:*,curform:*},
		    //obj指向的是当前验证的表单元素（或表单对象，验证全部验证通过，提交表单时o.obj为该表单对象），
		    //type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, 
		    //curform为当前form对象;
		    //cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
		    if(o.type==3){
		    	layer.msg(msg,{time:1000});
		    }
		},
		beforeSubmit(curform){
			if (typeof submitForm != "undefined") { 
				submitForm($(curform).serializeArray());
			}
			return false;
		}
	});
}
	


/**
 * ajax提交函数封装
 * @param {Object} ajaxUrl	提交的url
 * @param {Object} ajaxType	提交的方式,post和get
 * @param {Object} ajaxData	提交的数据 ,json格式
 * @param {Object} type 类型（可自定义）
 * 成功后回调函数   ajaxSuccess(ajaxData,type);
 */
function ajaxSubmit(ajaxUrl,ajaxType,ajaxData,type){
	var index = layer.load(2);	//等待框
	$.ajax({     
		url: ajaxUrl,
		type: ajaxType,    
		dataType:"json",
		data: ajaxData, 
		success: function(data) { 
			//ajax提交数据成功的回调函数
			//ajaxData传入ajax的数据参数,为json
			layer.close(index);		//关闭等待框
			if (typeof ajaxSuccess != "undefined") { 
				ajaxSuccess(ajaxData,type);
			}
        },     
        error: function(err) {     
        	layer.close(index);	//关闭等待框
            layer.alert("服务器繁忙");
        }     
    }); 
}
