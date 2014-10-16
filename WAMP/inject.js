function includeJS(src, func)
{
	var s = document.createElement('script');
	s.type='text/javascript';
	s.src=src;
	var head = document.getElementsByTagName('head')[0];
	head.appendChild(s);
	s.onload = func;
}

var myEvent = document.createEvent('MouseEvent');  
myEvent.initEvent('click', false, false); 

function _(id)
{
	return document.getElementById(id);
}

function vClick(ele)
{
	ele.dispatchEvent(myEvent);
}

function createIFrame(url)
{
	var ifm = document.createElement('iframe');
	ifm.width = 500;
	ifm.height = 400;
	ifm.src = url;
	console.log(url);
	document.body.appendChild(ifm);
	return ifm;
}

function clickInIFrame(ifm, time)
{
	$(ifm).load(function(){
		setTimeout(function(){	
			var rateStar = $(ifm).contents().find('#rateStar');
			console.log($(ifm));
			if(!rateStar) return;
			var star = rateStar[0].children[4];
			vClick(star);
			console.log('time:'+time);
		}, time);
	});
}

includeJS('http://localhost/jquery-1.7.2.js', function(){
	var links = $('#hot-read .mt5 dt a');
	links.each(function(i,e){
		console.log(e.href);
	});
	
	var i, interval = 3000;
	i=10;
	ifm0 = createIFrame(links[i].href);	
	clickInIFrame(ifm0, (i%5)*interval);
	
	i++;
	ifm1 = createIFrame(links[i].href);	
	clickInIFrame(ifm1, (i%5)*interval)
	
	i++;
	ifm2 = createIFrame(links[i].href);
	clickInIFrame(ifm2, (i%5)*interval)
	
	i++;
	ifm3 = createIFrame(links[i].href);	
	clickInIFrame(ifm3, (i%5)*interval)
	
	i++;
	ifm4 = createIFrame(links[i].href);
	clickInIFrame(ifm4, (i%5)*interval)
});
//rateStar rateScore