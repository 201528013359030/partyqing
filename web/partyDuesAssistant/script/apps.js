var noweb = {};
noweb.partial = "../html/temp/noweb.html";
noweb.init = function(){
    console.log('网址不存在');
}

var notfound = {};
notfound.partial = "../html/temp/404.html";
notfound.init = function(){
    console.log('网址不存在');
}

var partyDuesAssistant = {};
partyDuesAssistant.partial = "../html/temp/partyDuesAssistant.html";
partyDuesAssistant.init = function(){
	
//	alert(NATIVE_UID);
    miniSPA.render("partyDuesAssistant");
    
    var uid = NATIVE_UID;
   		auth_token=NATIVE_AUTH_TOKEN;
    
    setPartyDuesIteam(uid,auth_token);

}

var partyDuesHistory = {};
partyDuesHistory.partial = "../html/temp/partyDuesHistory.html";
partyDuesHistory.init = function(){
    miniSPA.render("partyDuesHistory");
    
    var uid = NATIVE_UID;
		auth_token=NATIVE_AUTH_TOKEN;
		var page = 0;
    getPartyDuesHistory(uid,auth_token,page);
    commonFunction.load_page("#page_innerContent-h-listGroup");
    
	
    if($("#page_innerContent-h-listGroup")[0]) {

        var flag_home = true; //是否继续加载

        $("#tab1").pullToRefresh().on("pull-to-refresh", function() {
            var self = this;
            setTimeout(function() {
                window.location.reload();
                $(self).pullToRefreshDone(); // 重置下拉刷新
            }, 2000);   //模拟延迟
        });

        $("#tab1").infinite().on("infinite", function() {

            console.log("infiniteScroll.html");

            
            if(flag_home){
				var self = this;			    
			    if(self.loading) return;
			    self.loading = true;
			    setTimeout(function() {
			    	getPartyDuesHistory(uid,auth_token,page_home);
			        self.loading = false;
			    }, 2000);   //模拟延迟
			}
//            if(flag_home){
//                var self = this;
//                if(self.loading) return;
//                self.loading = true;
//                setTimeout(function() {
//                    $("#J_pullContent").append("<p>在此例子中，每一个tab都包含个字的代码块，在修改时，要对应修改例如#tab1, #tab2, #tab3等相关类，切记</p>")
//                    self.loading = false;
//                }, 2000);   //模拟延迟
//            }


        });

}
}

var partyDuesCount = {};
partyDuesCount.partial = "../html/temp/partyDuesCount.html";
partyDuesCount.init = function(){
    miniSPA.render("partyDuesCount");
    
    
    var tY = 0;
    var iMY = 0;
    $('.typelabel').click(function(){
    	var t = $(this).index('.typelabel');
    	$('.type-content').css('display','none');
    	$('.type-content').eq(t).css('display','block');
    	tY = t;
    	if(tY>1){
    		$('.incomestylee-choose').hide();
    		$('.income-box').hide();
    		$('.income-pay-calculate').hide();
    		}
    	else{
    		$('.incomestylee-choose').show();
    		$('.income-box').eq(0).show();
    		$('.income-pay-calculate').show();
    		}
    	});
    $('.incomelabel').click(function(){
    	iMY = $(this).index('.incomelabel');
    	if(iMY==1){
    		$('.choose-MY').css('display','block');
    		}
    	else{
    		$('.choose-MY').css('display','none');
    		}
    	});
    // $('#income').focus(function(){
//     	$(this).val(null);
//     	window.scrollTo(0,100)
//     	})
    $('#income').focus(function(){
    	$(this).val(null);
    	document.getElementById('pay').value = 0.0;
    	});

    	//手机端弹出数字键之后，调整焦点输入框到屏幕最上方
    var clientHeight = document.body.clientHeight;
        var _focusElem = null; //输入框焦点
        //利用捕获事件监听输入框等focus动作
        document.body.addEventListener("focus", function(e) {
            _focusElem = e.target || e.srcElement;
        }, true);
        //因为存在软键盘显示而屏幕大小还没被改变，所以以窗体（屏幕显示）大小改变为准
        window.addEventListener("resize", function() {
            if (_focusElem && document.body.clientHeight < clientHeight) {
                //焦点元素滚动到可视范围的底部(false为底部)
                _focusElem.scrollIntoView(true);
            }
        });


    $('.income').keyup(function(){
    	$('.income-pay-calculate').css('color','white').css('background','#ce2123')
    	});
    $('.income-pay-calculate').click(function(){
    	$('.pay-box').css('display','block');
    	var i = document.getElementById('income').value;
    	var p =0;
    	if(tY==0){
    		if(i<3001){
    			p = i*0.005;
    			}
    		else if(i>3000 & i<5001 ){
    			p = i*0.01;
    			}
    		else if(i>5000 & i<10001){
    			p = i*0.015;
    			}
    		else if(i>10000){
    			p = i*0.02;
    			}
    		}
    	else if(tY==1){
    		if(i<5001){
    			p = 0.005*i;
    			}
    		else{
    			p = 0.01*i;
    			}
    		}
//     	document.getElementById('pay').value = p.toFixed(1);
    	p=Math.ceil(p*10);//向上取整
    	p=p*1.0/10;
    	document.getElementById('pay').value = p;
    	});
}	





