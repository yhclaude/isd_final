$(function(){
	var windowWid=$(window).width();
	var windowHeight=$(window).height();
	var contentTop;
	var flag=true;//页面滑动中判断
	function bgInitial(){	
		windowWid=$(window).width();
		//console.log(windowHeight);
		windowHeight=$(window).height();
		var index=$('#cirPanel').find('.active').index();
		
		$('#content').stop(true);//如果在
		$('#content').css({"top":-index*windowHeight});
		//console.log(index);
		$('#content>div').css({
			"width":windowWid,
			"height":windowHeight
		}).each(function(i){
			$(this).css('top',i*windowHeight);
		})
	}
	function changeCircle(a){
		flag=false;
		$('#cirPanel li').eq(a).addClass('active').siblings().removeClass('active');
		$('#cirPanel li').eq(a).find('.round').css('backgroundColor','#00d0ff');
		$('#cirPanel li').eq(a).siblings().find('.round').css('backgroundColor','rgb(208,208,208)');
		$('#content').stop(true);
		$('#content').animate({top:-a*windowHeight},{
			duration:1000,
			complete:function(){
				flag=true;
				if(a==1){
					$('#header').css('backgroundColor','rgba(52, 139, 184, 0.8)');
				}
				else{
					$('#header').css('backgroundColor','rgba(52, 139, 184, 0.2)');
				}
			}
		});
		$('.word').stop(true);
		$('.word').each(function(i,e){
			if(i==a){
				$(this).fadeIn(1500);
			}
			else{
				$(this).fadeOut(800);
			}
		})
	}
	function scrollUp(){
		if(contentTop<0&&contentTop>=-windowHeight){
			changeCircle(0);
		}
		else if(contentTop<-windowHeight&&contentTop>=-2*windowHeight){
			changeCircle(1);
		}
		else if(contentTop<-2*windowHeight&&contentTop>=-3*windowHeight){
			changeCircle(2);
		}
	}
	function scrollDown(){
		if(contentTop<=0&&contentTop>-windowHeight){
	   		changeCircle(1);
		}
		else if(contentTop<=-windowHeight&&contentTop>-2*windowHeight){
			changeCircle(2);
		}
		else if(contentTop<=-2*windowHeight&&contentTop>-3*windowHeight){
			changeCircle(3);
		}
	}
	function scrollChange(e) {  
		e = e || window.event;  
		contentTop=parseInt($('#content').css('top'))
		if(flag){
			if (e.wheelDelta) {  //判断浏览器IE，谷歌滑轮事件               
				if (e.wheelDelta > 0) { //当滑轮向上滚动时  
					scrollUp();
				}  
				else if (e.wheelDelta < 0) { //当滑轮向下滚动时  
					scrollDown();
				}  
			} 
			else if (e.detail) {  //Firefox滑轮事件  
				if (e.detail<0) { //当滑轮向上滚动时  
						scrollUp();
				}  
				else if (e.detail>0) { //当滑轮向下滚动时  
						scrollDown();
				}  
			}  
		}
		
	}//鼠标滚动时
	if (document.addEventListener) {//firefox  
		document.addEventListener('DOMMouseScroll', scrollChange, false);  
	}  
	window.onmousewheel = scrollChange;//鼠标滚动时
	$(window).resize(bgInitial);//窗口大小改变时
	bgInitial();//初始化
	
	//右边的点点
	$('#cirPanel li').each(function(i){
		$(this).click(function(){
			if(flag){
				$(this).addClass('active').siblings().removeClass('active');
				$(this).find('.round').css('backgroundColor','#00d0ff');
				$(this).siblings().find('.round').css('backgroundColor','rgb(208,208,208)');
				$('#content').stop(true);
				$('#content').animate({top:-i*windowHeight},{
					duration:1000,
					complete:function(){
						if(i==1){
							$('#header').css('backgroundColor','rgba(52, 139, 184, 0.8)');
						}
						else{
							$('#header').css('backgroundColor','rgba(52, 139, 184, 0.2)');
						}
					}
				});
				$('.word').stop(true);
				$('.word').each(function(index,e){
					if(index==i){
						$(this).fadeIn(1500);
					}
					else{
						$(this).fadeOut(800);
					}
				})
			}
			
		})
	})
	//判断冒泡事件 控制导航条
	
})
	