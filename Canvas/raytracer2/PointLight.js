PointLight = function(intensity, position) { this.intensity = intensity; this.position = position; this.shadow = true; };

PointLight.prototype = {
    initialize: function() { },
    sample: function(scene, position) {
        // 計算L，但保留r和r^2，供之後使用
        var delta = this.position.subtract(position);
        var rr = delta.sqrLength();
        var r = Math.sqrt(rr);
        var L = delta.divide(r);

        // 陰影測試
        if (this.shadow) {
            var shadowRay = new Ray3(position, L);
            var shadowResult = scene.intersect(shadowRay);
            // 在r以內的相交點才會遮蔽光源
            if (shadowResult.geometry && shadowResult.distance <= r)
                return LightSample.zero;
        }

        // 平方反比衰減
        var attenuation = 1 / rr;

        // 計算幅照度
        return new LightSample(L, this.intensity.multiply(attenuation));
    }
};
