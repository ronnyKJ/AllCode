define([
  'QW',
  'models/model2'
], function (QW, m2) {

    var Run = function () {

        W("#logo").html('<h1>This is Logo by M1</h1>');

        m2.Run();
    };

    return {
        Run: Run
    };
});
