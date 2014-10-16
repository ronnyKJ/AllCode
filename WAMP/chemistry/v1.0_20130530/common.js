function _(id){
	return document.getElementById(id);
}

function isElement(targetId, currentElement){
	return currentElement.id === targetId;
}

function blink(ele){
	ele.style.opacity = 0;
	ele.className += ' blink';
}