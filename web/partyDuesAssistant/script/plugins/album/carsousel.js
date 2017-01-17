;(function(){

var USERAGENT ='pc';
if( /(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent) ){
	USERAGENT = "ios";
};
if( /(Android)/i.test(navigator.userAgent) ){
	USERAGENT = "android";
};

var	currpage = 1,
	win_w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
    win_h =  document.documentElement.clientHeight || document.body.clientHeight || window.innerHeight,
    win_scroll_top = document.documentElement.scrollTop || document.body.scrollTop,
    ua_android = navigator.userAgent.match(/Android ([3-9][._][0-9])/),
    us_os = navigator.userAgent.match(/OS ([5-9])_\d[_\d]*/),
    myscroll,
    myscroll_pic,
    maxnum,
	flag = true;

var Carsousel = function(poster){
	
	this.poster = poster;
	
	//alert($(this.poster).attr("data-path"));
	this.path = $(this.poster).attr("data-path");
	this.num = $(this.poster).attr("data-num");
	
	this.setSettingValue();
	
	
};
Carsousel.prototype = {
	
	setSettingValue : function(){
		
		for(var i=0; i<this.num; i++){
			this.oliClick(this.path,this.num);
		}
		
	},
	//九宫格处理加载图片
	loadImg : function( src,oli,maxh ){
		
		var img = new Image();
			img.src = src;
	
			img.onload = function(){
				
				var wh = 1; //oli.clientWidth / oli.clientHeight;
			    var imgWh = img.width / img.height;
				
			    if(wh > imgWh){
			    	//console.log(maxh+"+"+oli.getAttribute('imgSrc') + "竖图");//竖图			        
			        img.style['max-width'] = maxh + 'px';
			        img.style['max-height'] = 'none';
			    }else{
			    	//console.log(oli.getAttribute('imgSrc') + "横图");//横图
			    	img.style['max-width'] = 'none';
			        img.style['max-height'] = maxh + 'px';
			    }
			    		
			    oli.appendChild(img);
			    //处理左右的值
			    var left = Math.ceil( (oli.clientWidth - oli.firstChild.offsetWidth)/2 );
			    var top = Math.ceil( (oli.clientHeight - oli.firstChild.offsetHeight)/2 );
			    
			    if(wh > imgWh){
			        img.style['-webkit-transform'] = 'translateY('+top+'px)';		        
			    }else{
			    	img.style['-webkit-transform'] = 'translateX('+left+'px)';	
			    }  
			    
	    	}				
	    	//如果图片不存在则显示默认图片
			img.onerror = function(){
				this.src = '../images/templogo.jpg';
			}
	},
	
	oliClick : function( path,num ){
		var picslider = this.picslider;
		var posterImgNum = num;
		/*
		 * 名称：oliClick( iteam,oli )
		 * 作用：处理li点击图片放大使用  picslider 获取当前是哪个
		 */
		this.poster.onclick = function(){
			
			$('#wrap').css("display","none");
			setTimeout(function(){
			//picslider( iteam, oli.index,posterImgNum );
			picslider( path, 0,posterImgNum );
			},800);		
		}
	},
	picslider : function( elem,id,maxnum ){
		/*
		 * 名称：picslider( iteam, oli.index );
		 * 作用：点击放大函数，包含左右滑动等相关内容
		 */
		//id为当前li的索引 elem 为li的集合
		currpage = id+1;   //当前点击是第几个图片
		//currpage =1;
		var b = document.body,
			el = '',
			imglist = [],     //所有图片的数组
			//currpage = id+1,
			showPage= !0,
			showCtrlBtn= !0,
			_html = '',
			_img = '';
		
		var win_w = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
	        win_h =  document.documentElement.clientHeight || document.body.clientHeight || window.innerHeight;
	        
			
		//取出li里面的img内容 组成一个 imglist 数组
		
		for( var i=1; i<=maxnum; i++ ){		
			var index = i;//i<10?"0"+i:i
			//_img = elem[i].getAttribute('imgsrcBig');
			_img = elem+"index-"+index+".png";
			//取出所有src
			imglist.push(_img);	
			
		}
		
		//创建一个弹出jslider弹出框 并加载所有img
		
		el = document.createElement('div');
		el.className = 'jslider';
		
		el.id = 'J-slider';
		
		b.appendChild(el);
		_html += '<div id="J-slider-cont" class="">';
		
//		for( var i=1; i<=maxnum; i++ ){
//			_html += '<div id="J-wrapper' + i + '" class="jwrap" style="-webkit-transform-origin: 0px 0px 0px; -webkit-transform:translate3d(0,0,0) scale(.25); width:' + win_w*4 + 'px;height:' + win_h*4 + 'px; "><div id="J-scroller' + i + '" class="scroller" style=" transform-origin: 0px 0px 0px;-webkit-transform-origin: 0px 0px 0px;-webkit-transition: -webkit-transform .5s;"></div></div>';
//		};
		
		for( var i=1; i<=maxnum; i++ ){
			_html += '<div id="J-wrapper' + i + '" class="jwrap" style="-webkit-transform-origin: 0px 0px 0px; -webkit-transform:translate3d(0,0,0); width:' + win_w + 'px;height:' + win_h + 'px; "><div id="J-scroller' + i + '" class="scroller" style=" transform-origin: 0px 0px 0px;-webkit-transform-origin: 0px 0px 0px;-webkit-transition: -webkit-transform .5s;"><div id="J-scrollerInner' + i + '" style="-webkit-transform-origin: 0px 0px 0px; -webkit-transform:translate3d(0,0,0) scale(.25); width:' + win_w*4 + 'px;height:' + win_h*4 + 'px;"></div></div></div>';
		};
		
		if (_html += "</div>", showCtrlBtn) {
			var j = i || h && navigator.userAgent.indexOf("UCBrowser") > 0 ? "fixed" : "absolute";
			_html += '<div class="ctrlBar" style="position:' + j + '"><a class="jclose" id="J-close" href="javascript:void(0);"></a>', showPage && imglist.length > 1 && (_html += '<span id="J-curPage" class="curPage">' + currpage + '</span><span id="J-pageCount" class="pageCount">/' + maxnum + "</span>"), _html += "</div>"
		}
		_html +='<div class="controlBar"><a href="javascript:void(0);"  id="goPrev"></a><a href="javascript:void(0);"  id="goNext"></a></div>';
		el.innerHTML = _html;
		
		//el.style.cssText = "margin:auto;overflow:hidden;width:" + win_w*4 + "px;";
		el.style.cssText = "margin:auto;overflow:hidden;width:" + win_w + "px;";
		
		//给整体外框赋值，宽度 maxnum * win_w
		var cont = $('#J-slider-cont');
		//cont.style.cssText = "position:relative;top:0px;left:0px;width:" + maxnum * win_w*4 + "px;height:" + win_h + "px";
		//cont.style.cssText = "position:relative;top:0px;left:0px;width:" + maxnum * win_w + "px;height:" + win_h + "px";
		cont.attr("style","position:relative;top:0px;left:0px;width:" + maxnum * win_w + "px;height:" + win_h + "px");
		
		//加载大图
		var loadImg = function( id ){
			//id 为索引，
			var id_num = id+1;
			var ele = document.getElementById('J-scroller'+id_num);//$('#J-scroller'+id_num)
			var eleInner = document.getElementById("J-scrollerInner"+id_num);//$("#J-scrollerInner"+id_num)
			
			var b;
			
			if(ele){
				ele.parentNode.className += ' loading ';
			}
			
			var imgbig = new Image();
			imgbig.onload = function(){
				
				var wh = 1; //oli.clientWidth / oli.clientHeight;
			    var imgWh = imgbig.width / imgbig.height;
								
				ele.parentNode.className = ele.parentNode.className.replace(/\s*loading\s*/,'');
				
				ele.style['line-height'] = win_h +'px';
				//imgbig.style['-webkit-transform']="scale(.5)";
				imgbig.style.opacity = '1';
			}
			
			imgbig.src = imglist[ id ];
			//ele.appendChild( imgbig );
			eleInner.appendChild( imgbig );
			document.addEventListener('DOMContentLoaded', scroller_pic('J-wrapper'+id_num), false);
		}
		
		
		for( var i=0;i<maxnum; i++ ){
			loadImg( i );    // 0 1 2 3 4
		}
		
		//点击后，移动到当前位置
		//cont.style.webkitTransform = "translate(-" + id * win_w + "px,0px) translateZ(0)";
		
		
		document.addEventListener('DOMContentLoaded', scroller('J-slider'), false);
		
		//点击关闭按钮 去掉 jslider
//		g('#J-close').onclick = function(){
//			//alert("close");
//			b.removeChild(el);
//			el = null;
//			g('#wrap').style.display = 'block';
//		};
		
		

		var method = USERAGENT=="pc"?"click":"touchstart";
		$("#J-close").on(method,function(){
			b.removeChild(el);
			el = null;
			$('#wrap').css("display","block");
		});
				
	}
	
};
Carsousel.init = function(posters){
	//初始化所有图片组合
	var _this = this;
	for( var i=0; i<posters.length; i++ ){
		
		new _this( posters[i] );
		
	}
	
}


function scroller(ele){
	
	var ini_x = -(currpage-1) * win_w;  //设置初始值
	//alert(ini_x);
	setTimeout(function(){
	
		myscroll =new IScroll("#"+ele,{	
			x : ini_x,
			y : 0,
			scrollX:true,
			snap:true,
            momentum:false,
			scrollbars:false		
		});
//		myscroll.on('beforeScrollStart', function(e){
//			
//		});
		
		myscroll.on('scrollEnd', function(){
			
			setTimeout(function () {
		        myscroll.refresh();
		    }, 0);
			
			//alert(2);
			if($("#J-curPage")){
				$("#J-curPage").innerHTML=this.currentPage.pageX+1;
			}
		});
		
	
	},100 );
	var method = USERAGENT=="pc"?"click":"touchstart";
	$("#goNext").on(method,function(){
		myscroll.next();
	});
	$("#goPrev").on(method,function(){
		myscroll.prev();
	});
	     
}

function scroller_pic(ele){
	
	setTimeout(function(){
		//alert("scrollpic");
		myscroll_pic =new IScroll("#"+ele,{
			zoom: true,
			scrollX: true,
			scrollY: true,
			momentum:false,
			mouseWheel: true,
			wheelAction: 'zoom'
		});
				
		myscroll_pic.on('zoomEnd', function(){
			setTimeout(function () {
		        myscroll_pic.refresh();
		    }, 0);
			//alert("zoomEnd");
			if(this.scale>1){
				//myscroll.stop();
				myscroll.enabled = false;
			}else{
				myscroll.enabled = true;
			}
			//console.log( this.scale );
		});
	
	 },200 );
	              
}

window["Carsousel"] = Carsousel;

})();
