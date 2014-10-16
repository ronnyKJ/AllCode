window.onload = function(){
	d=document;
	w=window;
	r=Math.random;
	d.body.style.backgroundColor="#000";
	var canvas = d.getElementsByTagName("canvas");
	for(var s=0; s<canvas.length; s++)
	{
		canvas[s].meteor=function(m){
			if(m.count) {mCount=m.count}else{mCount=25}
			if(m.clockwise) {mClockwise=m.clockwise}else{mClockwise=true}
			if(m.radium) {mRadium=m.radium}else{mRadium=80}
			if(m.radiumRange) {mRadiumRange=m.radiumRange}else{mRadiumRange=60}
			if(m.angleStep) {mAngleStep=m.angleStep}else{mAngleStep=0.03}
			if(m.angleStepRange) {mAngleStepRange=m.angleStepRange}else{mAngleStepRange=0.02}
			if(m.speed) {mSpeed=m.speed}else{mSpeed=0.03}
			if(m.speedRange) {mSpeedRange=m.speedRange}else{mSpeedRange=0.01}
			if(m.width) {mWidth=m.width}else{mWidth=2}
			alert(mCount + " " + mRadium + " " + mRadiumRange + "  " + mAngleStep + "  " + mAngleStepRange + "  " + mSpeed + "  " + mSpeedRange + " " + mWidth);
		}
	}
	t=c.getContext("2d");
	(function(){
		c.width=w.innerWidth-25;
		c.height=w.innerHeight-25
	})()
	
	//Ô²ÐÄ
	ox=c.width*0.5;
	oy=c.height*0.5;
	var mx=ox, my=oy;
	d.onmousemove = function(){
		mx=event.clientX;
		my=event.clientY;
	}
	
	l=[];
	j=0;

	while(++j<25)
	{
		
		p={
			R:100+r()*80,
			alpha:0+r()*2*Math.PI,
			angleStep:0.03+r()*0.02,
			speed:0.03+r()*0.01,
			width:2,
			color:"#"+(r()*4210752+11184810|0).toString(16),
			Ox:ox,
			Oy:oy,
			x1:ox,
			y1:oy
		}
		l.push(p);
	}
	g=0;
	setInterval(function(){
		g++;
		t.fillStyle="rgba(0,0,0,0.03)";
		t.fillRect(0,0,c.width,c.height);
		i=0;
		while(q=l[++i])
		{
			tmpX = q.x1;
			tmpY = q.y1;
			q.Ox += (mx-q.Ox)*q.speed;
			q.Oy += (my-q.Oy)*q.speed;
			q.x1=q.Ox+q.R*Math.cos(q.alpha + g*q.angleStep);
			q.y1=q.Oy+q.R*Math.sin(q.alpha + g*q.angleStep);
			q.x1=Math.max(Math.min(q.x1, c.width),0);
			q.y1=Math.max(Math.min(q.y1, c.height),0);
			with(t){
				beginPath();
				strokeStyle=q.color;
				lineWidth=q.width;
				moveTo(tmpX,tmpY);
				lineTo(q.x1,q.y1);
				stroke();
			}}
	},17)
}