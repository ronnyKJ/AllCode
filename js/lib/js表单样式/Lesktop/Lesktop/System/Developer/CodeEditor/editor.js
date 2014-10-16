function PreventDefault(evt)
{
	if (evt.preventDefault != undefined)
	{
		evt.preventDefault();
	}
	else
	{
		evt.returnValue = false;
	}
}

function CancelBubble(evt)
{
	if (evt && evt.stopPropagation != undefined) evt.stopPropagation();
	else evt.cancelBubble = true;
}

function SnippetEditor(container, id, title, text)
{
	var This = this;
	
	container.innerHTML =
	"<div class='snippetEditor' style='border-width:1px; padding:0px; margin:0px; '>" +
		"<div class='toolbar' style='border-width:0px; padding:0px; margin:0px; '>" +
			"<div class='title'></div>" +
			"<div class='fsbtn'>全屏</div>" +
			"<div class='fsbtn' title='Ctrl + Shift + F'>格式化</div>" +
		"</div>" +
		"<div style='border-width:0px; margin:0px; margin-left:0px;'>" +
			"<textarea style='border-width:0px; ' wrap='off'></textarea>" +
		"</div>" +
	"</div>";

	var editor = container.firstChild;
	var toolbar = editor.firstChild;
	var codeContainer = editor.childNodes[1];
	var code = codeContainer.firstChild;

	var fsbtn = toolbar.childNodes[1];
	toolbar.firstChild.innerHTML = title;
	code.value = text;

	var formatBtn = toolbar.childNodes[2];
	formatBtn.onclick = function()
	{
		code.value = js_beautify(code.value);
		code.focus();
	}

	OnResize.Attach(resize);

	code.onkeydown = function(evt)
	{
		if (evt == undefined) evt = window.event;
		if (evt.keyCode == 9 && !evt.shiftKey && !evt.ctrlKey && !evt.altKey)
		{
			var scrollTop = this.scrollTop;
			if (this.setSelectionRange)
			{
				var sS = this.selectionStart;
				var sE = this.selectionEnd;
				this.value = this.value.substring(0, sS) + "    " + this.value.substr(sE);
				this.setSelectionRange(sS + 4, sS + 4);
				this.focus();
				PreventDefault(evt);
			}
			else if (this.createTextRange)
			{
				document.selection.createRange().text = "    ";
				this.focus();
				PreventDefault(evt);
			}
			this.scrollTop = scrollTop;
		}
		else if (evt.keyCode == 70 && evt.shiftKey && evt.ctrlKey && !evt.altKey)
		{
			code.value = js_beautify(code.value);
			PreventDefault(evt);
			CancelBubble(evt);
			code.focus();
		}
	}

	function resize(width, height)
	{
		var margin = parseInt(container.style.marginLeft);

		if (width > 0)
		{
			editor.style.width = (width - margin - 36) + "px";
			editor.style.height = 200 + "px";

			toolbar.style.width = parseInt(editor.style.width) + "px";
			toolbar.style.height = "24px";

			codeContainer.style.width = parseInt(editor.style.width) + "px";
			codeContainer.style.height = (parseInt(editor.style.height) - 24) + "px";

			code.style.width = parseInt(editor.style.width) + "px";
			code.style.height = (parseInt(editor.style.height) - 26) + "px";
		}
	}

	this.GetCode = function()
	{
		return code.value;
	}

	this.SetCode = function(text)
	{
		code.value = text;
	}

	this.GetTitle = function()
	{
		return toolbar.firstChild.innerHTML;
	}

	this.Focus = function()
	{
		code.focus();
	}

	fsbtn.onclick = function()
	{
		FSEID = id;
		FSE.SetTitle(title);
		FSE.SetCode(This.GetCode());
		Switch(1);
	}

	code.onfocus = function()
	{
		toolbar.style.backgroundColor = "#6600CC";
	}

	code.onblur = function()
	{
		toolbar.style.backgroundColor = "#3366CC";
	}

	resize(frame.GetClientWidth(), frame.GetClientHeight());
}

