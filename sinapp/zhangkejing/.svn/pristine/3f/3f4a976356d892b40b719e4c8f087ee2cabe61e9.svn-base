var Data = {
	fetchData : function(tileID, async, onRecieveComplete)
	{	
		var self = this;
		$.ajax({
			async: async,
			type: 'GET',
			url: 'server/loadTiles.php?tile='+tileID,
			// url: 'server/loadTiles.php?tile='+tileID+'&moredata=1',
			dataType: 'json',
			success: function(jsonData)
			{
				onRecieveComplete(jsonData,tileID);
			}
		});
	}
};