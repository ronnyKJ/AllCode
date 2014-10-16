<?php
//note: 如“热菜”下，不能有重名的菜，不然价格计算会出错
$dishes = '{
	"热菜" : {
		"list": [
			{"title":"宫保鸡丁","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"宫保鸡丁","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"宫保鸡丁","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"宫保鸡丁","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"宫保鸡丁","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"宫保鸡丁","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"宫保鸡丁","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"宫保鸡丁","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"宫保鸡丁","url":"img/dish.jpg","likeNum":123, "price":45}
		],
		"color":"#c44949"
	},
	"凉菜" : {
		"list" : [
			{"title":"凉菜鸡丁","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"凉菜鸡丁","url":"img/dish.jpg","likeNum":123, "price":45}
		],
		"color" : "#4ea3ab"
	},
	"时蔬" : {
		"list" : [
			{"title":"白菜","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"青菜","url":"img/dish.jpg","likeNum":123, "price":45}
		],
		"color" : "#7cab4e"
	},
	"汤粥" : {
		"list" : [
			{"title":"白菜","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"青菜","url":"img/dish.jpg","likeNum":123, "price":45}
		],
		"color" : "#b1b877"
	},
	"主食" : {
		"list" : [
			{"title":"白菜","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"青菜","url":"img/dish.jpg","likeNum":123, "price":45}
		],
		"color" : "#b8a677"
	},
	"酒水" : {
		"list" : [
			{"title":"白菜","url":"img/dish.jpg","likeNum":123, "price":45},
			{"title":"青菜","url":"img/dish.jpg","likeNum":123, "price":45}
		],
		"color" : "#9f698f"
	}
}';

echo $dishes;
?>