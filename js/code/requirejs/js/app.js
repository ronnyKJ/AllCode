define(['QW', 'models/model1'], function (QW, m1) {//加载依赖js,

    var initialize = function () {
        m1.Run();
    }

    return {
        initialize: initialize
    };
});