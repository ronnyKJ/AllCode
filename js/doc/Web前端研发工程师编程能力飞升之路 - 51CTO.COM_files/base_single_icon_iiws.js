spsupport.p = {
    sfDomain :  superfish.b.pluginDomain,
    sfDomain_ : superfish.b.pluginDomain.replace("https","http"),
    imgPath : superfish.b.pluginDomain.replace("https","http") + "images/",
    cdnUrl : superfish.b.cdnUrl,
    appVersion : superfish.b.appVersion,
    clientVersion : superfish.b.clientVersion,
    site :  superfish.b.pluginDomain,
    sessRepAct : "trackSession.action",
    isIEQ : ( +document.documentMode == 5 ? 1 : 0 ),
    sfIcon : {
        nl: 0,
        maxSmImg : {
            w : 88,
            h : 70
        },
        ic: 0,
        evl: 'sfimgevt',
        icons : [],
        big : {
            w : 95,
            h : 25
        },
        small : {
            w : 65,
            h : 25
        },
        an: 0,
        imPos: 0,
        prog : {
            time : 1000,
            node : 0,
            color : "#398AFD",
            opac  : "0.3",
            e: 0,   /* end */
            w : [ 93, 63 ],
            h : 23
        }
    },
    temp: 0,

    onFocus : -1,
    psuHdrHeight : 22,
    psuRestHeight : 26,
    oopsTm : 0,
    iconTm : 0,
    dlsource : superfish.b.dlsource,
    w3iAFS : superfish.b.w3iAFS,
    CD_CTID: superfish.b.CD_CTID,
    userid: superfish.b.userid,
    statsReporter: superfish.b.statsReporter,
    minImageArea : ( 60 * 60 ),
    aspectRatio : ( 1.0/2.0 ),
    supportedSite : 0,
    ifLoaded : 0,
    ifExLoading: 0,
    // overIcon: 0,
    itemsNum : 1,
    tlsNum: 1,
    statSent : 0,

    icons: 0,
    partner : ( superfish.b.partnerCustomUI ? superfish.b.images + "/" : "" ),
    
    iCpn : 0,

    prodPage: {
        s: 0,   // sent - first request
        i: 0,   // images count
        p: 0,   // product image
        e: 0,   // end of slideup session
        d: 210, // dimension of image
        l: 1000, // line - in px from top
        reset : function(){
            this.s = 0;   
            this.i = 0;   
            this.p = 0;   
            this.e = 0;   
        }        
    },
    
    SRP: {
        p: [],    // pic
        i: 0,    // images count
        c: 0,   /* counter of tries */
        ind: 0, /* index of current image */
        lim: 0, /* limit of requests on SRP */
        reset : function(){
            this.p = [];   
            this.i = 0;            
            this.c = 0;
        }        
    },
    
    before : -1  // Close before
};
spsupport.api = {
    jsonpRequest: function(url, data, successFunc, errorFunc, callBack, postCB){
        try{
            if( callBack == null ){
                var date = new Date();
                callBack = "superfishfunc" + date.getTime();
            }
            window[callBack] = function(json) {
                if(successFunc != null)
                    successFunc(json);
            };
            sufio.io.script.get({
                url: url + ( url.indexOf("?") > -1 ? "&" : "?" ) + "callback=" + callBack,
                content: data,
                load : function(response, ioArgs) {
                    window[callBack]  = null;
                    if( !sufio.isIE ){
                        if( postCB) {
                            setTimeout(function() {
                                postCB();
                            }, 50);
                        }
                    }
                },
                error : function(response, ioArgs) {
                    window[callBack]  = null;
                    if(errorFunc != null)
                        errorFunc( response, ioArgs);

                    if( !sufio.isIE ){
                        if( postCB) {
                            setTimeout(function() {
                                postCB();
                            }, 50);
                        }
                    }
                }

            });
        }
        catch(ex){
        }
    },
  
    sTime : function( p ){
        if( p == 0 ){
            this.sTB = new Date().getTime();
            this.sT = 0;
        }else if(p == 1){
            this.sT = new Date().getTime() - this.sTB;
        }else{
            return ( spsupport.p.before == 1 && this.sT == 0 ? new Date().getTime() - this.sTB : this.sT );
        }
    },

    toPCase: function( s ){
        return s.replace(/\w\S*/g, function(t){
            return t.charAt(0).toUpperCase() + t.substr(1).toLowerCase();
        });
    },
    getDomain: function(){
        var dD = document.location.host;
        var dP = dD.split(".");
        var len = dP.length;
        if ( len > 2 ){
            var co = ( dP[ len - 2 ] == "co" ? 1 : 0 );
            dD = ( co ? dP[ len - 3 ] + "." : "" ) + dP[ len - 2 ] + "." + dP[ len - 1 ];
        }
        return dD;
    },
    validDomain: function(){
        try{
            var d = document;
            if( d == null || d.domain == null ||
                d == undefined || d.domain == undefined || d.domain == ""
                || d.location == "about:blank" || d.location == "about:Tabs"
                || d.location.toString().indexOf( "superfish.com/congratulation.jsp" ) > -1  ){
                return false;
            }else{
                return (/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,5}$/).test( d.domain );
            }
        }catch(e){
            return false;
        }
    },

    init: function(){
        var sp = spsupport.p;
        if( window.sufio )
            return;

        if( !spsupport.api.validDomain() )
            return;

        this.dojoReady = 0;

        if ( ! top.djConfig ){
            djConfig = {}
        }
        djConfig.afterOnLoad = true;
        // djConfig.baseUrl = sp.cdnUrl;
        djConfig.baseScriptUri = sp.cdnUrl;
        djConfig.useXDomain = true;
        djConfig.scopeMap = [ ["dojo", "sufio"], ["dijit", "sufiw"], ["dojox", "sufix"] ];
        djConfig.require = ["dojo.io.script" ,"dojo._base.html", "dojo.window"];
        djConfig.modulePaths =  {
            "dojo": sp.cdnUrl + "dojo",
            "dijit": sp.cdnUrl + "dijit",
            "dojox": sp.cdnUrl + "dojox"
        };

        superfish.b.inj(  sp.cdnUrl + "dojo/dojo.xd.js",
            1,1,
            function(){
                sufio.addOnLoad(function(){
                    spsupport.api.dojoLoaded();
                });
            });

    },
    
    sSrp: function() {
        var sp = spsupport.p;
        var sa = spsupport.api;
        if (sp.SRP.c < sp.SRP.lim && sp.SRP.ind < sp.SRP.p.length) {
            // spsupport.log(sp.SRP.p[sp.SRP.c].src);
            sp.prodPage.p = sp.SRP.p[sp.SRP.ind];
            sa.puPSearch(1, sp.SRP.p[sp.SRP.ind]);
            sp.SRP.ind++;
            sp.SRP.c++;
        }        
    },
    
    gotMessage: function( param, from ){
        if(from && from.indexOf("superfish.com") == -1 ){
            return;
        }

        if ( param ){
            param = param + "";
            var prep = param.split( "|" );
        }
        var sp = spsupport.p;
        var i;
        var fromPsu = ( prep.length > 4 ? 1 : 0);
        if ( fromPsu ) {
            if (sp.prodPage.e) {
                return;
            }
        }

        param = ( +prep[ 0 ] );
        // spsupport.log("5 gotMessage " + param);
        
        var sfu = superfish.util;
      
        var sa = spsupport.api;
        if( param == 101 ){ // sys down
            sfu.sysDown();
        }
        else{
            if( param == -7890 ){ // init
                sp.ifLoaded = 1;
                if( sfu && sfu.standByData != 0 ){
                    sa.sTime(0);
                    sfu.sendRequest( sfu.standByData );
                    sfu.standByData = 0;
                }
            }
            else if( param >= 200 && param < 2000 ){
                // 20 -  ( slideup paused )
                // 200 - ( idrentical only - false, failure )
                // 201 - ( idrentical only - false, identical is empty, similar not empty )
                // 210 - ( idrentical only - false, identical is not empty, similar is empty )
                // 211 - ( idrentical only - false, identical is not empty, similar is not empty )

                sp.itemsNum = +prep[1];
                sp.tlsNum = +prep[2];
                sfu.updIframeSize(sp.itemsNum, sp.tlsNum, fromPsu);
                sfu.hideFishPreload();
                if (!fromPsu) {
                    if (superfish.inimg) { 
                        for (i in superfish.inimg.res) {
                            superfish.inimg.res[i] = 0;
                        }

                        if (param < 221) {}
                        else {
                            superfish.inimg.res[prep[3]] = sp.itemsNum;
                            superfish.inimg.spl(prep[3]);
                        }
                    }
                    if (sfu.currImg == sp.sfIcon.ic.img && sp.sfIcon.prog.e > 0) {
                        sfu.openPopup(sp.imPos, sp.appVersion, 0);
                    }
                }

                sa.sTime(1);
                sp.before = 0;

                if( param == 200 ){
                    if( !fromPsu) {
                        if (superfish.p.onAir != 2) {
                            if (sfu.currImg) {
                                sfu.currImg.setAttribute("sfnoicon", "1");
                            }
                            // var actIcon = sfu.lastAIcon.img;
                            //                            sp.iconTm = setTimeout(function() {
                            //                                if (actIcon) {
                            //                                    sufio.fadeOut({
                            //                                        node: actIcon,
                            //                                        duration: 600,
                            //                                        onEnd: function() {
                            //                                            sufio.destroy( this.node );
                            //                                        }
                            //                                    }).play(10);
                            //                                }
                            //                            }, 200 );

                            if (! superfish.b.coupons || prep.length <= 2) {
                                sp.oopsTm = setTimeout(function() {
                                    if(!sufio.isIE){
                                        sufio.fadeOut({
                                            node: sfu.bubble(),
                                            duration: 800,
                                            onEnd: function() {
                                                sfu.closePopup();
                                            }
                                        }).play(10);
                                    }
                                    else {
                                        sfu.closePopup();
                                    }
                                }, 3000 );
                            }
                        }
                    }
                    else {
                        if( !sp.prodPage.e &&  sp.prodPage.s ) {
                            if(superfish.b.inimgSrp && sp.prodPage.i == 0) {
                                // spsupport.log("the request is from psu, no answer " + sp.prodPage.s + " to 0");
                                sp.prodPage.s = 0;
                                sa.sSrp();
                            // superfish.publisher.send();
                            }
                        }
                    }
                }
                else if( param > 200 ){
                    if( superfish.b && (superfish.b.suEnabled[0] || superfish.b.suEnabled[1] || superfish.b.inimg)  && fromPsu){
                        if( sp.prodPage.s && !sp.prodPage.e && superfish.p.onAir == 2){
                            sp.prodPage.e = 1;
                            // sp.prodPage.s = 0;
                            if (superfish.b.inimg && superfish.inimg && superfish.inimg.itn) {
                                superfish.inimg.init(prep[3], +prep[4], sufio, sfu, spsupport.p, superfish.b, sp.prodPage.p);
                                if(superfish.b.inimgSrp && sp.prodPage.i == 0) {
                                    // spsupport.log("the request from Psu brought answer " + sp.prodPage.s + " to 0");
                                    sp.prodPage.s = 0;
                                    sp.prodPage.e = 0;
                                    sa.sSrp();
                                // superfish.publisher.send();
                                }
                            }
                            else if (superfish.b.initPSU) {
                                superfish.b.initPSU( prep[2] );
                            }
                        }
                        superfish.util.requestImg();
                    }
                }
            }
            else if (param > 2001) {
                if (prep[1]) {
                    sp.before = 0;
                    superfish.sg.init(prep[1]);
                    sfu.closePopup();
                }
            }

            else if( param == 10 ){
                sfu.bCloseEvent( document.getElementById("SF_CloseButton"), 4);
            }
            else if( param == 11 ){
                sfu.bCloseEvent( document.getElementById("SF_CloseButton"), 5);
            }
            else if( param == 20 ){
                sfu.closePopup();
            }
            else if( param == 30 ){
                superfish.publisher.report(101);
            }

        }
    },

    dojoLoaded: function()  {
        var sp = spsupport.p;
        this.dojoReady = 1;
        if (!spsupport.sites.isBlackStage()) {
            spsupport.api.userIdInit();
            if( window.sufio && window.sufio.isIE && window.spMsiSupport ){
                if( !this.isOlderVersion( '1.2.1.0', sp.clientVersion ) ){
                    spMsiSupport.validateUpdate();
                }
                if(window.sufio.isIE == 7) {
                    sp.isIEQ = 1;
                }
            }

            setTimeout( function(){
                spsupport.sites.care();
            }, 1 );

            setTimeout( function(){
                sufio.addOnWindowUnload(window, function() {
                    try{
                        if( window.sp && window.sp.onAir ){
                            superfish.util.bCloseEvent( sufio.byId("SF_CloseButton"), 2 );
                        }
                    }catch(e){}
                });
            }, 2000 );
        }
    },

    userIdInit: function(){
        var sp = spsupport.p;
        var spa = spsupport.api;
        var data = {
            "dlsource":sp.dlsource
        }
        if(sp.w3iAFS != ""){
            data.w3iAFS = sp.w3iAFS;
        }

        if( sp.CD_CTID != "" ){
            data.CD_CTID = sp.CD_CTID;
        }

        if(sp.userid != "" && sp.userid != undefined){
            spa.onUserInitOK({
                userId: sp.userid,
                statsReporter: sp.statsReporter
            });
        } else { // widget
            spa.jsonpRequest(
                sp.sfDomain_ + "initUserJsonp.action",
                data,
                spa.onUserInitOK,
                spa.onUserInitFail,
                "superfishInitUserCallbackfunc"
                );
        }
    },

    onUserInitOK: function(obj) {
        var sa = spsupport.api;
        var sp = spsupport.p;
        
        if(!obj || !obj.userId || (obj.userId == "")){
            sa.onUserInitFail();
        } else{
            sp.userid = obj.userId;
            sp.statsReporter = obj.statsReporter;
            sa.isURISupported( document.location );
        }
    },


    ASU_OK : function( obj ){
        if( !obj ){
            spsupport.api.AS_Fail();
        }
        else{ }
    },
    ASU_Fail : function(){},

    isURISupported: function(url){
        var sfa = spsupport.api;
        spsupport.p.merchantName = "";
        sfa.jsonpRequest(
            spsupport.p.sfDomain_ + "getSupportedSitesJSON.action?ver=" + superfish.b.wlVersion,
            0,
            sfa.isURISupportedCB,
            sfa.isURISupportedFail,
            "SF_isURISupported");
    },
    
    injCpn: function(st) {  /* st - site type: 1 - wl, 2 - st, 3 - cpn wl */
        var sp = spsupport.p;
        sp.iCpn = 1;
        superfish.b.inj("coupons/get.jsp?pi=" + sp.dlsource + "&ui=" + sp.userid + "&st="+st /* + "&mn="+spsupport.p.merchantName */, 1, 0);
    },    
    
    prc: function(id, pc) {
        var num = id.charCodeAt(id.length - 1) + id.charCodeAt(id.length - 2) - 96;
        var rg = 100/148; /* range: (122+122)-(48+48) */        
        return (num*rg < pc); 
    },

    isURISupportedCB: function(obj) {
        var sfa = spsupport.api;
        var sp = spsupport.p;
        var sfb = superfish.b;
        var w = spsupport.whiteStage;

        sp.totalItemCount = obj.totalItemCount;
        var sS = obj.supportedSitesMap[ sfa.getDomain() ];

        superfish.partner.init();
        superfish.publisher.init();
        if( sS ) {
            sp.supportedSite = 1;
            if ( spsupport.sites.su() > 10 ) {
                if( sfb.suEnabled[1] > 10 ){
                    sfb.suEnabled[1] = ( sp.userid.charCodeAt( sp.userid.length - 1 ) %  ( sfb.suEnabled[1]-10 ) == 0 ? 1 : 0 );
                }
            }else{
                sfb.suEnabled[1] = 0;  
            }
        }
        else {
            if (!sfb.ignoreWL) {
                var id = new Date().getTime() + "";
                w.st = (sfb.stDt ? w.isStore() : 0);                
                // w.rv = (w.st ? 0 : (sfa.prc(id, superfish.b.rvDt) ? w.isReview() : 0));

            }
            if (sfb.ignoreWL || w.st /*|| w.rv */) {
                sS = {};
                sS.imageURLPrefixes = "";
                sS.merchantName = sfa.getDomain();

                if (w.st) {
                    sfb.icons = 0;
                    sp.prodPage.d = 149;
                    //                    sfb.multiImg = 1;
                    //                    superfish.publisher.limit = 1;
                    superfish.b.inimgSrp = 0;
                }
//                else 
//                if(w.rv) {
//                    sfb.icons = 0;
//                    sfb.multiImg = 1;
//                    superfish.publisher.limit = 1; 
//                    superfish.b.inimgSrp = 0;
//                }
            }
        }
        
        if( sS && !sfa.isBLSite( obj )){
            sfa.injectIcons( sS );
        }
        else {
            if (superfish.b.rvDt) {
            //request revew WL            
                sfa.jsonpRequest(
                    spsupport.p.sfDomain_ + "rvwl.action?ver=" + sfb.rvWLver,
                    0,
                    sfa.rvWlCB,
                    sfa.rvWlFail,
                    sfb.rvWLcb);
            }     

            if (superfish.b.cpn[0] || superfish.b.cpn[1]) {
            //request coupons WL            
                sfa.jsonpRequest(
                    spsupport.p.sfDomain_ + "getCouponsSupportedSites.action?ver=" + sfb.cpnWLver,
                    0,
                    sfa.cpnWlCB,
                    sfa.cpnWlFail,
                    sfb.cpnWLcb);           
            }

            if( !sp.icons ){
                setTimeout(sfa.saveStatistics, 400);
            }
        }
    },
    
    cpnWlCB: function(o) {      
        var sa = spsupport.api;
        var d = sa.getDomain();
        if (o.a && o.a.indexOf(d) > -1 && !spsupport.p.iCpn) {
            sa.injCpn(3);
        }
    },

    cpnWlFail: function(o) {
    },

    rvWlCB: function(o) {      
        var sa = spsupport.api;
        var sp = spsupport.p;
        var sfb = superfish.b;
        
        var sS = o.supportedSitesMap[ sa.getDomain() ];  
        if( sS ) {
            spsupport.whiteStage.rv = 1;
            sfb.icons = 0;
            sfb.inimgSrp = (sfb.inimg ? 1 : 0);
            sa.injectIcons( sS );
        }
    },

    rvWlFail: function(o) {
    },


    isURISupportedFail: function(obj) {
    },

    isBLSite: function(obj){
        var isBL = 0;
        if ( obj.blockedSubDomains ){
            for (var s = 0 ; s < obj.blockedSubDomains.length && !isBL ; s++ ){
                var loc = top.location + "";
                if (loc.indexOf(obj.blockedSubDomains[s]) >= 0){
                    isBL = 1;
                }
            }
        }
        return isBL;
    },
    injectIcons: function( sS ) {
        spsupport.p.supportedImageURLs = sS.imageURLPrefixes;
        spsupport.p.merchantName = sS.merchantName;
        spsupport.sites.preInject();
        spsupport.api.careIcons( 0 );
    },
    addSuperfishSupport: function(){
        superfish.b.xdmsg.init(
            spsupport.api.gotMessage,
            ( spsupport.br.isIE7 ? 200 : 0 ) );

        if( !top.superfishMng ){
            top.superfishMng = {};
        }
        if( !top.superfish ){
            top.superfish = {};
        }

        if( !top.superfish.p ){ // params
            top.superfish.p = {
                site : spsupport.p.site,
                totalItemsCount: spsupport.p.totalItemCount,
                cdnUrl : spsupport.p.cdnUrl,
                appVersion : spsupport.p.appVersion
            };
        }

        if( !top.superfish.util ){
            superfish.b.inj( "js/sf_si.js?version=" + spsupport.p.appVersion, 1,0 );
        }

    //        if( !spsupport.api.pluginDiv() ) {
    //            sufio.place("<div id='superfishPlugin'></div>", sufio.body());
    //        }
    },

    careIcons: function( rep ){
        var sp = spsupport.p;
        var spd = spsupport.domHelper;
        
        sp.icons = this.startDOMEnumeration();
        if (window.conduitToolbarCB && sp.icons > 0 && spsupport.isShowConduitWinFirstTimeIcons){
            conduitToolbarCB("openPageForFirstTimeIcons");
        }

        if( sp.icons > 0 || spsupport.sites.ph2bi() ){
            spsupport.api.addSuperfishSupport();
//            if (superfish.b.suEnabled[0] || superfish.b.suEnabled[1]) {
//                spd.addMouseMoveEvent(function() {
//                    if(sp.onFocus == -1) {
//                        sp.onFocus = 1;
//                        superfish.b.setTimer();
//                    }
//                    window.onmousemove = spsupport.domHelper.oldOnMouseMove;
//                });
//            }
            
            spd.addOnresizeEvent(function() {
                spsupport.api.setPopupInCorner();
                spsupport.api.startDOMEnumeration();
            });

            spd.addFocusEvent(function() {
                sp.onFocus = 1;
//                if (superfish.b.setTimer) {
//                    superfish.b.setTimer();
//                }
                spsupport.api.startDOMEnumeration();
            });

            spd.addBlurEvent(function() {
                sp.onFocus = 0;
                if (superfish.b.tm) {
                    clearTimeout(superfish.b.tm);
                }
            });

            spd.addUnloadEvent(spsupport.api.unloadEvent);
            spsupport.api.vMEvent();

            sufio.addOnLoad(function(){
                setTimeout( function(){
                    // spsupport.api.wRefresh(1000);
                    spsupport.api.wRefresh(1300);
                    setTimeout("spsupport.api.saveStatistics()", 850)
                }, spsupport.sites.gRD() );
            });
        }else{
            if( rep == 7 ){
                spsupport.api.saveStatistics();
            }
            else{
                setTimeout( "spsupport.api.careIcons( " + ( ++rep ) + ");", ( 1300 + rep * 400 ) ) ;
            }
        }
    },
    
    vMEvent : function(){
        try{
            if( window.superfish && window.superfish.util ){
                var pDiv = superfish.util.bubble();
                if( pDiv ){
                    spsupport.domHelper.addEListener( pDiv, spsupport.api.blockDOMSubtreeModified, "DOMSubtreeModified");
                    return;
                }
            }
        }catch(e){}
        setTimeout( "spsupport.api.vMEvent()", 500 );
    },

    puPSearch : function(rep, im){
        // spsupport.log("puPSearch " + rep);
        if (rep < 101) {
            var sp = spsupport.p;
            var sg = superfish.sg;
            var si = superfish.inimg;
            if(superfish.b.suEnabled[0] || superfish.b.suEnabled[1] || superfish.b.inimg || (sg && sg.sSite) ){
                if( sp.prodPage.s < 2 || ( superfish.p && superfish.p.onAir == 1 ) ){
                    setTimeout(
                        function(){
                            var sfu = superfish.util;
                            if (sfu) {
                                // spsupport.log("if sfu sp.prodPage.s = " + sp.prodPage.s + " sp.prodPage.e = " + sp.prodPage.e);
                                if( sp.prodPage.s < 2 && !sp.prodPage.e){
                                    var o = spsupport.api.getItemPos(im);
                                    spsupport.p.imPos = o;
                                    var ob = spsupport.api.getItemJSON(im);
                                    var ifSg = (sg ? sg.sSite : 0);
                                    var ii = (superfish.b.inimg && si ? si.vi(o.w, o.h) : 0);
                                    ii = (ii > 1 ? ii : 0);
                                    ii = (!superfish.b.inimgSrp && superfish.b.suEnabled[1] && sp.prodPage.i <= 0 ? 0 : ii);
                                    if (superfish.inimg) {
                                        superfish.inimg.itn = ii;
                                    }
                                    // sp.SRP.p
                                    var c1 = 1; // (ii > 1 ? 0 : 1);        /* get items card by card or first from each card */
                                    if (superfish.b.inimg && si && ii < 2 && !ifSg) { /* if no room for ii avoid request */
                                        //spsupport.log("puPSearch 111");
                                        // sp.prodPage.s = 0;
                                        // sp.prodPage.e = 1;
                                        if (superfish.b.inimgSrp && sp.prodPage.i == 0) {
                                            sp.SRP.c = (sp.SRP.c > 0 ? sp.SRP.c-1 : 0);
                                            spsupport.api.sSrp();
                                        }
                                    // superfish.publisher.send();
                                    }   
                                    else {
                                        //spsupport.log("puPSearch 222");
                                        sfu.prepareData(ob, 1, ifSg, c1, ii, (si ? si.iiInd : 0));                                    
                                        sfu.openPopup(o, sp.appVersion, 1 );
                                        sfu.lastAIcon.x = o.x;
                                        sfu.lastAIcon.y = o.y;
                                        sfu.lastAIcon.w = o.w;
                                        sfu.lastAIcon.h = o.h;
                                        sp.prodPage.s = 2;
                                    }
                                }
                            }
                            else { 
                                setTimeout(function() {
                                    spsupport.api.puPSearch(rep+1, im);
                                }, 100);
                            }
                        }, 30 );
                }
            }
        }
    },

    onDOMSubtreeModified: function( e ){
        var spa = spsupport.api;
        spa.killIcons();
        if(spa.DOMSubtreeTimer){
            clearTimeout(spa.DOMSubtreeTimer);
        }
        spa.DOMSubtreeTimer = setTimeout("spsupport.api.onDOMSubtreeModifiedTimeout()",1000);
    },
    onDOMSubtreeModifiedTimeout: function(){
        clearTimeout(spsupport.api.DOMSubtreeTimer);
        spsupport.api.startDOMEnumeration();
    },
    blockDOMSubtreeModified: function(e,elName){
        e.stopPropagation();
    },
    createImg : function( src ) {
        var img = new Image();
        img.src = src;
        return img;
    },
    loadIcons : function() {
        var sp = spsupport.p;
        if( sp.sfIcon.icons.length == 0 ){
            for (var i = 0; i < 4; i++) {
                sp.sfIcon.icons[ i ] = spsupport.api.createImg( sp.imgPath + sp.partner + "si" + i + ".png?v=" + sp.appVersion );
            }
        }
    },

    killIcons : function() {
        superfish.publisher.imgs = [];
        var bs = this.sfButtons();
        if( bs ){
            document.body.removeChild( bs );
            try{
                if( superfish && superfish.util ){
            //           superfish.util.lastAIcon.img = 0;
            }
            }catch(ex){}
        }
        if (spsupport.p.sfIcon && spsupport.p.sfIcon.ic) {
            spsupport.p.sfIcon.ic.style.top = -200 + "px";
        }
    },

    startDOMEnumeration: function(){
        var sfa = spsupport.api;
        var ss = spsupport.sites;
        var sp = spsupport.p;
        var sb = superfish.b;
        var found = 0;
        sfa.killIcons();
        sp.SRP.p = [];
        if( ss.validRefState() ){
            if (sb.icons) {
                var imSpan = sufio.place("<span id='sfButtons'></span>", sufio.body());
            }

            var iA = ss.gVI();
            var images = ( iA ? iA : document.images );
            var imgType = 0;

            for( var i = 0; i < images.length; i++ ){
                imgType = sfa.isImageSupported( images[i] );
                if( imgType ){
                    if (sb.icons) {
                        if (! found) {
                            sfa.loadIcons();
                            sfa.addSFProgressBar( imSpan );
                            if (!sp.sfIcon.ic) {
                                sfa.addSFIcon(sufio.body(), 1);
                            }
                            sfa.addAn();
                        }
                        sfa.addSFDiv(imSpan, images[i]);
                    }                    
                    if( !superfish.b.multiImg ){
                        var imgPos = spsupport.api.getImagePosition(images[i]);
                        var res = spsupport.api.validateSU(images[i], parseInt( imgPos.y + images[i].height - 45 )); 
                        if (superfish.b.cpn[0] && res && !sp.iCpn) {
                            sfa.injCpn(spsupport.p.supportedSite ? 1 : 2);
                        }
                        if( !res &&  !sp.prodPage.i /* && !sp.SRP.i */ ){
                            sp.SRP.p[sp.SRP.p.length] = images[i];
                            sp.SRP.i ++;
                        }
                    }
                    
                    superfish.publisher.pushImg(images[i]);
                    found++;
                }
            //                else {
            //images[i].setAttribute(sp.sfIcon.evl, '-1');
            //                }
            }
            
            if( (sb.suEnabled[1] || superfish.b.inimgSrp) && spsupport.sites.su() && !sp.prodPage.p && !sp.prodPage.s && sp.SRP.p.length ){  
                //sp.prodPage.i ++;
                if( superfish.sg ){
                    superfish.sg.sSite = 0;
                }
                sp.SRP.lim = (superfish.b.inimgSrp ? superfish.b.inimgSrp : (sb.suEnabled[1] ? sb.suEnabled[1] : 0));
                sp.SRP.lim = Math.min(sp.SRP.lim, sp.SRP.p.length);
                
                sfa.sSrp();
            }     
            if(found > 0){
                if (sb.icons) {
                    sp.sfIcon.nl = sufio.query("div", imSpan);
                }

                setTimeout(
                    function(){
                        if( !spsupport.p.statSent ){
                            sfa.saveStatistics();
                            spsupport.p.statSent = 1;
                        }
                    }, 700);
            }
        }
        return found;
    },

    imageSupported: function( src ){
        if( src.indexOf( "amazon.com" ) > -1  && src.indexOf( "videos" ) > -1 ){
            return 0;
        }

        try{
            var sIS = spsupport.p.supportedImageURLs;

            if( sIS.length == 0 )
                return 1;
            for( var i = 0; i < sIS.length; i++ ){
                if( src.indexOf( sIS[ i ] ) > -1 ){
                    return 1;
                }
            }
        }catch(ex){
            return 0;
        }
        return 0;
    },

    isImageSupported: function(img){
        var sp = spsupport.p;
        var evl = +img.getAttribute(sp.sfIcon.evl);

        if(evl == -1) {
            return 0;
        } 
        if(evl == 1) {
            return 1;
        } 
        
        var src = "";
        try{
            src = img.src.toLowerCase();
        }catch(e){
            return 0;
        }

        var iHS = src.indexOf("?");
        if( iHS != -1 ){
            src = src.substring( 0, iHS );
        }
        
        var sp = spsupport.p;

        //        for( var z = 0; z < 4; z ++ ){
        //            if( src.substring( sp.sfIcon.icons[ z ] ) > -1 ){
        //                return 0;
        //            }
        //        }

        if( src.length < 4 )
            return 0;

        var ext = src.substring(src.length - 4,src.length);
        if((ext == ".gif") || (ext == ".png") || (ext == ".php")) {
            return 0;
        }
 
        var iW = img.width;
        var iH = img.height;

        if( ( iW * iH ) < sp.minImageArea ) {
            return 0;
        }
        var ratio = iW/iH;
        if( ( iW * iH > 2 * sp.minImageArea ) &&
            ( ratio < sp.aspectRatio || ratio > ( 1 / sp.aspectRatio ) ) ) {
            return 0;
        }

        //        if ( ratio < (1.0/3.0) || ratio > 3.0 ) {
        //            return 0;
        //        }

        if (img.getAttribute("usemap")) {
            return 0;
        }


        if( !this.imageSupported( img.src ) ) {
            return 0;
        }

        if( !spsupport.api.isVisible( img ) ){
            return 0;
        }


        if( spsupport.sites.imgSupported( img ) ){
            if(( iW <= sp.sfIcon.maxSmImg.w ) || ( iH <= sp.sfIcon.maxSmImg.h ) ) {
                return 2;
            }
            else {
                return 1;
            }
        }else{
            return 0;
        }
    },

    setPopupInCorner : function () {
        var sp = superfish.p;
        var su = superfish.util;
        if( superfish && sp && sp.onAir == 2 && spsupport.p.before == 0 && (superfish.b.suEnabled[0] || superfish.b.suEnabled[1])){
            var vp = sufio.window.getBox();
            var sl = su.bubble().style;
            var t = 0;
            if(superfish.b.slideUpOn){
                var slL = (vp.w - sp.width - 4);
                var slT = (vp.h - (sp.height + su.hdr*2) - 4);
                if( spsupport.p.isIEQ ){
                    slL = slL + vp.l;
                    slT = slT + vp.t;
                }
                sl.left = slL + "px";
                sl.top = superfish.publisher.fixSuPos(slT) + "px";
            }
            var pSU = su.preslideup();
            if( pSU ){
                slL = vp.w - parseInt( pSU.style.width );
                slT = vp.h - parseInt( pSU.style.height );
                slL = (superfish.b.newSu ? slL - 16 : slL - 40);
                slT = (superfish.b.newSu ? slT - 15 : slT);
                if (spsupport.p.isIEQ) {
                    slL = slL + vp.l;
                    slT = slT + vp.t;
                }
                pSU.style.left = slL + "px";
                if (superfish.b.slideUpOn) {
                    t = ( parseInt( sl.top ) - spsupport.p.psuHdrHeight );
                }
                else {
                    t = (superfish.b.preSlideUpOn == 2 ? slT : (slT + parseInt( pSU.style.height ) - spsupport.p.psuRestHeight));
                    t = superfish.publisher.fixSuPos(t);
                }
                pSU.style.top = t + "px";
            }
        }
    },

    fixPosForIEQ : function( e ) {
        spsupport.api.setPopupInCorner();
        var vp = sufio.window.getBox();
        var oS = superfish.util.overlay().style;
        oS.left = vp.l;
        oS.top = vp.t;
    },

    wRefresh : function( del ){
        //        var ic = spsupport.api.sfButtons();
        //        if (ic) {
        //            sufio.fadeOut({
        //                node: ic,
        //                duration: del ,
        //                onEnd: function() {
        //                    setTimeout( function() {
        //                        spsupport.api.startDOMEnumeration();
        //                    }, del * 2 );
        //                }
        //            }).play();
        //        }
        setTimeout( function() {
            spsupport.api.startDOMEnumeration();
        }, del * 2 );
    },


    isViewable: function ( vP, obj ){
        return (   vP.scrollLeft < ( obj.offsetLeft  + obj.offsetWidth ) &&
            ( obj.offsetLeft + obj.offsetWidth - vP.scrollLeft < vP.offsetWidth )  );
    },
        
    isVisible: function( obj ){
        if( obj == document ) return 1;
        if( !obj ) return 0;
        if( !obj.parentNode ) return 0;
                
        var ds = sufio.style(obj, "display");
        var vs = sufio.style(obj, "visibility");
        
        if (ds == 'none' || vs == 'hidden') {
            return 0;
        }

        return spsupport.api.isVisible( obj.parentNode );
    },

    sfIPath: function( iType ){ /* 1 - large, 2 - small */
        var sp = spsupport.p;
        var icn = ( iType == 2  ?  2  :  0 );
        return( {
            r : sp.sfIcon.icons[ icn ].src,
            o : sp.sfIcon.icons[ icn + 1 ].src
        } );
    },
    
    shOverlay: function() {
        var sfu = superfish.util;
        if (sfu) {
            var n = sfu.overlay();
            if (n) {
                n.style.display = 'block';
            }
        }        
    },

    goSend : function(ev, nI, anim) {
        var sfu = superfish.util;
        var sa = this;
        var sp = spsupport.p;
        var img = nI.img;
        if(sfu) {
            if (ev == 1 || ev == 2) {
                if (sfu.currImg != img) {
                    // sfu.lastAIcon.img = img;
                    sfu.currImg = img;
                    sp.imPos = sa.getItemPos(img);
                    if (superfish.b.preSlideUpOn) {
                        // if (superfish.p.onAir == 2) {
                        sfu.closePopup();
                    }
                    sfu.prepareData(sa.getItemJSON(img), 0, 0, 0, 0);
                    nI.sent = 1;
                    clearTimeout(sp.iconTm);
                    clearTimeout(sp.oopsTm);
                    sp.prodPage.e = 1;
                }
            }
            if (ev == 1 || ev == 3) {
                nI.src = spsupport.api.sfIPath(nI.type).r;
                sa.resetPBar(anim, nI);
                this.shOverlay();
                sp.sfIcon.prog.e = 2;
                if (sfu.currImg == img && sp.before == 0) {
                    sfu.updIframeSize(sp.itemsNum, sp.tlsNum, 0);
                    //sp.imPos = sa.getItemPos(img);
                    sfu.openPopup(sp.imPos, sp.appVersion, 0);
                }
            }
        }
        else {
            setTimeout (function(){
                spsupport.api.goSend(ev, nI, anim);
            }, 400);
        }
    },

    resetPBar : function(anim, nI) {
        var pBar = spsupport.p.sfIcon.prog.node;
        if( pBar ){
            anim.stop();
            sufio.style(
                pBar ,{
                    width : "0px",
                    display : "none"
                });
        }
        nI.sent = 0;
    },
    
    addSFIcon: function(parent, iType){        
        var sp = spsupport.p;
        var sfu = superfish.util;
        // var ind = 2*(iType-1);
        // var icPath = spsupport.api.sfIPath(iType);
        var hWidth = parseInt(sp.sfIcon.prog.w[0]/4.2);
        var hWidth2 = parseInt(sp.sfIcon.prog.w[1]/4.2);
        sp.sfIcon.ic = spsupport.api.createImg( sp.imgPath + sp.partner + "si" + 0 + ".png?v=" + sp.appVersion );
        // var nI = sp.sfIcon.icons[ind];
        var nI = sp.sfIcon.ic;
        nI.setAttribute(sp.sfIcon.evl, '-1');
        nI.title = " See Similar ";
        // nI.pW = sp.sfIcon.prog.w[iType - 1];
        //var iProp = ( iType == 2  ?  sp.sfIcon.small  :  sp.sfIcon.big );
        nI.style.position = "absolute";
        nI.style.top = -200 + "px";
        nI.style.left = -200 + "px";
        var zindex = 12005;
        if (+sufio.isIE == 7) {
            zindex = zindex*100;
        }
        nI.style.zIndex = zindex;
        nI.style.cursor = "pointer";
        /* BUG IN IE */
        nI.style.width = "" + sp.sfIcon.big.w + "px";
        nI.style.height = "" + sp.sfIcon.big.h + "px";
        nI.type = 1;
        nI.src = spsupport.api.sfIPath(nI.type).r;
       
        var anim = sufio.animateProperty({
            node: sp.sfIcon.prog.node,
            duration: sp.sfIcon.prog.time,
            properties: {
                width: {
                    start: "0",
                    end:  sp.sfIcon.prog.w[0],
                    unit: "px"
                }
            },
            onEnd : function() {
                spsupport.api.goSend(3, nI, anim);
            }
        });
        
        var anim2 = sufio.animateProperty({
            node: sp.sfIcon.prog.node,
            duration: sp.sfIcon.prog.time,
            properties: {
                width: {
                    start: "0",
                    end:  sp.sfIcon.prog.w[1],
                    unit: "px"
                }
            },
            onEnd : function() {
                spsupport.api.goSend(3, nI, anim2);
            }
        });


        sufio.connect( anim,'onAnimate', function( curveValue ){
            if ( !nI.sent ) {
                if( parseInt(curveValue.width) >= hWidth){
                    spsupport.api.goSend(2, nI, anim);
                }
            }
        });
        
        sufio.connect( anim2,'onAnimate', function( curveValue ){
            if ( !nI.sent ) {
                if( parseInt(curveValue.width) >= hWidth2){
                    spsupport.api.goSend(2, nI, anim2);
                }
            }
        });

        
        nI.onmouseout = function(e){
            if (!e) {
                var e = window.event;
            }
            var relTarget = ( (e.relatedTarget) ? e.relatedTarget : e.toElement );
            if( relTarget != sp.sfIcon.prog.node ){
                this.src = spsupport.api.sfIPath(this.type).r;
                sp.sfIcon.prog.e = (sp.sfIcon.prog.e == 2 ? 2 : 0);
                var anm = (nI.type == 1 ? anim : anim2);
                spsupport.api.resetPBar(anm, this); 
                if (sp.sfIcon.prog.e == 0) {
                    if (sfu) {
                        sfu.hideLaser();
                    }
                    else {
                        if (spsupport.p.sfIcon.an) {
                            spsupport.p.sfIcon.an.style.top = '-2000px';
                            spsupport.p.sfIcon.an.style.left = '-2000px';
                        }
                    }
                }
                if (sp.before == 2) {
                    if (sfu) {
                        sfu.reportClose();
                    }
                }
            }
        };

        nI.onmouseover  = function(e){
            if( !window.superfish || !window.superfish.p || window.superfish.p.onAir != 1 ){
                if (!e) {
                    var e = window.event;
                }
                var relTarget = ( (e.relatedTarget) ? e.relatedTarget : e.fromElement );
                if ( relTarget != sp.sfIcon.prog.node) {
                    // var typ = (this.w > sp.sfIcon.small.w ? 1 : 2);
                    this.src = spsupport.api.sfIPath(this.type).o;
                    sp.sfIcon.prog.e = 1;
                    // sp.overIcon = this;
                    if (sp.sfIcon.prog.node ) {
                        var iProp = ( nI.type == 2  ?  sp.sfIcon.small  :  sp.sfIcon.big );
                        var dif = iProp.h - sp.sfIcon.prog.h;
                        sufio.style(
                            sp.sfIcon.prog.node, {
                                display : "block",
                                top : parseInt( nI.style.top ) + dif - 2 + "px",
                                left : parseInt( nI.style.left ) + 2 + "px"
                            });
                        var ip = spsupport.api.getItemPos(nI.img);
                        var anm = (nI.type == 1 ? anim : anim2);
                        anm.play();    
                        if (superfish.util) {
                            //                            if(top.sf_scan_animation){
                            //                                top.sf_scan_animation.stop();
                            //                            }   
                            superfish.util.hideLaser();
                            superfish.util.showLaser(ip); 
                        }
                    }
                }
            }
        }; 

        sp.sfIcon.prog.node.onmouseout = function(e){
            if (!e) {
                var e = window.event;
            }
            var relTarget = ( e.relatedTarget ? e.relatedTarget : e.toElement );
            if( !relTarget ||  relTarget != sp.sfIcon.ic ){
                //                if( sp.overIcon ){
                sp.sfIcon.ic.onmouseout( e );
            //                }
            }
        };
            
       
        nI.onmousedown = function(e){
            var evt = e || window.event;
            if( evt && evt.button == 2 ) {
                return;
            }
            if (this.img) {
                var anm = (nI.type == 1 ? anim : anim2);
                spsupport.api.goSend(1, this, anm);
            }
        };
        
        sp.sfIcon.prog.node.onmousedown = function(e){
            nI.onmousedown();
        };
        
        parent.appendChild( nI );
    },
    
    addSFDiv: function(pr, img) {
        var bi = 600;
        var sp = spsupport.p;
        // var pd = 8;
        // var spd = spsupport.domHelper;
        var spi = sp.sfIcon;
        var spa = spsupport.api;
            
        var dv = document.createElement("div");
            
        var imgPos = spsupport.api.getImagePosition(img);
        if (img.width > bi || img.height > bi || imgPos.x < 0 || imgPos.y < 10) {
            return;
        }
            
        sufio.style(
            dv ,{
                border: 'none', //"solid 1px",
                // backgroundColor: 'transparent',
                backgroundColor: "#ffffff",
                opacity: 0.01,
                zIndex: "12002",
                //zIndex: "-1",
                position: "absolute",
                width: (img.width) + "px",
                height: (img.height) + "px",
                top: parseInt(imgPos.y) + "px",
                display: "inline-block",
                left: parseInt(imgPos.x) + "px"
            });
                
        dv.onmouseover  = function(e){
            if (!e) {
                e = window.event;
            }
            var relTarget = ( (e.relatedTarget) ? e.relatedTarget : e.fromElement );
            if ( relTarget != spi.ic) { // && relTarget != cv) {
                var nI = spi.ic;
                nI.img = img;
                if (superfish.util) {
                    superfish.util.hideLaser();
                }

                var imgPos = spa.getImagePosition(img);
                var lf = parseInt(this.style.left);
                var tp = parseInt(this.style.top);
                if (Math.abs(imgPos.x - lf) > 100 || Math.abs(imgPos.y - tp) > 100) {
                    spa.startDOMEnumeration();
                }
                // nI.style.top = "" + parseInt( imgPos.y + this.height - spi.big.h - this.height/10 ) + "px";
                //                nI.style.top = "" + parseInt( imgPos.y + img.height - spi.big.h + 3 ) + "px";
                //                nI.style.left = "" + parseInt( imgPos.x + 1 ) + "px";
                //var icPath = spsupport.api.sfIPath(iType);

                if(( img.width <= spi.maxSmImg.w ) || ( img.height <= spi.maxSmImg.h ) ) {
                    sufio.style(
                        nI ,{
                            width : spi.small.w + "px",
                            height : spi.small.h + "px"
                        });
                    nI.src = spsupport.api.sfIPath(2).r;
                    nI.type = 2;
                }
                else {
                    sufio.style(
                        nI ,{
                            width : spi.big.w + "px",
                            height : spi.big.h + "px"
                        });
                    nI.src = spsupport.api.sfIPath(1).r;
                    nI.type = 1;
                }

                var io = (nI.type == 1 ? spi.big : spi.small);
                var t = (img.height > 199 ? (imgPos.y + img.height - io.h + 3) : (imgPos.y + img.height - img.height/6));
                var l = (img.width > spi.big.w*2 ? (imgPos.x + 1) : (imgPos.x - (io.w - img.width)/2));
                nI.style.top = "" + parseInt(t) + "px";
                nI.style.left = "" + parseInt(l) + "px";
            }
                
            sp.sfIcon.nl.style("display","inline-block");
            this.style.display = "none";
        //spi.nl.push(this);
        };
            
        pr.appendChild(dv);
        
    },

    validateSU: function( im, iT ){
        // spsupport.log("validateSU superfish.b.inimgSrp = " + superfish.b.inimgSrp + ";  superfish.sg.sSite = " + superfish.sg.sSite);
        var sp = spsupport.p;
        var cnd = (superfish.b.inimg ? parseInt(iT) > 0 : true);
        var cndM = im.width > sp.prodPage.d && im.height > sp.prodPage.d && parseInt(iT) < sp.prodPage.l;
        //        if (superfish.sg && superfish.sg.sSite) {
        //            cndM = true;
        //        }
        
        //        var pp = false;
        //        if (superfish.b.inimgSrp) {
        //            if (!superfish.sg.sSite) {
        //                if (cndM) {
        //                    superfish.publisher.reqCount = superfish.publisher.limit;
        //                    pp = true;
        //                }
        //                cndM = true;
        //            }
        //        }
        //        else {
        //            pp = true;
        //        }
        cndM = cndM && cnd && sp.prodPage.p != im || spsupport.sites.validProdImg();
        if( spsupport.sites.su() && !sp.prodPage.s &&
            ( spsupport.p.supportedSite || spsupport.whiteStage.st ?
                cndM :
                sp.prodPage.p != im )
            ){
            sp.prodPage.s = 1;
            //            if (pp) {
            sp.prodPage.i ++;
            //            }
            sp.prodPage.p = im;
            sp.SRP.reset();
            setTimeout(function() {
                spsupport.api.puPSearch(1, im);
            }, 30);
            return(1);
        }
        return(0);
    },

    addSFProgressBar: function(iNode){
        var bProp = spsupport.p.sfIcon.prog;
        if( !bProp.node ) {
            bProp.node = sufio.place("<div id='sfIconProgressBar'></div>", iNode, "after" );
            bProp.node.setAttribute('style', '-moz-border-radius : 4px; -webkit-border-radius : 4px; border-radius: 4px;');
            sufio.style( bProp.node ,{
                position : "absolute",
                overflow: "hidden",
                width : "0px",
                height : bProp.h + "px",
                zIndex : "12008",
                cursor : "pointer",
                backgroundColor : bProp.color,
                opacity : bProp.opac
            });
        }
    },
    
    addAn: function(){
        var sp = spsupport.p;
        if( !sp.sfIcon.an ) {            
            sp.sfIcon.an = sufio.place("<div id='sfImgAnalyzer'></div>", sufio.body());
            sufio.style(sp.sfIcon.an ,{
                position: "absolute",
                overflow: "hidden",
                width: "24px",
                height: "100px",
                zIndex: "12000",
                top: "-200px",
                left: "-200px",
                filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=" + spsupport.p.imgPath + spsupport.p.partner + "/scan.png,sizingMethod='image')",
                background: "url(" + sp.imgPath + sp.partner + "scan.png) repeat-y"
                
            });
        }
    },

    sfButtons : function(){
        return document.getElementById("sfButtons");
    },
    getImagePosition : function(img) {
        return( sufio.coords(img, true) );
    },

    getMeta : function(name) {
        var mtc = sufio.query('meta[name = "'+name+'"]');
        if( mtc.length > 0 ){
            return  mtc[ 0 ].content;
        }
        return '';
    },
    
    getLinkNode : function(node, level){
        var lNode = 0;
        if (node) {
            var tn = node;
            for (var i = 0; i < level; i++) {
                if (tn) {
                    if (tn.nodeName.toUpperCase() == "A") {
                        lNode = tn;
                        break;
                    }
                    else {
                        tn = tn.parentNode;
                    }
                }
            }
        }
        return lNode;
    },

    textFromLink : function(lNode, url, sec, all){
        var sfMN = spsupport.p.merchantName.toLowerCase();
        var txt = lNode.getAttribute("title");
        txt = txt ? txt+" " : "";
        if( url.indexOf( "javascript" ) == -1 ){
            url = url.replace(/http:\/\//g, "");
            if( sfMN != "sears" ){
                url = url.replace( document.domain, "");
            }
            var urlLC = url.toLowerCase();
            var _url = ""
            var plus = url.lastIndexOf( "+", url.length - 1 );
            _url = ( plus > -1 ? url.substr( plus + 1, url.length - 1 ) : "" );
            urlLC = ( plus > -1 ? url.substr( plus + 1, url.length - 1 ) : urlLC );
            var q = 'a[href *= "' + (_url != "" ? _url : url ) + '"], a[href *= "' + urlLC  + '"]';
            q = (all && sec ? 'a' : q);
            var nodes = (sec ? sufio.query(q, sec) : sufio.query(q));
            nodes.forEach(
                function( node ) {
                    if( (_url !="" && node.href.toLowerCase().indexOf( url, 0) > -1 ) || _url =="" || all) {
                        txt += ( " " + spsupport.api.getTextOfChildNodes( node ) ) ;
                    }
                });
        }
        return sufio.trim(txt);
    },

    getTextOfChildNodes : function(node){
        var txtNode = "";
        var ind;
        for( ind = 0; ind < node.childNodes.length; ind++ ){
            if( node.childNodes[ ind ].nodeType == 3 ) { // "3" is the type of <textNode> tag
                txtNode = sufio.trim( txtNode + " " + node.childNodes[ ind ].nodeValue );
            }
            if( node.childNodes[ ind ].childNodes.length > 0 ) {
                txtNode = sufio.trim( txtNode +
                    " "  + spsupport.api.getTextOfChildNodes( node.childNodes[ ind ] ) );
            }
        }
        return txtNode;
    },

    vTextLength : function( t ) {
        if( t.length > 1000 ){
            return "";
        }else if( t.length < 320 ){
            return t;
        }else{
            if( spsupport.br.isIE7 ){
                return t.substr(0, 320);
            }
            return t;
        }
    },

    getItemJSON : function( img ) {
        var spa = spsupport.api;
        var sp = spsupport.p;
        var iURL = "";
        try{
            iURL = decodeURIComponent( img.src );
        }catch(e){
            iURL = img.src;
        }
        
        var relData = spsupport.sites.getRelText( img.parentNode, spa.getLinkNode, spa.textFromLink );
        var pt = ( sp.prodPage.i > 0 ? "PP" : "SRP" );
        
        // var pTxt = '';
        var dt = (pt == 'PP' && img != sp.prodPage.p ? '' : encodeURIComponent( document.title + spsupport.api.getMK( img ) ));
        var irt = ( relData ? encodeURIComponent( spa.vTextLength(  relData.iText  ) ) : '' );
        var it = encodeURIComponent( sufio.trim( img.title + " " + img.alt ) );
        var pu = ( relData ? relData.prodUrl : "" );
        if (spsupport.whiteStage.rv) {            
//            var del = '@@';
//            pTxt = del + this.getMeta('keywords') + del + superfish.publisher.extractTxt(img) + del + (spsupport.br.isIE7 ? "" : window.location.href);
            dt = dt + ' ' + irt + ' ' + it;
            irt = '';
            it = '';
            }
        
        
        //var pt = ( sp.SRP.i > 0 ? "SRP" : ( sp.prodPage.i > 0 ? "PP" : "SRP" ) );
        var jsonObj = {
            userid: encodeURIComponent( sp.userid ),
            merchantName: encodeURIComponent( spa.merchantName() ),
            dlsource: sp.dlsource ,
            appVersion: sp.appVersion,
            documentTitle: dt,
            imageURL: encodeURIComponent( spsupport.sites.vImgURL( iURL ) ),
            //+ "?" + new Date().getTime() ),        // !!! SERVER CAHCE FREE
            imageTitle: it,
            imageRelatedText: irt,
            // productUrl: encodeURIComponent(( relData ? relData.prodUrl : "" ) + pTxt)
            productUrl: encodeURIComponent(pu)
        };
        return jsonObj;
    },

    getItemPos : function( img ) {
        var iURL = "";
        try{
            iURL = decodeURIComponent( img.src );
        }catch(e){
            iURL = img.src;
        }
        
        var imgPos = spsupport.api.getImagePosition( img );
        var jsonObj = {
            imageURL: encodeURIComponent( spsupport.sites.vImgURL( iURL ) ),
            x: imgPos.x,
            y: imgPos.y,
            w: img.width,
            h: img.height
        };
        return jsonObj;
    },

    // Get Meta Keywords
    getMK: function( i ){
        var dd = document.domain.toLowerCase();
        if( ( dd.indexOf("zappos.com") > -1 || dd.indexOf("6pm.com") > -1 ) &&
            ( spsupport.p.prodPage.i > 0 && spsupport.p.prodPage.p  == i ) ){
            var kw = sufio.query('meta[name = "keywords"]');
            if( kw.length > 0 ){
                kw = kw[ 0 ].content.split(",");
                var lim = kw.length > 2 ? kw.length - 3 : kw.length - 1;
                var kwc = "";
                for( var j = 0; j <= lim; j++ ){
                    kwc = kw[ j ] + ( j < lim ? "," : ""  )
                }
                return " [] " + kwc;
            }
        }
        return "";
    },

    merchantName: function()  {
        return  spsupport.p.merchantName;
    },
    superfish: function(){
        return window.top.superfish;
    },

    s2hash: function( str ){
        var res = "";
        var l = str.length;
        for ( var i = 0; i < l; i++){
            res += "" + str.charCodeAt(i);
        }
        return res;
    },

    sendMessageToExtenstion: function( msgName, data ){
        var d = document;
        if(sufio){
            var jsData = sufio.toJson(data);
            if (sufio.isIE) {
                try {
                    // The bho get the parameters in a reverse order
                    window.sendMessageToBHO(jsData, msgName);
                } catch(e) {}
            } else {
                var el = d.getElementById("sfMsgId");
                if (!el){
                    el = d.createElement("sfMsg");
                    el.setAttribute("id", "sfMsgId");
                    d.body.appendChild(el);
                }
                el.setAttribute("data", jsData );
                var evt = d.createEvent("Events");
                evt.initEvent(msgName, true, false);
                el.dispatchEvent(evt);
            }
        }
    },
    saveStatistics: function() {
        var sp = spsupport.p;
        if( document.domain.indexOf("superfish.com") > -1 ||
            sp.dlsource == "conduit" ||
            sp.dlsource == "pagetweak" ||
            sp.dlsource == "similarweb"){
            return;
        }

        var imageCount = 0;
        var sfButtons = spsupport.api.sfButtons();
        if( sfButtons != null ){
            imageCount = sfButtons.children.length;
        }


        var data = {
            "imageCount" : imageCount,
            "ip": superfish.b.ip
        }

        if( spsupport.api.isOlderVersion( '1.2.0.0', sp.clientVersion ) ){
            data.Url = document.location;
            data.userid = sp.userid;
            data.versionId = sp.clientVersion;
            data.dlsource = sp.dlsource;

            if( sp.CD_CTID != "" ) {
                data.CD_CTID = sp.CD_CTID;
            }
            spsupport.api.jsonpRequest( sp.sfDomain_ + "saveStatistics.action", data );
        } else  {
            spsupport.api.sendMessageToExtenstion("SuperFishSaveStatisticsMessage", data);
        }
    },

    isOlderVersion: function(bVer, compVer) {
        var res = 0;
        var bTokens = bVer.split(".");
        var compTokens = compVer.split(".");

        if (bTokens.length == 4 && compTokens.length == 4){
            var isEqual = 0;
            for (var z = 0; z <= 3 && !isEqual && !res ; z++){
                if (+(bTokens[z]) > +(compTokens[z])) {
                    res = 1;
                    isEqual = 1;
                } else if (+(bTokens[z]) < +(compTokens[z])) {
                    isEqual = 1;
                }
            }
        }
        return res;
    },

    leftPad: function( val, padString, length) {
        var str = val + "";
        while (str.length < length){
            str = padString + str;
        }
        return str;
    },

    getDateFormated: function(){
        var dt = new Date();
        return dt.getFullYear() + spsupport.api.leftPad( dt.getMonth() + 1,"0", 2 ) + spsupport.api.leftPad( dt.getDate(),"0", 2 ) + "";
    },
    
    dtBr: function() {
        var ua = navigator.userAgent;
        var br = "unknown";
        if (ua) {
            ua = ua.toLowerCase();
            if (ua.indexOf("msie 7") > -1){
                br = "ie7";
            }
            else if (ua.indexOf("msie 8") > -1) {
                br = "ie8";
            }
            else if (ua.indexOf("msie 9") > -1) {
                br = "ie9";
            }
            else if (ua.indexOf("firefox/5") > -1) {
                br = "ff5";
            }
            else if (ua.indexOf("firefox/6") > -1) {
                br = "ff6";
            }
            else if (ua.indexOf("firefox/7") > -1) {
                br = "ff7";
            }
            else if (ua.indexOf("firefox/8") > -1) {
                br = "ff8";
            }
            else if (ua.indexOf("firefox/9") > -1) {
                br = "ff9";
            }
            else if (ua.indexOf("firefox") > -1) {
                br = "ff";
            }
            else if (ua.indexOf("chrome") > -1) {
                br = "ch";
            }
            else if (ua.indexOf("apple") > -1) {
                br = "sa";
            }
        }
        return br;
    },

    nofityStatisticsAction :function(action) {
        var sp = spsupport.p;
        if(sp.w3iAFS != ""){
            data.w3iAFS = sp.w3iAFS;
        }
        if(sp.CD_CTID != ""){
            data.CD_CTID = sp.CD_CTID;
        }

        spsupport.api.jsonpRequest( sp.sfDomain_ + "notifyStats.action", {
            "action" : action,
            "userid" : sp.userid,
            "versionId" : sp.clientVersion,
            "dlsource" : sp.dlsource,
            "browser": navigator.userAgent
        });
    },
    unloadEvent : function(){
    }
};

