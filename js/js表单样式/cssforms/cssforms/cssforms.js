/*#############################################################
Name: Forms to CSS
Version: 0.7

Author: Utom
URL: http://utombox.com/

Author: Explon
Mail: explon@gmail.com
#############################################################*/

var inputs = document.getElementsByTagName('input');
var textareas = document.getElementsByTagName('textarea');
var selects = document.getElementsByTagName('select');
var isIE = (document.all && window.ActiveXObject && !window.opera) ? true : false;

function $(id)
{
	return document.getElementById(id);
}

function stopBubbling (ev)
{	
	ev.stopPropagation();
}

function rInputs()
{
	for (i = 0; i < inputs.length; i++)
	{	
		if (inputs[i].type == 'radio')
		{
		    inputs[i].className = 'transparent';
		    rRadios(i);
		}
		else if (inputs[i].type == 'checkbox')
		{
		    inputs[i].className = 'transparent';
		    rCheckboxes(i);
		}
		else if ((inputs[i].type == 'text' || inputs[i].type == 'password') && inputs[i].getAttribute('rel') != 'no_init_style')
		{
		    rTextPassword(i);
		}
		else if ((inputs[i].type == 'submit' || inputs[i].type == 'button') && inputs[i].getAttribute('rel') != 'no_init_style')
		{
		    rSubmits(i);
		}
	}
}

function rTextareas()
{
	for (i = 0; i < textareas.length; i++){
		if (textareas[i].getAttribute('rel') != 'no_init_style')
		{
			textareas[i].className = 'tag_textarea';	
			textareas[i].onblur = function()
			{
				this.className = 'tag_textarea';
			}
			textareas[i].onfocus = function()
			{
				this.className = 'tag_textarea_focus';
			}
			textareas[i].onmouseover = function()
			{	
				if (this.className != 'tag_textarea_focus')
				{
					this.className = 'tag_textarea_hover';
				}
			}
			textareas[i].onmouseout = function()
			{	
				if (this.className != 'tag_textarea_focus')
				{
					this.className = 'tag_textarea';
				}
			}
		}
	}
}

function rSubmits(i)
{
	inputs[i].className = 'type_submit';
	inputs[i].onmouseover = function()
	{
		this.className='type_submit_hover';
	}
	inputs[i].onmouseout =  function()
	{
		this.className='type_submit';
	}
}

function rTextPassword(i)
{
	inputs[i].className = 'type_text';	
	inputs[i].onblur = function()
	{
		this.className = 'type_text';
	}
	inputs[i].onfocus = function()
	{
		this.className = 'type_text_focus';
	}
	inputs[i].onmouseover = function()
	{	
		if (this.className != 'type_text_focus')
		{
			this.className = 'type_text_hover';
		}
	}
	inputs[i].onmouseout =  function()
	{	
		if (this.className != 'type_text_focus')
		{
			this.className = 'type_text';
		}
	}
}

function rRadios(i)
{
	radio_type = document.createElement('div');
		radio_type.id = 'radio_' + inputs[i].name + '_' + inputs[i].id;
		radio_type.className = 'type_radio';
		if (inputs[i].checked)
		{
			radio_type.className = 'type_radio_checked';
		}
		radio_type.style.cursor = 'pointer';
		radio_type.style.position = 'absolute';
		radio_type.style.display = 'inline';
		radio_type.style.zIndex = '998';
	inputs[i].parentNode.insertBefore(radio_type, inputs[i]);	

	radio_type.onmouseover = new Function("mouseOverRadios('" + radio_type.id + "')");
	radio_type.onmouseout = new Function("mouseOutRadios('" + radio_type.id + "')");
	radio_type.onclick = new Function("clickRadios(" + i + ",'" + inputs[i].name + "','" + inputs[i].id + "')");

}

function rCheckboxes(i)
{
	checkbox_type = document.createElement('div');
		checkbox_type.id = 'checkbox_' + inputs[i].name + '_' + inputs[i].id;
		checkbox_type.className = 'type_checkbox';
		if (inputs[i].checked)
		{
			checkbox_type.className = 'type_checkbox_checked';
		}
		checkbox_type.style.cursor = 'pointer';
		checkbox_type.style.position = 'absolute';
		checkbox_type.style.display = 'inline';
		checkbox_type.style.zIndex = '998';
	inputs[i].parentNode.insertBefore(checkbox_type,inputs[i]);
	
	checkbox_type.onmouseover = new Function("mouseOverCheckboxes('" + checkbox_type.id + "')");
	checkbox_type.onmouseout = new Function("mouseOutCheckboxes('" + checkbox_type.id + "')");
	checkbox_type.onclick = new Function("clickCheckboxes(" + i + ",'" + inputs[i].name + "','" + inputs[i].id + "')");
}

