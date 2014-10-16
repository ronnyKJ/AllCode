function wc_loader() {

	if (this.constructor == wc_loader) {
		wcl = this;
	} else {
		wcl = arguments[arguments.length-1];
	}
	
	wcl.loaded = false;
	wcl.keytimer = false;
	
	wcl.keydown = function(e) {
	    var keyId = (window.event) ? event.keyCode : e.keyCode;
	    var ctrlKey = (window.event) ? event.ctrlKey : e.ctrlKey;
	    var shiftKey = (window.event) ? event.shiftKey : e.shiftKey;
	    if ((keyId == 89 && shiftKey)) {
		wcl.keytimer = setTimeout(wcl.init, 1000);
	    }
	};
	
	wcl.keyup = function() {
	    if (wcl.keytimer) {
		wcl.clearit();
	    }
	};
	
	wcl.clearit = function() {
	    clearTimeout(wcl.keytimer);
	    wcl.keytimer = false;
	};
	
	wcl.init = function() {
	    if (!wcl.loaded) {
	        wcl.clearit();
	        wcl.loaded = true;
	
	        var el = document.createElement('script');
	        el.type = 'text/javascript';
	        el.src = 'http://www.w3counter.com/stats/pwidget.js';
	        document.body.appendChild(el);
	    }
	};
	
	if (window.AddEventListener) {
	    document.AddEventListener('keydown', wcl.keydown, false);
	    document.AddEventListener('keyup', wcl.keyup, false);
	} else if (window.attachEvent) {
	    document.attachEvent('onkeydown', wcl.keydown);
	    document.attachEvent('onkeyup', wcl.keyup);
	} else {
	    document.onkeydown = wcl.keydown;
	    document.onkeyup = wcl.keyup;
	}

}

function w3counter(id) {
	
	var info;
	
	if (encodeURIComponent) {
	
		info = '&userAgent=' + encodeURIComponent(navigator.userAgent);
		info = info + '&webpageName=' + encodeURIComponent(document.title);
		info = info + '&ref=' + encodeURIComponent(document.referrer);
		info = info + '&url=' + encodeURIComponent(window.location);
		
		if (typeof _w3counter_label != 'undefined') {
			info = info + '&label=' + encodeURIComponent(_w3counter_label);
		}
 
	} else {
	
		info = '&userAgent=' + escape(navigator.userAgent);
		info = info + '&webpageName=' + escape(document.title);
		info = info + '&ref=' + escape(document.referrer);
		info = info + '&url=' + escape(window.location);
		
		if (typeof _w3counter_label != 'undefined') {
			info = info + '&label=' + escape(_w3counter_label);
		}
	
	}

	info = info + '&width=' + screen.width;
	info = info + '&height=' + screen.height;
	info = info + '&depth=' + screen.colorDepth;
	info = info + '&rand=' + Math.round(100*Math.random());

	_w3counter_id = id;
	if (typeof _w3counter_pwidget_disable == 'undefined' || _w3counter_pwidget_disable === 0) {
		_wcl_loader = new wc_loader();
	}

	document.write('<a href="http://www.w3counter.com"><img src="http://www.w3counter.com/tracker.php?id=' + id + info + '" style="border: 0" alt="W3Counter Web Stats" /></a>');

}

_w3counter_id = 0;
