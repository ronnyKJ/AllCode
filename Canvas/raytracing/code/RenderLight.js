function renderLight(canvas, scene, lights, camera) {
    var ctx = canvas.getContext("2d");
    var w = canvas.attributes.width.value;
    var h = canvas.attributes.height.value;
    ctx.fillStyle = "rgb(0,0,0)";
    ctx.fillRect(0, 0, w, h);

    var imgdata = ctx.getImageData(0, 0, w, h);
    var pixels = imgdata.data;

    scene.initialize();//场景里面有物体

    // 光，可能是多光源
    for (var k in lights)
        lights[k].initialize();


    camera.initialize();//摄影机

    // 以上为初始化 - 画布 场景 光 摄像机

    var i = 0;
    for (var y = 0; y < h; y++) {// 纵向像素点
        var sy = 1 - y / h;
        for (var x = 0; x < w; x++) {// 横向像素点
            var sx = x / w;
            var ray = camera.generateRay(sx, sy);// 摄像机射出射线, ray为射线单位方向向量

            var result = scene.intersect(ray);

            if (result.geometry) {
                var color = Color.black;
                for (var k in lights) {
                    var lightSample = lights[k].sample(scene, result.position);

                    if (lightSample != lightSample.zero) {
                        var NdotL = result.normal.dot(lightSample.L);

                        // 夾角小約90度，即光源在平面的前面
                        if (NdotL >= 0)
                            color = color.add(lightSample.EL.multiply(NdotL));
                    }
                }
                pixels[i] = color.r * 255;
                pixels[i + 1] = color.g * 255;
                pixels[i + 2] = color.b * 255;
                pixels[i + 3] = 255;
            }
            i += 4;
        }
    }

    ctx.putImageData(imgdata, 0, 0);
}
