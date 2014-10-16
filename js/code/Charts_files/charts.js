(function(){
    var U = {
        getSeriesMostValue : function(series, type){
            var arr = [];
            for(var i = 0; i < series.length; i++){
                arr.push(Math[type].apply({}, series[i].data));
            }
            return Math[type].apply({}, arr);
        },
        C : function(ele){
            return document.createElement(ele);
        }
    };

    var coordinate = U.C('canvas');
    var coorCTX = coordinate.getContext("2d");
    var plot = U.C('canvas');
    var plotCTX = plot.getContext("2d");

    var setComponents = function(container){
        plot.width = coordinate.width = parseInt(container.offsetWidth);
        plot.height = coordinate.height = parseInt(container.offsetHeight);
        container.style.position = "relative";
        plot.style.cssText = coordinate.style.cssText = "position:absolute;left:0;top:0;"
        container.appendChild(coordinate);
        container.appendChild(plot);
    }

    var renderCoordX = function(container, data){
        if(data.xAxis){
            var categories = data.xAxis.categories;
            var l = categories.length, unit = coordinate.width/(l-1), X, label;

            coorCTX.beginPath();
            for (var i = 0; i < l; i++){
                X = unit*i;
                coorCTX.moveTo(X, 0);
                coorCTX.lineTo(X, coordinate.height);

                label = U.C('div');
                label.innerHTML = categories[i];

                label.style.cssText = 'position:absolute;bottom:-20px;left:'+(X-label.clientWidth/2)+'px;font-size:10px;text-align:center;';
                console.log(label.clientWidth/2);
                container.appendChild(label);
            };
            coorCTX.strokeStyle = "#AAA";  
            coorCTX.lineWidth = 1;  
            coorCTX.lineCap = "round";  
            coorCTX.stroke();
        }
    }

    var renderCoordY = function(container, data){
        if(data.series){
            var max = U.getSeriesMostValue(data.series, 'max');
            var min = U.getSeriesMostValue(data.series, 'min');
            var a = 4;
            var unit = ((max - min)/a).toFixed(4);
            var minY = min - unit;
            var maxY = max - unit;

            var heightUnit = coordinate.height/(a+1), Y;

            coorCTX.beginPath();
            for (var i = 0; i <= a+1; i++){
                Y = coordinate.height - heightUnit*i;
                coorCTX.moveTo(0, Y);
                coorCTX.lineTo(coordinate.width, Y);
            };
            coorCTX.strokeStyle = "#AAA";
            coorCTX.lineWidth = 1; 
            coorCTX.stroke();
        }
    }

    var renderCoordinate = function(container, data){
        renderCoordX(container, data);
        renderCoordY(container, data);
    }

    var render = function(container, data){
        setComponents(container);
        renderCoordinate(container, data);
    }

    window.Charts = {
        render : render
    };
})();