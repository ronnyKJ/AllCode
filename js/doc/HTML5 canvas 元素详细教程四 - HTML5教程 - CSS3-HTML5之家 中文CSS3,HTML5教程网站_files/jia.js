-
function () {
    var d = document,
        isStrict = d.compatMode == "CSS1Compat",
        dd = d.documentElement,
        db = d.body,
        m = Math.max,
        ie = !!d.all,
        ua = navigator.userAgent.toLowerCase(),
        head = d.getElementsByTagName('head')[0],
        getWH = function () {
        return {
            h: (isStrict ? dd : db).clientHeight,
            w: (isStrict ? dd : db).clientWidth
        }
    },
        getS = function () {
        return {
            t: m(dd.scrollTop, db.scrollTop),
            l: m(dd.scrollLeft, db.scrollLeft)
        }
    },
        getP = function (a) {
        var r = {
            t: 0,
            l: 0
        },
            isGecko = /gecko/.test(ua),
            add = function (t, l) {
            r.l += l,
            r.t += t
        },
            p = a,
            sTL = getS();
        if (a && a != db) {
            if (a.getBoundingClientRect) {
                var b = a.getBoundingClientRect();
                if (b.top == b.bottom) {
                    var g = a.style.display;
                    a.style.display = 'block';
                    b.top = b.top - a.offsetHeight;
                    a.style.display = g
                };
                add(b.top + sTL.t - dd.clientTop, b.left + sTL.l - dd.clientLeft)
            } else {
                var c = d.defaultView;
                while (p) {
                    add(p.offsetTop, p.offsetLeft);
                    var e = c.getComputedStyle(p, null);
                    if (isGecko) {
                        var f = parseInt(e.getPropertyValue('border-left-width'), 10) || 0,
                            bt = parseInt(e.getPropertyValue('border-top-width'), 10) || 0;
                        add(bt, f);
                        if (p != a && e.getPropertyValue('overflow') != 'visible') add(bt, f)
                    }
                    p = p.offsetParent
                }
                p = a.parentNode;
                while (p && p != db) {
                    add(-p.scrollTop, -p.scrollLeft);
                    p = p.parentNode
                }
            }
        }
        return r
    },
        creElm = function (o, t, a) {
        var b = d.createElement(t || 'div');
        for (var p in o) {
            p == 'style' ? b[p].cssText = o[p] : b[p] = o[p]
        }
        return (a || db).insertBefore(b, (a || db).firstChild)
    },
        div = creElm({
        id: 'ckepop',
        style: "position:absolute;z-index:1000000000;display:none;overflow:auto;"
    }),
        div1 = creElm({
        id: 'ckepop',
        style: "position:absolute;z-index:1000000000;display:none;top:50%;left:50%;overflow:auto;"
    }),
        iframe = creElm({
        style: 'position:' + (/firefox/.test(ua) ? 'fixed' : 'absolute') + ';display:none;filter:alpha(opacity=0);opacity:0',
        frameBorder: 0
    },
    'iframe'),
        timer, inputTimer, list, clist, h, texts = {},
        clickpopjs;
    creElm({
        //href: 'http://www.jiathis.com/code/css/css1.css',
		href: 'http://add.shiqi123.com/code/css/css1.css',
        rel: 'stylesheet',
        type: 'text/css'
    },
    'link');
    $CKE = {
        pop: div,
        centerpop: div1,
        disappear: function (b) {
            var c = window.event || b,
                t = c.srcElement || c.target,
                contain = div1.contains ? div1.contains(t) : !!(div1.compareDocumentPosition(t) & 16),
            a = d.getElementById('jiathis_a'),
            contain1 = div.contains ? div.contains(t) : !!(div.compareDocumentPosition(t) & 16);
            if (!contain && !contain1 && t != a) {
                iframe.style.display = div1.style.display = 'none'
            }
        },
        over: function () {
            var s, T = this,
                timerCont, fn = function () {
                timerCont = setInterval(function () {
                    if (div.innerHTML) {
                        var p = getP(T),
                            wh = getWH(),
                            tl = getS();
                        with(div.style) {
                            display = "block";
                            var a = T.style.display;
                            T.style.display = 'block';
                            top = (p.t + T.offsetHeight + div.offsetHeight > wh.h + tl.t ? p.t - div.offsetHeight - (ie ? 2 : 5) : ie ? p.t + T.offsetHeight + 1 : p.t + T.offsetHeight - 5) + 'px';
                            left = p.l + 'px';
                            T.style.display = a
                        };
                        with(iframe.style) {
                            top = div.offsetTop + 'px';
                            left = div.offsetLeft + 'px';
                            width = div.offsetWidth + 'px';
                            height = div.offsetHeight + 'px';
                            margin = "";
                            display = 'block'
                        };
                        clearInterval(timerCont)
                    }
                },
                50)
            };
            if (!clickpopjs) {
                clickpopjs = creElm({
                    //src: 'http://www.jiathis.com/code/ckepop.js',
					src: 'http://add.shiqi123.com/code/ckepop.js',
                    charset: 'utf-8'
                },
                'script', head);
                clickpopjs.onloaded = 0;
                clickpopjs.onload = function () {
                    clickpopjs.onloaded = 1;
                    fn()
                };
                clickpopjs.onreadystatechange = function () {
                    /complete|loaded/.test(clickpopjs.readyState) && !clickpopjs.onloaded && fn()
                }
            } else {
                fn()
            }
            return false
        },
        out: function () {
            timer = setTimeout(function () {
                div.style.display = 'none';
                div1.style.display != 'block' && (iframe.style.display = 'none')
            },
            100)
        },
        move: function () {
            clearTimeout(timer)
        },
        center: function () {
            div.style.display = iframe.style.display = 'none';
            if (!this.script) {
                this.script = creElm({
                    //src: 'http://www.jiathis.com/code/ckecenterpop.js',
					src: 'http://add.shiqi123.com/code/ckecenterpop.js',
                    charset: 'utf-8'
                },
                'script', head);
                db.style.position = 'static'
            } else {
                var a = getS();
                div1.style.display = "block";
                div1.style.margin = (-div1.offsetHeight / 2 + a.t) + "px " + (-div1.offsetWidth / 2 + a.l) + "px";
                list = d.getElementById('ckelist'),
                clist = list.cloneNode(true),
                h = clist.getElementsByTagName('input');
                for (var i = 0, ci; ci = h[i++];) {
                    texts[ci.value] = ci.parentNode
                };
                with(iframe.style) {
                    left = top = '50%';
                    width = div1.offsetWidth + 'px';
                    height = div1.offsetHeight + 'px';
                    margin = div1.style.margin;
                    display = 'block'
                }
            };
            return false
        },
        choose: function (o) {
            clearTimeout(inputTimer);
            inputTimer = setTimeout(function () {
                var s = o.value.replace(/^\s+|\s+$/, ''),
                    frag = d.createDocumentFragment();
                for (var p in texts) {
                    eval("var f = /" + (s || '.') + "/ig.test(p)");
                    f && frag.appendChild(texts[p].cloneNode(true))
                }
                list.innerHTML = '';
                list.appendChild(frag)
            },
            100)
        },
        centerClose: function () {
            iframe.style.display = div1.style.display = 'none'
        }
    };
    var h = d.getElementsByTagName('a');
    for (var i = 0, ci, tmp; ci = h[i++];) {
        if (/\bjiathis\b/.test(ci.className)) {
            ci.onmouseout = $CKE.out;
            ci.onmousemove = $CKE.move;
            ci.onclick = $CKE.center;
            ci.onmouseover = $CKE.over;
            ci.hideFocus = true;
            continue
        };
        if (ci.className && (tmp = ci.className.match(/^jiathis_button_(\w+)$/)) && tmp[1]) {
            ci.innerHTML = '<span class="jtico button jtico_' + tmp[1] + '"></span>';
            ci.onclick = function (a) {
                return function () {
                    jiathis_sendto(a)
                }
            }(tmp[1]);
            ci.href = '#';
            ci.title = 'send to ' + tmp[1]
        }
    };
    div.onmouseover = function () {
        clearTimeout(timer)
    };
    div.onmouseout = function () {
        $CKE.out()
    };
    ie ? d.attachEvent("onclick", $CKE.disappear) : d.addEventListener("click", $CKE.disappear, false)
}();

function jiathis_sendto(a) {
    var e = encodeURIComponent,
        conf;
    try {
        conf = jiathis_config
    } catch(err) {
        conf = {}
    };
    window.open('http://add.shiqi123.com/send/?webid=' + a + '&url=' + e(conf.url || location) + '&title=' + e(conf.title || document.title) + (conf.un ? '&un=' + conf.un : ''), '');
    return false
}
function jt_copyUrl() {
    var a = this.location.href;
    var b = document.title;
    if (window.clipboardData) {
        var c = b + "\n" + a;
        var d = window.clipboardData.setData("Text", c);
        if (d) alert("复制成功,请粘贴到你的QQ/MSN上推荐给你的好友！")
    } else {
        alert("目前只支持IE，请复制地址栏URL,推荐给你的QQ/MSN好友！")
    }
};

function jt_addBookmark(a) {
    var b = parent.location.href;
    if (window.sidebar) {
        window.sidebar.addPanel(a, b, "")
    } else if (document.all) {
        window.external.AddFavorite(b, a)
    } else if (window.opera && window.print) {
        return true
    }
}