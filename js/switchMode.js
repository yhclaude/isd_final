	function switchMode(){
		console.log("WTF, SWITCH");
		var logged = location.href;
        var len = logged.length;
        var start = logged.indexOf("=");
        logged = logged.substring(start+1, len);
        if(logged == "1"){
			window.location.href = "http://localhost/isd_final/index.html" + "?logged=1";
		}
		else{
			window.location.href = "http://localhost/isd_final/index.html"
		}
	}