function mouseOverRadios(id){
	if ($(id).className == 'type_radio')
	{
		$(id).className = 'type_radio_hover';
	}
	else if ($(id).className == 'type_radio_checked')
	{
		$(id).className = 'type_radio_checked_hover';
	}
}

function mouseOutRadios(id){
	if ($(id).className == 'type_radio_hover')
	{
		$(id).className = 'type_radio';
	}
	else if ($(id).className == 'type_radio_checked_hover')
	{
		$(id).className = 'type_radio_checked';
	}
}

function mouseOverCheckboxes(id)
{
	if ($(id).className == 'type_checkbox')
	{
		$(id).className = 'type_checkbox_hover';
	}
	else if ($(id).className == 'type_checkbox_checked')
	{
		$(id).className = 'type_checkbox_checked_hover';
	}
}

function mouseOutCheckboxes(id)
{
	if ($(id).className == 'type_checkbox_hover')
	{
		$(id).className = 'type_checkbox';
	}
	else if ($(id).className == 'type_checkbox_checked_hover')
	{
		$(id).className = 'type_checkbox_checked';
	}
}

function clickRadios(i, name, id)
{
	radioid = 'radio_' + name + '_' + id ;
	for (n = 0; n < inputs.length; n++)
	{	
		if (inputs[n].type == 'radio')
		{			
			if (inputs[n].name == name)
			{
				$('radio_' + inputs[n].name + '_' + inputs[n].id).className = 'type_radio' ;
			}
		}
	}
	if ($(radioid).className == 'type_radio')
	{
		$(radioid).className = 'type_radio_checked_hover';
	}
	
	inputs[i].click();
}


function clickCheckboxes(i, name, id)
{
	inputs[i].click();
	
	checkboxid = 'checkbox_' + name + '_' + id;
	if ($(checkboxid).className == 'type_checkbox_hover')
	{
		$(checkboxid).className = 'type_checkbox_checked_hover';
	}
	else if ($(checkboxid).className == 'type_checkbox_checked_hover')
	{
		$(checkboxid).className = 'type_checkbox_hover';		
	}
}

function clickLabelsSelect(name)
{
	var selectid = 'select_info_' + name;
	var optionul = 'options_' + name;

	if ($(selectid).className == 'tag_select')
	{
		$(selectid).className = 'tag_select_open';
		$(optionul).style.display = '';
	}
	
}

function rSelects()
{
	for (i = 0; i < selects.length; i++)
	{
		if (selects[i].getAttribute('rel') != 'no_init_style')
		{
			selects[i].style.display = 'none';
			select_tag = document.createElement('div');
				select_tag.id = 'select_' + selects[i].name;
				select_tag.className = 'select_box';
			selects[i].parentNode.insertBefore(select_tag, selects[i]);
			select_info = document.createElement('div');	
				select_info.id = 'select_info_' + selects[i].name;
				select_info.className = 'tag_select';
				select_info.style.cursor = 'pointer';
			select_tag.appendChild(select_info);
			select_ul = document.createElement('ul');	
				select_ul.id = 'options_' + selects[i].name;
				select_ul.className = 'tag_options';
				select_ul.style.position = 'absolute';
				select_ul.style.display = 'none';
				select_ul.style.zIndex = '999';
			select_tag.appendChild(select_ul);
			rOptions(i, selects[i].name);		
			mouseSelects(selects[i].name);
			
			if (isIE)
			{
				selects[i].onclick = new Function("clickLabelsSelect('" + selects[i].name + "'); window.event.cancelBubble = true;");
			}
			else if (!isIE)
			{
				selects[i].onclick = new Function("clickLabels3('" + selects[i].name + "')");
				selects[i].addEventListener("click", stopBubbling, false);
			}
		}
	}
}


function rOptions(i, name)
{
	var options = selects[i].getElementsByTagName('option');
	var options_ul = 'options_' + name;
	for (n=0;n<selects[i].options.length;n++)
	{	
		option_li = document.createElement('li');
			option_li.style.cursor = 'pointer';
			option_li.className = 'open';
		$(options_ul).appendChild(option_li);
		option_text = document.createTextNode(selects[i].options[n].text);
		option_li.appendChild(option_text);
		option_selected = selects[i].options[n].selected;
		if (option_selected)
		{
			option_li.className = 'open_selected';
			option_li.id = 'selected_' + name;
			$('select_info_' + name).appendChild(document.createTextNode(option_li.innerHTML));
		}		
		option_li.onmouseover = function()
		{
			this.className = 'open_hover';
		}
		option_li.onmouseout = function()
		{
			if (this.id == 'selected_' + name)
			{
				this.className = 'open_selected';
			}
			else
			{
				this.className = 'open';
			}
		} 
	
		option_li.onclick = new Function("clickOptions(" + i + "," + n + ",'" + selects[i].name + "')");
	}
}

