function darkmode(doDark) {
	if (doDark) {
		$("body").addClass("darkmode");
		$("#callDark").hide();
		$("#callLight").show();
		var date = new Date();
		date.setTime(date.getTime()+(365*24*60*60*1000));
		document.cookie = "darkmode=true;expires=" + date.toGMTString() + ";path=/";
	} else {
		$("body").removeClass("darkmode");
		$("#callDark").show();
		$("#callLight").hide();
		var date = new Date();
		document.cookie = "darkmode=false;expires=" + date.toGMTString() + ";path=/";
	}
}