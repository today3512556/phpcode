// JavaScript Document
//删除弹框
function del() {
	layer.confirm('确认要删除么？', {
		btn: ['确认', '取消'],
	}, function() {
		layer.msg('删除成功');
	}, function() {
		//取消
		layer.msg('删除失败');
	});
}
$(".J_list_delete").on(
		"click",function(){
			var url=$(this).attr("data-url");
			layer.confirm('确认要删除么？', {
				btn: ['确认', '取消'],
			}, function() {
				$.getJSON(url,function(data){
					if(data.status=="1"){	
						layer.msg(data.info);
						reloadPage(window);
					}else{
						layer.msg(data.info);
					}
				});
			}, function() {
				
			});	
		});
// 短信验证码
function send() {
	layer.confirm('短信验证码发送成功？', {
		btn: ['确认', '取消'],
	}, function() {
		layer.msg('操作成功');
	});
}
$(".J_list_send").on(
		"click",function(){
			var url=$(this).attr("data-url");
			layer.confirm('确认要发送短信吗？', {
				btn: ['确认', '取消'],
			}, function() {
				$.getJSON(url,function(data){
					if(data.status=="1"){	
						layer.msg(data.info);
						//reloadPage(window);
					}else{
						layer.msg(data.info);
					}
				});
			}, function() {
				
			});	
		});

$(".J_list_repwd").on(
		"click",function(){
			var url=$(this).attr("data-url");
			layer.confirm('确认重置密码为:111111？', {
				btn: ['确认', '取消'],
			}, function() {
				$.getJSON(url,function(data){
					if(data.status=="1"){	
						layer.msg(data.info);
						//reloadPage(window);
					}else{
						layer.msg(data.info);
					}
				});
			}, function() {
				
			});	
		});
//iframe层
function iframe(url,name,width,height) {
	layer.open({
		type: 2,
		title: name,
		shadeClose: false,
		shade: 0.5,
		maxmin: true, //开启最大化最小化按钮
		area: [width, height],
		content: url
	});
}

//添加成功
function addsave(url) {
	layer.confirm("添加成功", {
		btn: ['确认 '] //按钮
	}, function() {
		window.location.href = url;
	});
}
//修改成功
function editsave(url){
	layer.confirm("修改成功", {
		btn: ['确认 '] //按钮
		}, function(){
			window.location.href = url;
		}
	);
}

//返回
function returns(url){
	window.location.href = url;
}

$(".J_ajax_iframe_submit").on("click",function(e){
	e.preventDefault();
	var btn = $(this),
		form = btn.parents('form.J_ajaxForm');
	layedit.sync(layeditIndex);
	form.ajaxSubmit({
		url: btn.attr('action') ? btn.attr('action') : form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
		type:'POST',
		dataType: 'json',
		beforeSubmit: function (arr, $form, options) {
			//console.log(arr[0]);
			//var obj={"name":"text","value":"11","type":"text"};
			//arr.push(obj);
		},
		success: function (data, statusText, xhr, $form) {
			if (data.state === 'success') {
				layer.confirm(data.info, {
						btn: ['确认 '] //按钮
					}, function(){
						var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
						parent.location.reload();
						parent.layer.close(index);
					}
				);
			} else if (data.state === 'fail') {
				layer.msg(data.info);
			}

		},
		complete: function(){

		}
	});
});
//iframe层成功提示
function iframeCancel(){
	layer.confirm("", {
			btn: ['确认 '] //按钮
		},function(){
			var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
			parent.location.reload();
			parent.layer.close(index);
		}
	);
}
// 受理
function ok() {
	layer.confirm('是否确定订单？', {
		btn: ['确认', '取消'],
	}, function() {
		layer.msg('操作成功');
	}, function() {
		//取消
		layer.msg('操作失败');
	});
}
//重新刷新页面，使用location.reload()有可能导致重新提交
function reloadPage(win) {
    var location = win.location;
    location.href = location.pathname + location.search;
}
$("#refresh_wrapper").click(function(){
		reloadPage(window);
    	return false;
});
$('.J_ajax_submit_addbtn').on('click', function (e) {
	e.preventDefault();
	var btn = $(this),
	form = btn.parents('form.J_ajaxForm');
	layedit.sync(layeditIndex);
	form.ajaxSubmit({
		url: btn.attr('action') ? btn.attr('action') : form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
		type:'POST',
		dataType: 'json',
		beforeSubmit: function (arr, $form, options) {
			//console.log(arr[0]);
			//var obj={"name":"text","value":"11","type":"text"};
			//arr.push(obj);
		},
		success: function (data, statusText, xhr, $form) {
			if (data.state === 'success') {
				if (data.referer) {
					layer.confirm('添加成功，继续添加么？', {
						btn: ['继续添加', '返回列表页'],
					}, function() {
						//取消
						if(window.parent.art){
							reloadPage(window.parent);
						}else{
							//刷新当前页
							reloadPage(window);
						}
					}, function() {
						//返回带跳转地址
						var wait="";
						if(!wait){
							wait=1;
						}
						if(window.parent.art){
							//iframe弹出页
							if(wait){
								setTimeout(function(){
									window.parent.location.href = data.referer;
								},wait);
							}else{
								window.parent.location.href = data.referer;
							}
						}else{
							if(wait){
								setTimeout(function(){
									window.location.href = data.referer;
								},wait);
							}else{
								window.location.href = data.referer;
							}
						}
					});
				} else {
					if (data.state === 'success') {
						if(window.parent.art){
							reloadPage(window.parent);
						}else{
							//刷新当前页
							reloadPage(window);
						}
					}
				}
			} else if (data.state === 'fail') {
				layer.msg(data.info);
			}

		},
		complete: function(){

		}
	});
});

$('.J_ajax_submit_savebtn').on('click', function (e) {
	e.preventDefault();
	var btn = $(this),
		form = btn.parents('form.J_ajaxForm');
	layedit.sync(layeditIndex);
	form.ajaxSubmit({
		url: btn.attr('action') ? btn.attr('action') : form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
		type:'POST',
		dataType: 'json',
		beforeSubmit: function (arr, $form, options) {
			//console.log(arr[0]);
			//var obj={"name":"text","value":"11","type":"text"};
			//arr.push(obj);
		},
		success: function (data, statusText, xhr, $form) {
			if (data.state === 'success') {
				layer.msg(data.info);
				if (data.referer) {
						//返回带跳转地址
						var wait="";
						if(!wait){
							wait=1;
						}
						if(window.parent.art){
							//iframe弹出页
							if(wait){
								setTimeout(function(){
									window.parent.location.href = data.referer;
								},wait);
							}else{
								window.parent.location.href = data.referer;
							}
						}else{
							if(wait){
								setTimeout(function(){
									window.location.href = data.referer;
								},wait);
							}else{
								window.location.href = data.referer;
							}
						}
				}else{

					if(window.parent.art){
						reloadPage(window.parent);
					}else{
						//刷新当前页
						reloadPage(window);
					}
				}
			} else if (data.state === 'fail') {
				layer.msg(data.info);
			}

		},
		complete: function(){

		}
	});
});