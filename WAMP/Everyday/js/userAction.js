$(function(){
	//图表初始化
	a =[["一月",4,1,2,5], ["二月",1,1,1,9], ["三月",7,2,5,4], ["四月",5,3,4,2], ["五月",8,1,9,5], ["六月",2,5,3,3]],
		$("#histogramContainer").schema({
			type : 'histo',
			event : a,
			items : ["足球","篮球","排球","冰球"],
			diagramWidth : 2,
			histoWidth : 5,
			groupWidth : 20,
			histoColor : ['#be1e2d', '#64669c', '#94d6ec', '#ee8310'],
			canvasBgColor : 'transparent'
		});
	//查询分类属性
	if($("#category").size()!=0)
	{
		queryCateAttr($("#category").val(), false);
		$("#category").change(function(){
			queryCateAttr($("#category").val(), false);
		});	
	}

	$("#eventForm").submit(function(){
		l = $(".radiobutton").size();
		for(var i=0; i<l; i++)
		{
			var v = $('.radiobutton').eq(i).find(":radio:checked").val();
			$('#hiddenRadio' + i).val(v);
		}
		l = $(".checkbox").size();
		var s = "";
		for(var i=0; i<l; i++)
		{
			$('.checkbox').eq(i).find(":checkbox:checked").each(function(){
				s += $(this).val() + ";";
			});
			$('#hiddenCheck' + i).val(s);
			s="";
		}
		if($("#title").val()=="")
		{
			$("#title").addTips({
				word:"标题不能为空",
				width:200,
				position:"right",
				offset:8,
				margin:"-35px 0 0 142px",
				showDuration:500,
				stayDuration:"neverHide"
			});
			return false;
		}
		if($("#starttime").val()==""||$("#starttime").val()=="--:--")
		{
			$("#starttime").addTips({
				word:"必须指定开始时间。",
				width:200,
				position:"top",
				offset:15,
				margin:"-70px 0 0 -56px",
				showDuration:500,
				stayDuration:2000
			});
			return false;
		}
		if($("#endtime").val()==""||$("#endtime").val()=="--:--")
		{
			$("#endtime").addTips({
				word:"必须指定结束时间。",
				width:200,
				position:"top",
				offset:15,
				margin:"-70px 0 0 100px",
				showDuration:500,
				stayDuration:2000
			});
			return false;
		}
		//return false;
	});
	
	$("#date").val(dateFormat(new Date));
	$("#date").focus(function(){
		$(this).pickDate();
	});
})

//日期选择器的点击回调函数
function returnDate(date)
{
	$("#date").val(dateFormat(date)).removeDate(500);
}

//数字小于10前面加0
function checkNum(num)
{
	if(num<10)
	{
		num ="0"+num;
	}
	return num;
}

//日期格式化-参数是日期对象
function dateFormat(date)
{
	y = date.getFullYear();
	m = checkNum(date.getMonth()+1);
	d = checkNum(date.getDate());
	return y + "-" + m + "-" + d;
}