spsupport.domHelper = {
    oldOnMouseMove : 0,

    addMouseMoveEvent : function(func){
        if (typeof window.onmousemove != 'function'){
            window.onmousemove = func;
        }
        else {
            this.oldOnMouseMove = window.onmousemove;
            window.onmousemove = function(e) {
                spsupport.domHelper.oldOnMouseMove(e);
                func(e);
            }
        }
    },

    addOnresizeEvent : function(func){
        if (typeof window.onresize != 'function'){
            window.onresize = func;
        } else {
            var oldonresize = window.onresize;
            window.onresize = function() {
                if( oldonresize ){
                    if ( sufio.isIE ) {
                        oldonresize();
                    }
                    else {
                        setTimeout( oldonresize,350 );
                    }
                }
                if( sufio.isIE ) {
                    func();
                }
                else {
                    setTimeout(func, 200);
                }
            }
        }
    },
    addFocusEvent : function(func){
        var oldonfocus = window.onfocus;
        if (typeof window.onfocus != 'function') {
            window.onfocus = func;
        }else{
            window.onfocus = function()  {
                if (oldonfocus) {
                    oldonfocus();
                }
                func();
            }
        }
    },

    addBlurEvent : function(func){
        var oldonblur = window.onblur;
        if (typeof window.onblur != 'function') {
            window.onblur = func;
        }else{
            window.onblur = function()  {
                if (oldonblur) {
                    oldonblur();
                }
                func();
            }
        }
    },

    addScrollEvent : function( func ){
        var oldonscroll = window.onscroll;
        if (typeof (window.onscroll) != 'function') {
            window.onscroll = func;
        }else{
            window.onscroll = function()  {
                if (oldonscroll) {
                    oldonscroll();
                }
                func();
            }
        }
    },
    
    addUnloadEvent : function(func){
        var oldonunload = window.onunload;
        if (typeof window.onunload != 'function'){
            window.onunload = func;
        } else {
            window.onunload = function() {
                if (oldonunload) {
                    oldonunload();
                }
                func();
            }
        }
    },
    
    addMouseoverEvent: function(node, func) {
        var oldevt = node.onmouseover;
        if (typeof (node.onmouseover) != 'function') {
            node.onmouseover = function(e) {
                func(e);
            };
        }else{
            node.onmouseover = function(e)  {
                if (oldevt) {
                    oldevt();
                }
                func(e);
            }
        }
    },
    
    addMouseoutEvent: function(node, func) {
        var oldevt = node.onmouseout;
        if (typeof (node.onmouseout) != 'function') {
            node.onmouseout = function(e) {
                func(e);
            };
        }else{
            node.onmouseout = function(e)  {
                if (oldevt) {
                    oldevt();
                }
                func(e);
            }
        }
    },

    addEListener : function(node, func, evt ){
        if( window.addEventListener ){
            node.addEventListener(evt,func,false);
        }else{
            node.attachEvent(evt,func,false);
        }
    }
};

spsupport.api.init();
