require.config({
    paths: {//配置加载路径
        QW: 'libs/qwrap/qwrap-youa-debug',
        text: 'libs/require/text'//requirejs的一个文本插件
    },
    waitSeconds: 20
});

require(['app'], function (App) {//加载app.js,执行初始化

    App.initialize();
});
