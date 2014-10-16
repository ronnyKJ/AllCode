if(!TESTING)
{
    System.Link("StyleSheet", "Themes/Default/Custom.css", "text/css");
}

var Controls = null;
var Window = null, Control = null, RichEditor = null;

function init(completeCallback, errorCallback)
{
    function LoadModulesComplete()
    {
        Controls = System.GetModule("Controls.js");
        CommonDialog = System.GetModule("CommonDialog.js");

        Window = System.GetModule("Window.js").Window;
        Control = System.GetModule("Controls.js").Control;
        
        RichEditor = System.GetModule("RichEditor.js").RichEditor;

        _init(completeCallback, errorCallback);
    }

    System.LoadModules(
        LoadModulesComplete,
        errorCallback,
        ["Window.js", "Controls.js", "RichEditor.js"]
    );
}

function _init(completeCallback, errorCallback)
{
    try
    {
        //初始化代码，初始化完成后必须调用completeCallback;
        completeCallback();
    }
    catch (ex)
    {
        errorCallback(new Exception(ex.mame, ex.message));
    }
}



function dispose(completeCallback, errorCallback)
{
    _dispose(completeCallback, errorCallback);
}

function _dispose(completeCallback, errorCallback)
{
    try
    {
        //卸载代码，卸载完成后必须调用completeCallback;
        completeCallback();
    }
    catch (ex)
    {
        errorCallback(new Exception(ex.mame, ex.message));
    }
}

//共享全局变量和函数，在此定义的变量和函数将由该应用程序的所有实例共享


function Application()
{
    var CurrentApplication = this;
    var m_MainForm = null;
    
    //应用程序全局对象;
        

    this.Start = function(baseUrl)
    {
        //应用程序入口;
        m_MainForm = new MainForm();
        m_MainForm.OnClosed.Attach(
            function()
            {
                CurrentApplication.Dispose();
            }
        );
        m_MainForm.MoveEx("center", 0, 0);
        m_MainForm.Show(true);
        
    }

    this.Terminate = function(completeCallback, errorCallback)
    {
        try
        {
            //应用程序终止，退出系统时用系统调用;
            completeCallback();
        }
        catch (ex)
        {
            errorCallback(new Exception(ex.mame, ex.message));
        }
    }
    function MainForm()
    {
        var This = this;
        var OwnerForm = this;
        
        var config = {"Left":37,"Top":20,"Width":619,"Height":447,"AnchorStyle":Controls.AnchorStyle.Left | Controls.AnchorStyle.Top,"Parent":null,"Css":"window","BorderWidth":6,"HasMinButton":true,"HasMaxButton":true,"Resizable":true,"Title":{"InnerHTML":"主窗口"}};
        
    
        Window.call(This, config);
    
        var Base = {
            GetType: This.GetType,
            is: This.is
        };
    
        This.GetType = function() { return "MainForm"; }
        This.is = function(type) { return type == This.GetType() ? true : Base.is(type); }
        
        var control1 = new Controls.Control({"Left":37,"Top":20,"Width":523,"Height":359,"AnchorStyle":Controls.AnchorStyle.Left|Controls.AnchorStyle.Top,"Parent":This,"Text":"","Css":"control1"});
        
        
        
        control1.OnResized.Attach(
            function(btn)
            {
                
            }
        )
    
    
        var m_Task = null;
        if(config.HasMinButton)
        {
            m_Task=Taskbar.AddTask(This,IsNull(config.Title.InnerHTML,""));
            This.OnClosed.Attach(
                function()
                {
                    Taskbar.RemoveTask(m_Task);
                }
            );
        }
        
    }

}

