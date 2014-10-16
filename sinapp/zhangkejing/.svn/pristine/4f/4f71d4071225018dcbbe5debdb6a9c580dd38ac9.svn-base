(function(){
	var alcoholBurner = _('alcohol_burner'),
		mask = _('mask'),
		tube1 = _('tube1');

	alcoholBurner.setFire = function(){
		F.hint.className = '';
		F.hint.innerHTML = '';
		setTimeout(function(){
			if(tube1.angle<0){
				F.showHint('试管口要朝下', 'hint-wrong');
			}else if(tube1.angle<4 && tube1.angle>=0){
				F.showHint('试管倾斜度不够呢', 'hint-wrong');
			}else if(tube1.angle>6){
				F.showHint('试管倾斜度太大了', 'hint-wrong');
			}else{
				F.showHint('骚年你是百年一遇的化学奇才！<br>等氧气开始生成刷新页面再来一遍吧', 'hint-right');
				alcoholBurner.fire.style.display = 'block';
				F.hint.style.opacity = 1;
				mask.style.display = 'block';
				setTimeout(function(){
					bubble.style.display = 'block';
				}, 600);
			}
		}, 0);
	};
})();