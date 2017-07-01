
/**
 * 创建菜单组件
 * @param menuObj
 * @returns {*|jQuery|HTMLElement}
 */
function creatMenu(menuObj){
	$("#"+menuObj.dom).accordion(menuObj);
	if($.isArray(menuObj.data) && menuObj.data.length>0){
		addMenu(menuObj);
	}
	$("#"+menuObj.dom).accordion('resize');
	$("#"+menuObj.dom).accordion('select',0);
	return $("#"+menuObj.dom);
}
/**
 * 添加菜单(待改进)
 * @param menuObj
 * @return
 */
function addMenu(menuObj){
	var menuStr = "";
	if($.isArray(menuObj.data) && menuObj.data.length>0){
		$.each(menuObj.data,function(i,n){//i 索引 n 元素 例如 var j = [a,b,c..] n=j[i]
			var menu = {};
			menu.title = n.title;
			menu.select = false;
			if(n.select){
				menu.select = true;
			}
			menuStr = '<div style="padding:10px">';
			if($.isArray(n.children) && n.children.length>0){
				menuStr += '<ul id=ul_'+n.id+'>';
				$.each(n.children,function(a,b){
					var positionStr = b.position+"";
					var hrefStr = b.href+"";
					var titleStr = b.title+"";
					menuStr +='<li style="text-align:center;list:none;padding:10px;border-bottom:1px blue dashed;" id='+b.id+'>'
					+'<a id=goto_'+b.id+' onclick=javascript:gotoPage("'+positionStr+'","'+hrefStr+'","'+titleStr+'")>'+b.title+'</a>'
					+'</li>'
				});
				menuStr +='</ul>';

			}
			menuStr += '</div>'
			menu.content = menuStr;
			$("#"+menuObj.dom).accordion('add',menu);
		});
	}
	$("#"+menuObj.dom).accordion('resize');
}
var index=0;
function gotoPage(position,href,title){
	index++;
	 if ($('#'+position).tabs('exists', title)){
		 $('#'+position).tabs('select', title);
	}else{
		$("#"+position).tabs('add',{
			fit:true,
			title:title,
			//closable:true
		});
		$("#"+position).tabs('select','new page'+index);
	}
}
/**
 * 创建tab
 * @param obj
 * @return
 */
function creatTab(obj){
	$("#"+obj.dom).tabs(obj);
	return $("#"+obj.dom);
}

/**
 * 创建btn按钮
 * @param btnObj
 * @return
 */
function creatBtn(btnObj){
	$("#"+btnObj.dom).css({"margin":"20px"}).append("<a id='btn_"+btnObj.dom+"'></a>");
	btnObj.property.id = 'btn_'+btnObj.dom;
	$("#btn_"+btnObj.dom).linkbutton(btnObj.property);
	return $("#btn_"+btnObj.dom);
}
/**
 * 创建文本框
 * @param txtObj
 * @return
 */
function creatTextbox(txtObj){
	$('#'+txtObj.dom).textbox(txtObj.property);
	return $('#'+txtObj.dom);
}
/**
 * 创建日期组件
 * @param dateBox
 * @return
 */
function creatDatebox(dateBox){
	$("#"+dateBox.dom).datebox(dateBox.property);
	return $("#"+dateBox.dom);
}
/**
 * 转换为国外时间格式
 */
formatterDate = function(date) {
	var day = date.getDate() > 9 ? date.getDate() : "0" + date.getDate();
	var month = (date.getMonth() + 1) > 9 ? (date.getMonth() + 1) : "0"
	+ (date.getMonth() + 1);
	return date.getFullYear() + '-' + month + '-' + day;
}
/**
 * 提示
 * @param msgInfo
 * @param message
 * @return
 */
function message(msgInfo,message){
	var infoStr = "";
	switch(msgInfo){
		case 'info':{
			infoStr = "提示";
		}
		break;
		case 'warning':{
			infoStr = "警告";
		}
		break;
		case 'message':{
			infoStr = "信息";
		}
		break;
		case 'error':{
			infoStr = "错误";
		}
		break;
		case 'abnormal':{
			infoStr = "异常";
		}
		break;
		default:{
			infoStr = "提示";
		}
		break;
	}
	$.messager.alert(infoStr,message);
}

