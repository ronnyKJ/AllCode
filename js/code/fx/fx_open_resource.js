function $fx(initElm){
	if(initElm.nodeType && initElm.nodeType==1)
		var elm = initElm;
	else if(String(initElm).match(/^#([^$]+)$/i)){
		var elm = document.getElementById(RegExp.$1+'');
		if(!elm)
			return null;
	}else 
		return null;
		
	if(typeof(elm._fx) != 'undefined' && elm._fx){
		elm._fx._addSet();
		return elm;
	};
	
	elm.fxVersion = 0.1;
	elm._fx = {};
	elm._fx.sets = [];
	elm._fx._currSet = 0;
	
	if(typeof(elm._fxTerminated) != 'undefined')
		try{delete elm._fxTerminated}catch(err){elm._fxTerminated = null}
	
	var units = {
		'left|top|right|bottom|width|height|margin|padding|spacing|backgroundx|backgroundy': 'px',
		'font': 'pt',
		'opacity': ''
	};
	
	var isIE = !!navigator.userAgent.match(/MSIE/ig);
	
	var required = {delay: 100, step:5, unit: ''};
	
	var handlers = {
		opacity: function(val, unit){
			val = parseInt(val); 
			if(isNaN(val)){
				if(isIE){
					var matches = (new RegExp('alpha\\s*\\(opacity\\s*=\\s*(\\d+)\\)')).exec(elm.style.filter+'');
					if(matches)
						return parseInt(matches[1]);
					else
						return 1;
				}else{
					return Math.round((elm.style.opacity ? parseFloat(elm.style.opacity) : 1) * 100);
				}
			}else{
				val = Math.min(100, Math.max(0, val));
				if(isIE){
					elm.style.zoom = 1;
					elm.style.filter = 'alpha(opacity='+val+');';
				}else{
					elm.style.opacity = val/100;
				}
			}
		},
		'backgroundx': function(val, unit){
			val = parseInt(val);
			var x = 0, y = 0;
			var matches = (new RegExp('^(-?\\d+)[^\\d\\-]+(-?\\d+)')).exec(elm.style.backgroundPosition+'');
			if(matches){
				x = parseInt(matches[1]);
				y = parseInt(matches[2]);
			}
			if(isNaN(val))
				return x;
			else{
				elm.style.backgroundPosition = val+unit+' '+y+unit;  
			}
		},
		'backgroundy': function(val, unit){
			val = parseInt(val);
			var x = 0, y = 0;
			var matches = (new RegExp('^(-?\\d+)[^\\d\\-]+(-?\\d+)')).exec(elm.style.backgroundPosition+'');
			if(matches){
				x = parseInt(matches[1]);
				y = parseInt(matches[2]);
			}
			if(isNaN(val))
				return y;
			else{
				elm.style.backgroundPosition = x+unit+' '+val+unit;  
			}
		}
	};
	
	var defaults = {
		width: function(){
			return parseInt(elm.offsetWidth)
		},
		height: function(){
			return parseInt(elm.offsetHeight)
		},
		left: function(){
			var left = 0;
			for(var el=elm; el; el=el.offsetParent) left+=parseInt(el.offsetLeft);
			return left;
		},
		top: function(){
			var top = 0;
			for(var el=elm; el; el=el.offsetParent) top += parseInt(el.offsetTop);
			return top;
		}
	};
	
	elm.fxAddSet = function(){
		this._fx._addSet();
		return this;
	};
	
	elm.fxHold = function(time, set){
		if(elm._fx.sets[this._fx._currSet]._isrunning)
			return this;
			
		var set = parseInt(set);
		this._fx.sets[isNaN(set) ? this._fx._currSet : set]._holdTime = time;
		return this; 
	};
	
	elm.fxAdd = function(params){
		var currSet = this._fx._currSet;

		if(this._fx.sets[currSet]._isrunning)
			return this;
		
		for(var p in required){
			if(!params[p])
				params[p] = required[p]
		};
		if(!params.unit){
			for(var mask in units)
				if((new RegExp(mask,'i').test(params.type))){
					params.unit = units[mask];
					break;
				}
		};
		
		params.onstart = (params.onstart && params.onstart.call) ? params.onstart : function(){}; 
		params.onfinish = (params.onfinish && params.onfinish.call) ? params.onfinish : function(){}; 
		
		if(!this._fx[params.type]){
			if(handlers[params.type])
				this._fx[params.type] = handlers[params.type];
			else{
				var elm = this;
				this._fx[params.type] = function(val, unit){
					if(typeof(val)=='undefined')
						return parseInt(elm.style[params.type]);
					else
						elm.style[params.type] = parseInt(val) + unit;
				}
			}
		};
		if(isNaN(params.from)){
			if(isNaN(this._fx[params.type]()))
				if(defaults[params.type])
					params.from = defaults[params.type](); 
				else
					params.from = 0;
			else
				params.from = this._fx[params.type]();
		}
		params._initial = params.from;
		this._fx[params.type](params.from, params.unit);
		this._fx.sets[currSet]._queue.push(params);
		return this;
	};
	
	elm.fxRun = function(finalCallback, loops, loopCallback){
		var currSet = elm._fx._currSet;
		
		if(this._fx.sets[currSet]._isrunning){
			return this;
		}
		
		setTimeout(function(){
			if(elm._fx.sets[currSet]._isrunning)
				return elm;
			elm._fx.sets[currSet]._isrunning = true;
			
			if(elm._fx.sets[currSet]._effectsDone > 0)
				return elm;
			elm._fx.sets[currSet]._onfinal = (finalCallback && finalCallback.call) ? finalCallback : function(){};
			elm._fx.sets[currSet]._onloop = (loopCallback && loopCallback.call) ? loopCallback : function(){};
			if(!isNaN(loops))
				elm._fx.sets[currSet]._loops = loops;
			 		
			for(var i=0; i<elm._fx.sets[currSet]._queue.length; i++){
				elm._fx.sets[currSet]._queue[i].onstart.call(elm);
				elm._fx._process(currSet, i);
			}
		}, elm._fx.sets[currSet]._holdTime);
		
		return this;
	};
	
	elm.fxPause = function(status, setNum){
		this._fx.sets[!isNaN(setNum) ? setNum : this._fx._currSet]._paused = status;
		return this;
	};
	
	elm.fxStop = function(setNum){
		this._fx.sets[!isNaN(setNum) ? setNum : this._fx._currSet]._stoped = true;
		return this;
	};
	
	elm.fxReset = function(){
			for(var i=0; i<this._fx.sets.length; i++){
				for(var j=0; j<this._fx.sets[i]._queue.length; j++){
					var params = this._fx.sets[i]._queue[j];
					if(isNaN(params._initial))
						this._fx[params.type]('','');
					else
						this._fx[params.type](params._initial, params.unit);
				}
			}
			var del = ['_fx','fxHold','fxAdd','fxAddSet','fxRun','fxPause','fxStop','fxReset'];
			for(var i=0; i<del.length; i++)
				try{delete this[del[i]]}catch(err){this[del[i]] = null}
			this._fxTerminated = true;
	};
	
	elm._fx._addSet = function(){
		var currSet = this.sets.length;
		this._currSet = currSet;
		this.sets[currSet] = {};
		this.sets[currSet]._loops = 1;
		this.sets[currSet]._stoped = false;
		this.sets[currSet]._queue = [];
		this.sets[currSet]._effectsDone = 0;
		this.sets[currSet]._loopsDone = 0;
		this.sets[currSet]._holdTime = 0;
		this.sets[currSet]._paused = false;
		this.sets[currSet]._isrunning = false;
		this.sets[currSet]._onfinal = function(){};
		
		return this;
	};
	
	elm._fx._process = function(setNum, effectNum){
		if(!this.sets[setNum] || this.sets[setNum]._stoped || elm._fxTerminated)
			return;
		var ef = this.sets[setNum]._queue[effectNum];
		var param = this[ef.type]();
		
		if((ef.step > 0 && param + ef.step <= ef.to) || (ef.step < 0 && param + ef.step >= ef.to)){
			if(!this.sets[setNum]._paused)
				this[ef.type](param + ef.step, ef.unit);
			var inst = this;
			setTimeout(function(){if(inst._process) inst._process(setNum, effectNum)}, ef.delay);
		}else{
			this[ef.type](ef.to, ef.unit);
			this.sets[setNum]._effectsDone++;
			ef.onfinish.call(elm);
			if(this.sets[setNum]._queue.length == this.sets[setNum]._effectsDone){
				this.sets[setNum]._effectsDone = 0;
				this.sets[setNum]._loopsDone++;
				this.sets[setNum]._onloop.call(elm, this.sets[setNum]._loopsDone);
				if(this.sets[setNum]._loopsDone < this.sets[setNum]._loops || this.sets[setNum]._loops == -1){
					for(var i=0; i < this.sets[setNum]._queue.length; i++){
						this[ef.type](ef.from, this.sets[setNum]._queue[i].unit);
						this.sets[setNum]._queue[i].onstart.call(elm, this.sets[setNum]._loopsDone);
						this._process(setNum, i);
					}
				}else{
					this.sets[setNum]._onfinal.call(elm);
				}
			}
		}
	};
	
	elm._fx._addSet();
	return elm;
}