function mouseSelects(name)
{
	var sincn = 'select_info_' + name;
	$(sincn).onmouseover = function()
	{
		if (this.className == 'tag_select') this.className = 'tag_select_hover';
	}
	$(sincn).onmouseout = function()
	{
		if (this.className == 'tag_select_hover') this.className = 'tag_select';
	}
	if (isIE)
	{
		$(sincn).onclick = new Function("clickSelects('" + name + "');window.event.cancelBubble = true;");
	}
	else if (!isIE)
	{
		$(sincn).onclick = new Function("clickSelects('" + name + "');");
		$('select_info_' + name).addEventListener("click", stopBubbling, false);
	}

}

function clickSelects(name)
{
	var sincn = 'select_info_' + name;
	var sinul = 'options_' + name;	

	for (i=0;i<selects.length;i++)
	{	
		if (selects[i].name == name)
		{				
			if ( $(sincn).className == 'tag_select_hover')
			{
				$(sincn).className = 'tag_select_open';
				$(sinul).style.display = '';
			}
			else if ( $(sincn).className == 'tag_select_open')
			{
				$(sincn).className = 'tag_select_hover';
				$(sinul).style.display = 'none';
			}
		}
		else
		{
			$('select_info_' + selects[i].name).className = 'tag_select';
			$('options_' + selects[i].name).style.display = 'none';
		}
	}

}

function clickOptions(i, n, name)
{		
	var li = $('options_' + name).getElementsByTagName('li');
	$('selected_' + name).className = 'open';
	$('selected_' + name).id = '';
	li[n].id = 'selected_' + name;
	li[n].className = 'open_hover';
	$('select_' + name).removeChild($('select_info_' + name));
	select_info = document.createElement('div');
		select_info.id = 'select_info_' + name;
		select_info.className = 'tag_select';
		select_info.style.cursor = 'pointer';
	$('options_' + name).parentNode.insertBefore(select_info,$('options_' + name));
	mouseSelects(name);
	$('select_info_' + name).appendChild(document.createTextNode(li[n].innerHTML));
	$( 'options_' + name ).style.display = 'none' ;
	$( 'select_info_' + name ).className = 'tag_select';
	selects[i].options[n].selected = 'selected';

}

window.onload = function(e)
{
	bodyclick = document.getElementsByTagName('body').item(0);
	rInputs();
	rTextareas();
	rSelects();
	bodyclick.onclick = function()
	{
		for (i = 0; i < selects.length; i++)
		{	
			$('select_info_' + selects[i].name).className = 'tag_select';
			$('options_' + selects[i].name).style.display = 'none';
		}
		
		checkInputs();
	}
}

function checkInputs()
{
	for (i = 0; i < inputs.length; i++)
	{	
		if (inputs[i].type == 'checkbox')
		{
			checkboxid = 'checkbox_' + inputs[i].name + '_' + inputs[i].id;
			
			if (inputs[i].checked == true)
			{
				if ($(checkboxid).className == 'type_checkbox_hover')
				{
					$(checkboxid).className = 'type_checkbox_checked_hover';
				}
				else
				{
					$(checkboxid).className = 'type_checkbox_checked';
				}
			}
			else if (inputs[i].checked == false)
			{
				if ($(checkboxid).className == 'type_checkbox_checked_hover')
				{
					$(checkboxid).className = 'type_checkbox_hover';
				}
				else
				{
					$(checkboxid).className = 'type_checkbox';
				}
			}
		}
		else if (inputs[i].type == 'radio')
		{
			radioid = 'radio_' + inputs[i].name + '_' + inputs[i].id;
			
			if (inputs[i].checked == true)
			{
				if ($(radioid).className == 'type_radio_hover')
				{
					$(radioid).className = 'type_radio_checked_hover';
				}
				else if ($(radioid).className == 'type_radio_checked_hover')
				{
					// Nothing to do.
				}
				else
				{
					$(radioid).className = 'type_radio_checked';
				}
			}
			else if (inputs[i].checked == false)
			{
				$(radioid).className = 'type_radio';
			}
		}
	}
}


function checkAllCheckboxs(form, prefix, stats)
{	
	for (var i = 0; i < form.elements.length; i++)
	{
		var e = form.elements[i];
		
		if (e.name && e.type == 'checkbox' && (!prefix || (prefix && e.name.match(prefix))))
		{
			e.checked = stats;
		}
	}
}