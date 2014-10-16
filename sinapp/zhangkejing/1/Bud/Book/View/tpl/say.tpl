<html><head><title>First</title></head>
<body>
	<h1>{$saying}</h1>
	<h1>{$good}</h1>
	<ul>
		<li>{$arr["name"]}</li>		<li>{$arr["job"]}</li>
		<li>{$arr["friends"]["dom"]}</li>
		<li>{$arr["language"][1]}</li>
	</ul>
	{if $arr["name"] != "ronny"}
	Yes! I am Ronny!
	{else}
	No...I am not Ronny.
	{/if}

	<ul>
		{foreach $arr["language"] as $key=>$val}
		<li>{$key+1}.{$val}</li>
		{/foreach}
	</ul>

	<h1>Library</h1>
	<ul>
		{foreach $books as $key=>$book}
		<li>{$key+1}.{$book["book"]}</li>
		{/foreach}
	</ul>	
</body>
</html>