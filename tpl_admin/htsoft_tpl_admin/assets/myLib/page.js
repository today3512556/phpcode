var $,laypage,layer;
layui.use(['laypage','layer', 'form'], function() {
	$ = layui.jquery;
	laypage = layui.laypage;
	layer = layui.layer;
	
	
	//分页参数
	var pageCount = $('#page').attr('data-pageCount');	//总页数
	var pageUrl = $('#page').attr('data-pageUrl');	//下一页链接
	var beginRowName = $('#page').attr('data-beginRowName');	//本页码标识字段
	
	//分页
	laypage({
		cont: 'page',		//分页容器。值支持id名、原生dom对象，jquery对象
		pages: pageCount, //总页数
		skin: 'molv',	//分页皮肤molv、yahei、flow 
		skip: true,
		curr: function(){ 
			//通过url获取当前页，也可以同上（pages）方式获取
			var page = location.search.match(/beginRow=(\d+)/);
			return page ? page[1] : 1;
		}(), 
		//触发分页后的回调
		jump: function(e, first){ 
			pageCurr = e.curr;
			if(pageCount==0){
				//提示当前页（e.curr）和总页数（e.pages）
				$('#page').append('<span style="padding-left: 1%;">第'+ e.curr +'页,共1页</span>');
			}else{
				$('#page').append('<span style="padding-left: 1%;">第'+ e.curr +'页,共'+ e.pages +'页</span>');
			}
			if(!first){
				var form = $('#findForm').serializeArray();
				var formSubmit="";
				$.each(form, function(i, field){
					if(field.value!=""){
						formSubmit = formSubmit + "&" + field.name + "=" + field.value;
					}
				});
				layer.load(2);
				location.href = pageUrl+"?"+beginRowName+"="+e.curr+formSubmit;
			}
		}
	});	
});
