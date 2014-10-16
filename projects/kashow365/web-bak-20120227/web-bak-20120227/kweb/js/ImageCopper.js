function ImageCopper(el,option,size,complete)
{
    this.Target = el;
    this.Init(option, size);
    if(complete && typeof(complete) == "function")
    {
        this.OnComplete = complete;
    }
}

ImageCopper.prototype = {
    Init : function(option, size)
    {
        //初始化一些参数
        this.Offset = {x : 0, y : 0};
        this.Draging = this.Moving = false;
        var x = this.GetPosition(this.Target);
        this.Position = {X : x.Left, Y : x.Top};
        this.Size = {Width : this.Target.offsetWidth, Height : this.Target.offsetHeight};
        this.DragElement = null;
        this.DragIndex = 0;
        var opt = this.Option = {MaxWidth : 180, MaxHeight : 180, Width : 180, Height : 180, Left : 30, Top : 60, Locked : false, LockRate : false, Rate : 0};
        if(option)
        {
            for(var c in option)
            {
                this.Option[c] = option[c];
            }
        }
		if(size)
        {
            for(var c in size)
            {
                this.Size[c] = size[c];
            }
        }
        if(!this.Option.Rate && this.Option.LockRate)
        {
            this.Option.Rate = this.Option.Height / this.Option.Width;
        }
        this.Option.Left += this.Position.X;
        this.Option.Top += this.Position.Y;
        
        //创建遮罩层
        var master = this.Master = document.createElement("div");
		master.id="master";
        master.style.position = "absolute";
        master.style.width = this.Size.Width + "px";
        master.style.height = this.Size.Height + "px";
        master.style.left = x.Left + "px";
        master.style.top = x.Top + "px";
        master.style.backgroundColor = "#FFFFFF";
        master.style.filter = "alpha(opacity=50)";
        master.style.opacity = "0.5";
		master.style.overflow = "hidden";
        document.body.appendChild(master);
        
        //创建拖动显示层.
        var c = this.Content = document.createElement("div");
		c.id="c";
        c.style.position = "absolute";
        c.style.zIndex = 100;
        c.style.width = opt.Width + "px";
        c.style.height = opt.Height + "px";
        c.style.top = opt.Top + "px";
        c.style.left = opt.Left + "px";
        c.style.backgroundImage = "url(" + this.Target.src + ")";
        c.style.backgroundRepeat = "no-repeat";
        c.style.backgroundPosition = (-(this.Option.Left - this.Position.X) + "px") + " " + (-(this.Option.Top - this.Position.Y) + "px");
        document.body.appendChild(c);
        
        //创建拖动大小的div.
        var DragStyle = [{top : "0%", left : "0%", marginLeft : "1", marginTop : "1", cursor : "nw-resize"},{top : "0%", left : "50%", marginLeft : "-4", marginTop : "1", cursor : "s-resize"},{top : "0%", left : "100%", marginLeft : "-8", marginTop : "1", cursor : "sw-resize"},{top : "50%", left : "0%", marginLeft : "1", marginTop : "-4", cursor : "w-resize"},{top : "50%", left : "100%", marginLeft : "-8", marginTop : "-4", cursor : "w-resize"},{top : "100%", left : "0%", marginLeft : "1" , marginTop : "-8", cursor : "sw-resize"},{top : "100%", left : "50%", marginLeft : "-4", marginTop : "-8", cursor : "s-resize"},{top : "100%", left : "100%", marginLeft : "-8", marginTop : "-8", cursor : "nw-resize"}];
        for(var x = 0; x < DragStyle.length; x++)
        {
            var drag = document.createElement("div");
            drag.style.height = "6px";
            drag.style.width = "6px";
            drag.style.top = DragStyle[x].top;
            drag.style.left = DragStyle[x].left;
            drag.style.position = "absolute";
            drag.style.marginLeft = DragStyle[x].marginLeft + "px";
            drag.style.marginTop = DragStyle[x].marginTop + "px";
            drag.style.border = "solid 1px #888888";
            drag.style.backgroundColor = "#FFFFFF";
            drag.style.cursor = DragStyle[x].cursor;
            drag.onmousedown = this.GetFunctionWithEvent(this, "Drag_Begin",{Element : drag, Index : x + 1});
            drag.onmousemove = this.GetFunctionWithEvent(this, "OnDrag");
            drag.onmouseup = this.GetFunction(this, "Drag_End");
            c.appendChild(drag);
        }
        
        //创建触发拖动的层
        var d = this.DragDiv = document.createElement("div");
        d.style.left = "7px";
        d.style.top = "7px";
        d.style.height = this.Option.Height - 14 + "px";
        d.style.width = this.Option.Width - 14 + "px";
        d.style.position = "absolute";
        d.style.cursor = "move";
        c.appendChild(d);
        
        d.onmousedown = this.GetFunctionWithEvent(this, "Move_Begin");
        c.onmousemove = this.GetFunctionWithEvent(this, "OnMove");
        c.onmouseup = this.GetFunction(this, "Move_End");
    },
    Move_Begin : function(e)//拖动位置开始.
    {
        this.Moving = true;
        var offset = this.GetPosition(this.Content);
        if(offset)
        {
            this.Offset.x = (e ? e.pageX : event.clientX + document.body.scrollLeft) - offset.Left;
            this.Offset.y = (e ? e.pageY : event.clientY + document.body.scrollTop) - offset.Top;
        }
        if(this.Content.setCapture)
        {
            this.Content.setCapture();
        }
        else
        {
            this.Content.onmouseout = this.GetFunction(this, "Move_End");
        }
    },
    OnMove : function(e)//拖动改变显示层位置.
    {
        if(!this.Moving)
        {
            return;
        }
        var NewX = (e ? e.pageX : event.clientX + document.body.scrollLeft) - this.Offset.x;
        var NewY = (e ? e.pageY : event.clientY + document.body.scrollTop) - this.Offset.y;
        var x = this.Position.X, y = this.Position.Y, h = this.Size.Height, w = this.Size.Width;
        NewX = NewX > (w + x - this.Option.Width) ? (w + x - this.Option.Width) : NewX;
        NewY = NewY > (h + y - this.Option.Height) ? (h + y - this.Option.Height) : NewY;
        NewX = NewX < x ? x : NewX;
        NewY = NewY < y ? y : NewY;
		if(NewX>this.Option.MaxWidth || NewY>this.Option.MaxHeight)
			return;
		
        this.Option.Left = NewX;
        this.Option.Top = NewY;
        this.OnResize();
    },
    Move_End : function()//拖动位置结束.
    {
        if(!this.Moving)
        {
            return;
        }
        this.Moving = false;
        if(this.Content.releaseCapture)
        {
            this.Content.releaseCapture();
        }
        this.Complete();
    },
    
    Drag_Begin : function(e,param)//拖动尺寸开始,初始化一些数据.
    {
        if(this.Option.Locked)
        {
            return;
        }
        this.Draging = true;
        this.DragElement = param.Element;
        this.DragIndex = param.Index;
        var offset = this.GetPosition(this.DragElement);
        if(offset)
        {
            this.Offset.x = (e ? e.pageX : event.clientX + document.body.scrollLeft) - offset.Left;
            this.Offset.y = (e ? e.pageY : event.clientY + document.body.scrollTop) - offset.Top;
        }
        if(this.DragElement.setCapture)
        {
            this.DragElement.setCapture();
        }
        else
        {
            this.DragElement.onmouseout = this.GetFunction(this, "Drag_End");
        }

    },
    Drag_End : function()//拖动尺寸结束.
    {
        if(!this.Draging)
        {
            return;
        }
        this.Draging = false;
        if(this.DragElement.releaseCapture)
        {
            this.DragElement.releaseCapture();
        }
        this.Complete();
    },
    OnResize : function()//设置拖动时产生的尺寸和位置到dom元素上.
    {
        this.Content.style.left = this.Option.Left + "px";
        this.Content.style.top = this.Option.Top + "px";
        this.Content.style.width = this.Option.Width + "px";
        this.Content.style.height = this.Option.Height + "px";
        this.DragDiv.style.width = this.Option.Width - 14 + "px";
        this.DragDiv.style.height = this.Option.Height - 14 + "px";
        this.Content.style.backgroundPosition = (-(this.Option.Left - this.Position.X) + "px") + " " + (-(this.Option.Top - this.Position.Y) + "px");
    },
    OnDrag : function(e)//拖动改变显示层尺寸.
    {
        if(!this.Draging || this.Option.Locked)
        {
            return;
        }
        switch(this.DragIndex)
        {
            case 1:
            {
                var Original = this.GetPosition(this.DragElement);
                var NewPoint = {Left : (e ? e.pageX : event.clientX + document.body.scrollLeft), Top : (e ? e.pageY : event.clientY + document.body.scrollTop)};
                var StepX = Original.Left - NewPoint.Left + this.Offset.x;
                var StepY = Original.Top - NewPoint.Top + this.Offset.y;
                if(this.Option.LockRate)
                {
                    StepY = (this.Option.Width + StepX) * this.Option.Rate - this.Option.Height;
                }
                if(this.Option.Left - StepX < this.Position.X || this.Option.Top - StepY < this.Position.Y || this.Option.Width + StepX < 40 || this.Option.Height + StepY < 40)
                {
                    return;
                }
                this.Option.Left -= StepX;
                this.Option.Top -= StepY;
                this.Option.Width += StepX;
                this.Option.Height += StepY;
                this.OnResize();
                break;
            }
            case 2:
            {
                var Original = this.GetPosition(this.DragElement);
                var NewPoint = {Left : (e ? e.pageX : event.clientX + document.body.scrollLeft), Top : (e ? e.pageY : event.clientY + document.body.scrollTop)};
                var StepY = Original.Top - NewPoint.Top + this.Offset.y;
                if(this.Option.Top - StepY < this.Position.Y)
                {
                    return;
                }
                if(this.Option.LockRate)
                {
                    var StepX = this.Option.Height / this.Option.Rate - this.Option.Width;
                    if(this.Option.Left - StepX / 2 < this.Position.X || this.Option.Left + StepX / 2 + this.Option.Width > this.Position.X + this.Size.Width || this.Option.Width + StepX < 40)
                    {
                        return;
                    }
                    this.Option.Width += StepX;
                    this.Option.Left -= StepX / 2;
                }
                if(this.Option.Height + StepY < 40)
                {
                    return;
                }
                this.Option.Top -= StepY;
                this.Option.Height += StepY;
                this.OnResize();
                break;
            }
            case 3:
            {
                var Original = this.GetPosition(this.DragElement);
                var NewPoint = {Left : (e ? e.pageX : event.clientX + document.body.scrollLeft), Top : (e ? e.pageY : event.clientY + document.body.scrollTop)};
                var StepY = Original.Top - NewPoint.Top + this.Offset.y;
                var StepX = NewPoint.Left - Original.Left - this.Offset.x;
                if(this.Option.Top - StepY < this.Position.Y)
                {
                    return;
                }
                if(this.Option.LockRate)
                {
                    StepX = (this.Option.Height + StepY) / this.Option.Rate - this.Option.Width;
                }
                if(this.Option.Left + StepX + this.Option.Width > this.Position.X + this.Size.Width || this.Option.Width + StepX < 40 || this.Option.Height + StepY < 40)
                {
                    return;
                }
                this.Option.Width += StepX;
                this.Option.Top -= StepY;
                this.Option.Height += StepY;
                this.OnResize();
                break;
            }
            case 4:
            {
                var Original = this.GetPosition(this.DragElement);
                var NewPoint = {Left : (e ? e.pageX : event.clientX + document.body.scrollLeft), Top : (e ? e.pageY : event.clientY + document.body.scrollTop)};
                var StepX = Original.Left - NewPoint.Left + this.Offset.x;
                if(this.Option.Left - StepX < this.Position.X)
                {
                    return;
                }
                if(this.Option.LockRate)
                {
                    var StepY = this.Option.Width * this.Option.Rate - this.Option.Height;
                    if(this.Option.Top - StepY / 2 < this.Position.Y || this.Option.Height + this.Option.Top - StepY / 2 > this.Size.Height + this.Position.Y || this.Option.Height + StepY < 40)
                    {
                        return;
                    }
                    this.Option.Height += StepY;
                    this.Option.Top -= StepY / 2;
                }
                if( this.Option.Width + StepX < 40)
                {
                    return;
                }
                this.Option.Left -= StepX;
                this.Option.Width += StepX;
                this.OnResize();
                break;
            }
            case 5:
            {
                var Original = this.GetPosition(this.DragElement);
                var NewPoint = {Left : (e ? e.pageX : event.clientX + document.body.scrollLeft), Top : (e ? e.pageY : event.clientY + document.body.scrollTop)};
                var StepX = NewPoint.Left - Original.Left - this.Offset.x;
                if(this.Option.Left + this.Option.Width + StepX > this.Position.X + this.Size.Width)
                {
                    return;
                }
                if(this.Option.LockRate)
                {
                    var StepY = (this.Option.Width + StepX) * this.Option.Rate - this.Option.Height;
                    if(this.Option.Top - StepY / 2 < this.Position.Y || this.Option.Height + this.Option.Top + StepY / 2 > this.Position.Y + this.Size.Height || this.Option.Height + StepY < 40)
                    {
                        return;
                    }
                    this.Option.Height += StepY;
                    this.Option.Top -= StepY / 2;
                }
                if( this.Option.Width + StepX < 40)
                {
                    return;
                }
                this.Option.Width += StepX;
                this.OnResize();
                break;
            }
            case 6:
            {
                var Original = this.GetPosition(this.DragElement);
                var NewPoint = {Left : (e ? e.pageX : event.clientX + document.body.scrollLeft), Top : (e ? e.pageY : event.clientY + document.body.scrollTop)};
                var StepX = Original.Left - NewPoint.Left + this.Offset.x;
                var StepY = NewPoint.Top - Original.Top - this.Offset.y;
                if(this.Option.LockRate)
                {
                    StepY = (this.Option.Width + StepX) * this.Option.Rate - this.Option.Height;
                }
                if(this.Option.Left - StepX < this.Position.X || this.Option.Top + StepY + this.Option.Height > this.Position.Y + this.Size.Height || this.Option.Width + StepX < 40 || this.Option.Height + StepY < 40)
                {
                    return;
                }
                this.Option.Left -= StepX;
                this.Option.Width += StepX;
                this.Option.Height += StepY;
                this.OnResize();
                break;
            }
            case 7:
            {
                var Original = this.GetPosition(this.DragElement);
                var NewPoint = {Left : (e ? e.pageX : event.clientX + document.body.scrollLeft), Top : (e ? e.pageY : event.clientY + document.body.scrollTop)};
                var StepY = NewPoint.Top - Original.Top - this.Offset.y;
                if(this.Option.Top + StepY + this.Option.Height > this.Position.Y + this.Size.Height)
                {
                    return;
                }
                if(this.Option.LockRate)
                {
                    var StepX = (this.Option.Height + StepY) / this.Option.Rate - this.Option.Width;
                    if(this.Option.Left - StepX / 2 < this.Position.X || this.Option.Left + StepX + this.Option.Width > this.Position.X + this.Size.Width || this.Option.Width + StepX < 40)
                    {
                        return;
                    }
                    this.Option.Width += StepX;
                    this.Option.Left -= StepX / 2;
                }
                if(this.Option.Height + StepY < 40)
                {
                    return;
                }
                this.Option.Height += StepY;
                this.OnResize();
                break;
            }
            case 8:
            {
                var Original = this.GetPosition(this.DragElement);
                var NewPoint = {Left : (e ? e.pageX : event.clientX + document.body.scrollLeft), Top : (e ? e.pageY : event.clientY + document.body.scrollTop)};
                var StepX = NewPoint.Left - Original.Left - this.Offset.x;
                var StepY = NewPoint.Top - Original.Top - this.Offset.y;
                if(this.Option.LockRate)
                {
                    StepY = (this.Option.Width + StepX) * this.Option.Rate - this.Option.Height;
                }
                if(this.Option.Left + StepX + this.Option.Width > this.Position.X + this.Size.Width || this.Option.Top + StepY + this.Option.Height > this.Position.Y + this.Size.Height || this.Option.Width + StepX < 40 || this.Option.Height + StepY < 40)
                {
                    return;
                }
                this.Option.Width += StepX;
                this.Option.Height += StepY;
                this.OnResize();
                break;
            }
        }
    },
    GetPosition : function(el)//取得指定元素的绝对位置.
    {
        var result = {Top : 0, Left : 0};
        result.Left = el.offsetLeft;
        result.Top = el.offsetTop;
        while(el = el.offsetParent)
        {
            result.Top += el.offsetTop;
            result.Left += el.offsetLeft;
        }
        return result;
    },
    GetFunction : function(Variable, Method, Parameter)//取得指定对象的指定方法
    {
        return function()
        {
            if(Method.indexOf("|") > -1)
            {
                var MethodArray = Method.split("|");
                for(var x = 0; x < MethodArray.length; x++)
                {
                    Variable[MethodArray[x]](Parameter);
                }
            }
            else
            {
                Variable[Method](Parameter);
            }
        }
    },
    GetFunctionWithEvent : function(Variable, Method, Parameter)//取得指定对象的指定方法,并传递Window.Event事件参数.
    {
        return function(e)
        {
            if(Method.indexOf("|") > -1)
            {
                var MethodArray = Method.split("|");
                for(var x = 0; x < MethodArray.length; x++)
                {
                    Variable[MethodArray[x]](e, Parameter);
                }
            }
            else
            {
                Variable[Method](e, Parameter);
            }
        }
    },
    Complete : function()
    {
        //触发拖动完成的事件,传出当前的状态数据.
        this.OnComplete(this.Option.Left - this.Position.X,this.Option.Top - this.Position.Y,this.Option.Width,this.Option.Height);
    },
    OnComplete : function(Left, Top, Width, Height)
    {
        //接收当前状态数据的方法.
    }
}