(function(){

var Dish = (function(){

	var utils = {
		_ : function(id){
			return document.getElementById(id);
		},
		getAncestorByTagName : function(ele, tagName){
			while(ele.tagName != tagName){
				ele = ele.parentNode;
			}
			return ele;		
		}
	};

	var vars = {
		evt       : window.ontouchstart? 'ontouchstart': 'onmousedown',
		next      : utils._('to-next'),
		container : utils._('container'),
		header    : utils._('left-header'),
		left      : utils._('left'),
		right     : utils._('right'),
		menu      : utils._('menu-category-list'),
		menuList     : utils._('menu-list'),
		orderCount     : utils._('order-count'),
		totalPrice     : utils._('total-price'),
		orderedDishesList     : utils._('ordered-dishes-list'),
		totalPay     : utils._('total-pay'),
		dishContainer : {},
		orderedDishes : {}
	};

	var loadMenu = function(){
		var type, str = '', selected;
		for(type in vars.dishes){
			str += '<li style="background-color:' + vars.dishes[type]['color'] + ';"><span class="category">' + type + '</span><span class="count"></span></li>';
		}
		vars.menu.innerHTML = str;
	};

	var getDishTpl = function(category, title, url, likeNum, price){
		return '<li category="' + category + '" title="' + title + '" price="' + price + '">'+
			'<span class="picture"><img src="' + url + '" width="64" /></span>'+
			'<div class="intro">'+
				'<span class="title">' + title + '</span>'+
				'<span class="like-num"><i class="like icon">喜欢</i>' + likeNum + '</span>'+
				'<span class="price">' + price + '元/例</span>'+
			'</div>'+
			'<i class="icon check">选中</i>'+
		'</li>'		
	};

	var renderDishes = function(){
		var dishes = vars.dishes;
		var d, category, i, l, arr, ul;
		vars.dishContainer = {};
		for(category in dishes){
			arr = [];
			for(i = 0, l = dishes[category]['list'].length; i < l; i++){
				d = dishes[category]['list'][i];
				arr.push(getDishTpl(category, d['title'], d['url'], d['likeNum'], d['price']));
			}
			ul = document.createElement('ul');
			ul.innerHTML = arr.join('');
			ul.style.display = 'none';
			vars.dishContainer[category] = ul;
			vars.menuList.appendChild(ul);
		}
	};

	var setSelectCategoryAction = function(){
		vars.menu[vars.evt] = function(e){
			var ele = utils.getAncestorByTagName(e.target, 'LI');
			var categories = ele.getElementsByClassName('category');
			var category = categories[0].innerHTML;
			selectCategory(category, ele);
		}
	};

	var selectCategory = function(c, li){
		var tmp, con = vars.dishContainer;
		for(tmp in con){
			con[tmp].style.display = 'none';	
		}
		con[c].style.display = 'block';
		var clist = vars.menu.getElementsByTagName('li');
		for(var m in clist){
			clist[m].className = '';
		}
		if(li) li.className = 'selected';
		document.body.scrollTop = 0;
	};

	var cash = function(){
		var category, dishes = vars.orderedDishes.dishes, html = '', title, price;
		for(category in dishes){
			html += '<article class="ordered-menu">'+
						'<div class="category">' + category + '</div>'+
						'<ul class="ordered-list">';
			for(title in dishes[category]){
				price = dishes[category][title];
				html +=  '<li>'+
							'<i class="icon round"></i>'+
							'<span class="title">' + title + '</span>'+
							'<span class="price">' + price + '元/例</span>'+
						'</li>';
			}
			html += '</ul></article>';
		}
		vars.orderedDishesList.innerHTML = html;
		vars.totalPay.innerHTML = vars.orderedDishes.total + '元';
	};

	var toggleContainer = function(){
		var flag = 0;
		vars.next[vars.evt] = function(){
			if(flag == 0){//to right
				container.className = "scroll-left";
				document.body.scrollTop = 0;
				flag = 1;
				cash();
			}else{// to left
				container.className = "";
				flag = 0;
			}
		};	
	};

	var orderDish = function(){
		var obj = {};
		var dishes = vars.menuList.getElementsByClassName('select');
		var li, tmp, category, title, price, total=0;
		for(var i=0, l=dishes.length; i<l; i++){
			li = dishes[i];
			category = li.getAttribute('category');
			title = li.getAttribute('title');
			price = li.getAttribute('price');
			total += Number(price);
			if(!obj[category]) obj[category] = {};
			obj[category][title] = price;
		}
		vars.orderedDishes = {
			count : l,
			total : total,
			dishes : obj
		};

		return vars.orderedDishes;
	};

	var toggleDish = function(){
		vars.menuList[vars.evt] = function(e){
			if(e.target.id == 'menu-list') return;
			ele = utils.getAncestorByTagName(e.target, 'LI');
			var cls = 'select';
			if(ele.className.indexOf(cls) >= 0){
				ele.className = '';

			}else{
				ele.className = cls;
			}
			var obj = orderDish();
			vars.orderCount.innerHTML = obj.count;
			vars.totalPrice.innerHTML = obj.total + '元';
		}
	};
	
	var init = function(dishes){
		vars.dishes = dishes;
		vars.header.style.width = window.screen.width+'px';
		vars.menuList.style.minHeight = window.screen.height+'px';
		vars.right.style.height = vars.left.clientHeight + 'px';
		toggleContainer();
		loadMenu();
		renderDishes();
		setSelectCategoryAction();
		for(var c in vars.dishes)
			break;
		var first = vars.menu.getElementsByTagName('li')[0];
		selectCategory(c, first);
		toggleDish();
	};

	return {
		init : init
	};
})();

function ajax(para)
{
	var request = new XMLHttpRequest();
	
	request.open(para.type, para.url, para.asyn||false);
	if(para.type == "POST"){
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");//post提交，这个语句一定要有,否则客户端就有可能出现乱码的情况
	}
	
	setTimeout(function(){//设置超时
		if(!(request.readyState == 4 && request.status == 200)){
			para.fail(request.readyState, request.status);
		}
	}, para.timeout||1000);
	request.onreadystatechange = function(){
		if(request.readyState == 4 && request.status == 200){
			para.callback(JSON.parse(request.responseText));
		}
	}
	request.send(para.data||'');
}

ajax({
	url: 'dish.php',
	callback : function(json){
		Dish.init(json);
	}
});

})();