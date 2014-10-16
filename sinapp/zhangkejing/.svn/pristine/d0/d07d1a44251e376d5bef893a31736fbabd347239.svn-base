(function(){
	var mask = _('mask');
	mask.style.display = 'block';
	var body = document.body;

	var intro = document.createElement('div');
	intro.innerHTML = '<div id="arrow" style="position: absolute;left: 121px; top:194px;background:url(img/arrow.png);background-size:30px;width:30px; height:78px;"></div>'+
	'<div id="hand" style="position: absolute;left: 31px; top:304px;background:url(img/hand.png);background-size:80px;width:80px; height:61px;opacity:0;"></div>';
	body.appendChild(intro);
	var arrow = _('arrow'), hand = _('hand');
	blink(arrow);
	setTimeout(function(){
		blink(hand);
		mask.style.display = 'none';
	}, 800);
})();