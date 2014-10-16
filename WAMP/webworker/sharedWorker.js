var index=0;
var users = {};
var totalMsg='';
onconnect = function(event)
{
	index++;
	var user = users[index] = {
		port: event.ports[0],
		index: index
	};
	user.port.postMessage({
		'isInit':true,
		'username':'User-'+index,
		'url':'portrait/'+(index%10+1)+'.jpg',
		'conversation':totalMsg
	});
	user.port.onmessage = function(event)
	{
		var data = event.data;
		totalMsg += data.username + ": " + data.message + "<br>";
		for(var i in users)
		{
			users[i].port.postMessage({
				'isInit':false,
				'username':data.username,
				'message':data.message
			});
		}
	}
}