function FullScreenEditor()
{
	var This = this;
	
	var container = document.body.childNodes[1];

	container.innerHTML =
	"<div class='snippetEditor' style='border-width:0px; padding:0px; margin:0px; '>" +
		"<div class='toolbar' style='border-width:0px; padding:0px; margin:0px; '>" +
			"<div class='title'></div>" +
			"<div class='fsbtn'>还原</div>" +
			"<div class='fsbtn' title='Ctrl + Shift + F'>格式化</div>" +
		"</div>" +
		"<div style='border-width:0px; margin:0px; margin-left:0px;'>" +
			"<textarea style='border-width:0px; ' wrap='off'></textarea>" +
		"</div>" +
	"</div>";

	var editor = container.firstChild;
	var toolbar = editor.firstChild;
	var codeContainer = editor.childNodes[1];
	var code = codeContainer.firstChild;

	var fsbtn = toolbar.childNodes[1];

	var formatBtn = toolbar.childNodes[2];
	formatBtn.onclick = function()
	{
		code.value = js_beautify(code.value);
		code.focus();
	}

	fsbtn.onclick = function()
	{
		Switch(0);
	}

	OnResize.Attach(resize);

	code.onkeydown = function(evt)
	{
		if (evt == undefined) evt = window.event;
		if (evt.keyCode == 9 && !evt.shiftKey && !evt.ctrlKey && !evt.altKey)
		{
			var scrollTop = this.scrollTop;
			if (this.setSelectionRange)
			{
				var sS = this.selectionStart;
				var sE = this.selectionEnd;
				this.value = this.value.substring(0, sS) + "    " + this.value.substr(sE);
				this.setSelectionRange(sS + 4, sS + 4);
				this.focus();
				PreventDefault(evt);
			}
			else if (this.createTextRange)
			{
				document.selection.createRange().text = "    ";
				this.focus();
				PreventDefault(evt);
			}
			this.scrollTop = scrollTop;
		}
		else if (evt.keyCode == 70 && evt.shiftKey && evt.ctrlKey && !evt.altKey)
		{
			code.value = js_beautify(code.value);
			PreventDefault(evt);
			CancelBubble(evt);
			code.focus();
		}
	}

	function resize(width, height)
	{
		if (width > 0)
		{
			width -= 2;
			height -= 2;
			editor.style.width = width + "px";
			editor.style.height = height + "px";

			toolbar.style.width = width + "px";
			toolbar.style.height = "24px";

			codeContainer.style.width = width + "px";
			codeContainer.style.height = (height - 24) + "px";

			code.style.width = width + "px";
			code.style.height = (height - 26) + "px";
		}
	}

	this.GetCode = function()
	{
		return code.value;
	}

	this.SetCode = function(text)
	{
		code.value = text;
	}

	this.SetTitle = function(title)
	{
		toolbar.firstChild.innerHTML = title;
	}

	this.Focus = function()
	{
		code.focus();
	}

	code.onfocus = function()
	{
		toolbar.style.backgroundColor = "#6600CC";
	}

	code.onblur = function()
	{
		toolbar.style.backgroundColor = "#3366CC";
	}

	resize(frame.GetWidth(), frame.GetHeight());
}

function Switch(index)
{
	if (index == 0)
	{
		document.body.style.overflow="auto";
		document.body.childNodes[0].style.display = "block";
		document.body.childNodes[1].style.display = "none";
		
		if (FSEID != "")
		{
			CodeEditor[FSEID].SetCode(FSE.GetCode());
			CodeEditor[FSEID].Focus();
			FSEID = "";
		}
	}
	else
	{
		document.body.style.overflow="hidden";
		document.body.childNodes[0].style.display = "none";
		document.body.childNodes[1].style.display = "block";
		FSE.Focus();
	}
}

var CodeEditor = {};

window.CodeEditor = CodeEditor;

CodeEditor.Load = function(code)
{
	Switch(0);
	document.body.firstChild.innerHTML = code;
	sh_highlightDocument();
	return document.body.firstChild;
}

CodeEditor.AddEditor = function(id, title, text)
{
	var editor = new SnippetEditor(document.getElementById(id), id, title, text);
	CodeEditor[id] = editor;
	return editor;
}

CodeEditor.Read = function(id)
{
	if (FSEID == id)
	{
		CodeEditor[FSEID].SetCode(FSE.GetCode());
	}
	
	return CodeEditor[id] == undefined ? "" : CodeEditor[id].GetCode();
}

CodeEditor.ScrollIntoView = function(id)
{
	if (FSEID == "")
	{
		var ctrl = document.getElementById(id);
		if (ctrl != null)
		{
			ctrl.scrollIntoView();
			setTimeout(
				function() { CodeEditor[id].Focus(); },
				10
			);
			window.scrollBy(-20000, 0);
		}
	}
	else
	{
		if (FSEID != "")
		{
			CodeEditor[FSEID].SetCode(FSE.GetCode());
			FSEID = "";
		}
		FSEID = id;
		FSE.SetTitle(CodeEditor[FSEID].GetTitle());
		FSE.SetCode(CodeEditor[FSEID].GetCode());
		FSE.Focus();
	}
}