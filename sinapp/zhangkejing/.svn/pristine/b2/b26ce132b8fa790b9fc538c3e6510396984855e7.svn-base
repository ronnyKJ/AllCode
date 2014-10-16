function _(id){
	return document.getElementById(id);
}

var isPhone = !!('ontouchstart' in window);
var onstart = isPhone? 'ontouchstart': 'onmousedown';
var onend = isPhone? 'ontouchend': 'onmouseup';
var onmove = isPhone? 'ontouchmove': 'onmousemove';

var disk = _('disk');
var container = _('container');

container.style.width = window.screen.width+'px';

var isTouching = false;
container[onstart] = function(e){
	// e.preventDefault();
	// isTouching = true;

	//simple
	disk.className = "disk put";
	setTimeout(function(){
		disk.className = "disk put play";
		container[onstart] = null;
		music.load();
		music.play();
	}, 1000);
};

// window[onend] = function(e){
// 	e.preventDefault();
// 	isTouching = false;
// 	disk.className = "disk put";
// 	disk.style.webkitTransform ='translate(0px, 0px)';

// 	window[onstart] = null;
// 	window[onmove] = null;
// }


// window[onmove] = function(e){
// 	e.preventDefault();
// 	if(isTouching){
// 		disk.style.webkitTransform ='translate('+e.clientX+'px, '+e.clientY+'px)';
// 	}
// }