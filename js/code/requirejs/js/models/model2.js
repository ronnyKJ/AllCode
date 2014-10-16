define([
  'QW', 'require'
], function (QW, require) {

    var Run = function () {
        if (W("#page").html() == '') {

            require(['./model3'], function (m3) {//这里用require([],callback)的方式，如果直接require('')那么m3和m4都会加载进来

                W("#page").html(m3.data);
            })
        } else {

            require(['./model4'], function (m4) {

                W("#page").html(m4.data);
            })
        }
    };

    return {
        Run: Run
    };
});
