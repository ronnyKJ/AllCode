(function(){
	var mask = _('mask');
	mask.style.display = 'block';
	var ex = _('container');

	var intro = document.createElement('div');
	intro.innerHTML = '<div id="arrow" style="position: absolute;left: 9px; top:125px;background:url(img/arrow.png);background-size:30px;width:30px; height:78px;"></div>'+
	'<div id="hand" style="position: absolute;left: -70px; top:220px;background:url(img/hand.png);background-size:80px;width:80px; height:61px;opacity:0;"></div>';
	ex.appendChild(intro);
	var arrow = _('arrow'), hand = _('hand');
	E.blink(arrow);
	setTimeout(function(){
		E.blink(hand);
		mask.style.display = 'none';
	}, 800);
})();