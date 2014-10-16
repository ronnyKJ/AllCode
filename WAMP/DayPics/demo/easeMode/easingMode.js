easingMode = {
	easeInBack: function(pos){
		var s = 1.70158;
		return (pos)*pos*((s+1)*pos - s);
	},
	easeOutBack: function(pos){
		var s = 1.70158;
		return (pos=pos-1)*pos*((s+1)*pos + s) + 1;
	},
	easeInOutCubic: function(pos){
		if ((pos/=0.5) < 1) return 0.5*Math.pow(pos,3);
		return 0.5 * (Math.pow((pos-2),3) + 2);
	},
	easeInOutBack: function(pos){
		var s = 1.70158;
		if((pos/=0.5) < 1) return 0.5*(pos*pos*(((s*=(1.525))+1)*pos -s));
		return 0.5*((pos-=2)*pos*(((s*=(1.525))+1)*pos +s) +2);
	},
	linear:  function(pos) {
		return pos;
	},
	elastic: function(pos) {
		return -1 * Math.pow(4,-8*pos) * Math.sin((pos*6-1)*(2*Math.PI)/2) + 1;
	},
	easeOutBounce: function(pos){
		if ((pos) < (1/2.75)) {
			return (7.5625*pos*pos);
		} else if (pos < (2/2.75)) {
			return (7.5625*(pos-=(1.5/2.75))*pos + .75);
		} else if (pos < (2.5/2.75)) {
			return (7.5625*(pos-=(2.25/2.75))*pos + .9375);
		} else {
			return (7.5625*(pos-=(2.625/2.75))*pos + .984375);
		}
	},
	gravity: function(pos)
	{
		return pos*pos*2;
	}
};