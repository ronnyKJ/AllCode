if('ontouchstart' in window){
	isPhone = true;
	isPC = false;
	touchstart = 'ontouchstart';
	touchend = 'ontouchend';
	touchmove = 'ontouchmove';
}else{
	isPhone = false;
	isPC = true;
	touchstart = 'onmousedown';
	touchend = 'onmouseup';
	touchmove = 'onmousemove';
}

window._ = function(id){
	return document.getElementById(id);
};

window.$ = function(selector){
	return document.querySelectorAll(selector);
};

window.U = window.Utils = {
	getAngle : function(mx, my, equipment){
		var deltaX = equipment.transformOriginX - mx;
		var deltaY = my - equipment.transformOriginY;
		var tan = deltaY/deltaX;
		var radian = Math.atan2(deltaX, deltaY);
		angle = radian/Math.PI*180;
		return angle - 90;
	}
};

window.E = window.Effect = {
	blink : function(ele){
		ele.style.opacity = 0;
		ele.className += ' blink';
	}
};

window.Ex = window.Experiment = {
	initLayout : function(){
		var con = _('container');
		var ex = _('experiment');
		con.style.width = ex.clientWidth + 'px';
		con.style.height = ex.clientHeight + 'px';
	}
};

window.Eq = window.Equipments = {
	rotateEquipments : [],
	isRotateEquipmentsFlag : false,
	isrotateEquipments : function(currentEquipment){
		return this.rotateEquipments.indexOf(currentEquipment) >= 0;
	},
	parseConf : function(){
		var eles = $('div[data-conf]'), ele, str, conf;
		for(var i=0, l=eles.length; i<l; i++){
			ele = eles[i];
			str = ele.getAttribute('data-conf');
			conf = JSON.parse('{'+str+'}');
			for(var c in conf){
				ele.style[c] = conf[c];
			}
		}
	},
	bindRotate : function(){
		this.rotateEquipments = Array.prototype.slice.apply($('div.rotate'), [0]);
		var eles = this.rotateEquipments, ele, tmpX, tmpY, rect;
		for(var i=0, l=eles.length; i<l; i++){
			ele = eles[i];
			ele.angle=0;
			tmpX = parseInt(ele.style.webkitTransformOriginX);
			tmpY = parseInt(ele.style.webkitTransformOriginY);
			rect = ele.getBoundingClientRect();
			ele.transformOriginX = tmpX + rect.left;
			ele.transformOriginY = tmpY + rect.top;
		}
	},
	processEquipment : function(equipment){
		var type = equipment.getAttribute('data-type');
		switch(type){
			case 'alcoholBurner':
				equipment.setFire && equipment.setFire();
				break;
		}
	},
	equipments : {
		alcoholBurner : {
			init : function(){
				var eles = $('div.alcohol-burner'), ele;
				for(var i=0, l=eles.length; i<l; i++){
					ele = eles[i];
					ele.fire = ele.getElementsByClassName('fire')[0];
				}
			}
		}
	}
};

window.F = window.Feedback = {
	hint : _('hint'),
	showHint : function(text, className){
		this.hint.className = className;
		this.hint.innerHTML = text;
	}
};

(function(){
	var init = function(){
		Experiment.initLayout();
		Eq.parseConf();//解析元素的conf
		Eq.bindRotate();//绑定旋转的元素，class有rotate
		Eq.equipments.alcoholBurner.init();

		// 鼠标动作绑定
		var d = document, isMouseDown = false, angle = 0;

		d[touchstart] = function(e){
			// e.preventDefault();
			isMouseDown = true;
			currentEquipment = e.target;
			Eq.isRotateEquipmentsFlag = Eq.isrotateEquipments(currentEquipment);

			isPhone && Eq.processEquipment(e.target);
		}

		d[touchend] = function(e){
			// e.preventDefault();
			isMouseDown = false;
			Eq.isRotateEquipmentsFlag = false;
			currentEquipment.angle = angle;
		}

		d[touchmove] = function(e){
			e.preventDefault();
			if(isMouseDown && Eq.isRotateEquipmentsFlag){
				if(isPC){
					var eX = e.clientX, eY = e.clientY;
				}else{
					var eX = e.touches[0].pageX, eY = e.touches[0].pageY;
				}

				angle = U.getAngle(eX, eY, currentEquipment);
				currentEquipment.style.webkitTransform = 'rotate(' + angle + 'deg)';
			}
		}
		
		if(isPC){
			d['onclick'] = function(e){
				// e.preventDefault();
				Eq.processEquipment(e.target);
			}
		}
	};

	init();
})();