function attrHtml(attr ,ct, update)
{
	r=0;
	c=0;
	var str = "<table>";
	for(var i=0; i<attr.length; i++)
	{
		str += '<tr><td><input type="hidden" name="attrid[]" value="' + attr[i]['attrid'] + '" /><input type="hidden" name="attributeid[]" value="' + attr[i]['aid'] + '" />' + attr[i]['name'] + ': </td>';
		var l = attr[i]['label'].split(" ");
		switch(attr[i]['ctrl_type'])
		{
			case 'textbox':
				str += '<td><input type="text" name="content[]" value="' + attr[i][ct] + '" /></td>';
				break;
			case 'textarea':
				str += '<td><textarea name="content[]">' + attr[i][ct] + '</textarea></td>';
				break;
			case 'radiobutton':
				var slct = -1;
				if(update)
				{
					if(attr[i][ct]!="" || attr[i][ct]!=null)
					{
						slct =parseInt(attr[i][ct]);
					}
				}
				str += '<td class="radiobutton">';
				for(var j=0; j<l.length; j++)
				{
					if(slct == j)
					{
						
						str += '<input type="radio" checked="true" name="radio' + r + '" value="' + j + '" />' + l[j] + ' ';
					}
					else
					{
						str += '<input type="radio" name="radio' + r + '" value="' + j + '" />' + l[j] + ' ';
					}
				}
				str += '<input id="hiddenRadio' + r + '" name="content[]" type="hidden" /></td>';
				r++;
				break;
			case 'checkbox':
				str += '<td class="checkbox">';
				var flag = true;
				for(var j=0; j<l.length; j++)
				{
					if(update)
					{
						var slct = attr[i][ct].split(";");
						for(var x=0; x<slct.length-1; x++)
						{
							if(j == parseInt(slct[x]))
							{
								str += '<input type="checkbox" checked="true" name="check' + c + '"  value="' + j + '" />' + l[j] + ' ';
								flag = false;
								break;
							}
						}
					}
					if(flag)
					{
						str += '<input type="checkbox" name="check' + c + '"  value="' + j + '" />' + l[j] + ' ';
					}
					flag = true;
				}
				str += '<input id="hiddenCheck' + c + '" name="content[]" type="hidden" /></td>';
				c++;
				break;
			case 'select':
				str += '<td><select name="content[]">';
				for(var j=0; j<l.length; j++)
				{
					str += '<option value="' + j + '">' + l[j] + '</option>';
				}
				str += '</select></td>';
				break;
			case 'link':
				str += '<td><input type="text" name="content[]" value="' + attr[i][ct] + '" /></td>';
				break;
			case 'file':
				str += '<td><input type="file" name="content[]"></td>';
				break;
			default:
				break;
		}
		str += '</tr>';
	}
	str += '</table>';
	$("#attributes").prepend(str);
}

function queryCateAttr(cid)
{
	$("#attributes").empty();
	$.ajax({
		type: "POST",
		url: cur_url + "/queryCateAttr/",
		data: "&cid="+cid,
		dataType: "json",
		success: function(attr){
			attrHtml(attr,'label',false);
	   },
	   error: function(){
		 alert("属性查询出错……"+this.url);
	   }
	});
}

function queryAttrContent(eid)
{
	$("#attributes").empty();
	$.ajax({
		type: "POST",
		url: cur_url + "/queryAttrContent/",
		data: "&eid="+eid,
		dataType: "json",
		success: function(content){
			attrHtml(content,'content',true);
		},
		error: function(){
			alert("查询属性内容失败...");
		}
	})
}

function edit(t, eid){
	queryAttrContent(eid);
	var p = $(t).parent().parent();
	$("#date").val(p.find("._date").text());
	$("#title").val(p.find("._title").text());
	$("#starttime").val(p.find("._stTime").text());
	$("#endtime").val(p.find("._edTime").text());
	$("#category option").each(function(i){
		if($(this).val() == p.find("._ctgrId").text())
		{
			$("#category").get(0).options.selectedIndex = i;
		}
	});
	$("#eventid").val(p.find("._evtId").text());

	$("form").attr("action", cur_url+"/update");
	$("#addEvent a.addEvt").show();
	$("#addEvent h1").text("编辑事项");
}

function addEvent()
{
	$("#date").val("");
	$("#title").val("");
	$("#starttime").val("");
	$("#endtime").val("");
	$("#category").get(0).options.selectedIndex = 0;
	queryCateAttr($("#category").val(), false);
	$("form").attr("action", cur_url+"/insert")
	$("#addEvent a.addEvt").hide();
	$("#addEvent h1").text("新增事项");
}

function addAttr()
{
	$("#add").before(
		'<tr>'+
			'<td><input type="text" name="name[]" /></td>'+
			'<td>'+
				'<select name="type[]">'+
					'<option value="textbox">文本框</option>'+
					'<option value="textarea">文本域</option>'+
					'<option value="radiobutton">单选</option>'+
					'<option value="checkbox">多选</option>'+
					'<option value="select">下拉列表</option>'+
					'<option value="file">文件</option>'+
				'</select>'+
			'</td>'+
			'<td><textarea name="label[]"></textarea></td>'+
			'<td><input type="checkbox" name="fill[]" checked="true" /></td>'+
			'<td><a href="javascript:;" onclick="delAttr(this)">删除</a></td>'+
		'</tr>'
	)
}

function delAttr(t)
{
	$(t).parent().parent().remove()
}

function changeCode()
{
	var timenow = new Date().getTime();
	$("#verifyImg").get(0).src = cur_url+'/verify/'+timenow;
}