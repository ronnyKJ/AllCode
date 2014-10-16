var d = document,
	isMouseDown = false,
	currentElement,
	tubeAngle = 0,
	PI = Math.PI,
	atan2 = Math.atan2;

function radian2angle(val){
	return parseInt(val/PI*180);
}

var experiment = _('experiment'),
	tube = _('tube'),
	fire = _('fire'),
	alcoholBurner = _('alcohol_burner'),
	hint = _('hint'),
	mask = _('mask'),
	bubble = _('bubble')
	;

var tubeTransformOriginX = 255+30+100,
	tubeTransformOriginY = 40+113+70;

function showHint(text, className){
	hint.className = className;
	hint.innerHTML = text;
}

function getAngle(x, y){
	var deltaX = tubeTransformOriginX - x;
	var deltaY = y - tubeTransformOriginY;
	var tan = deltaY/deltaX;
	var radian = atan2(deltaX, deltaY);
	angle = radian2angle(radian);
	return angle - 90;
}

alcoholBurner.onclick = function(){
	hint.className = '';
	hint.innerHTML = '';
	setTimeout(function(){
		if(tubeAngle<0){
			showHint('试管口要朝下', 'hint-wrong');
		}else if(tubeAngle<4 && tubeAngle>=0){
			showHint('试管倾斜度不够呢', 'hint-wrong');
		}else if(tubeAngle>6){
			showHint('试管倾斜度太大了', 'hint-wrong');
		}else{
			showHint('孩子你太有前途啦！<br>等氧气开始生成刷新页面再来一遍吧', 'hint-right');
			fire.style.display = 'block';
			hint.style.opacity = 1;
			mask.style.display = 'block';
			setTimeout(function(){
				bubble.style.display = 'block';
			}, 600);
		}
	}, 0);
}

d.onmousedown = function(e){
	isMouseDown = true;
	currentElement = e.target;
}

d.onmouseup = function(e){
	isMouseDown = false;
}

d.onmousemove = function(e){
	if(isMouseDown && isElement('tube', currentElement)){
		tubeAngle = getAngle(e.clientX, e.clientY);
		tube.style.webkitTransform = 'rotate(' + tubeAngle + 'deg)';
	}
}