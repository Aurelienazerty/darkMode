function darkmode(doDark) {
	if (doDark) {
		$("html").addClass("darkmode");
		$("html").removeClass("lightmode");
		$("#callDark").hide();
		$("#callLight").show();
		var date = new Date();
		date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
		document.cookie = cookie_darkmode_name + "=true;expires=" + date.toGMTString() + ";path=/";
	} else {
		$("html").addClass("lightmode");
		$("html").removeClass("darkmode");
		$("#callDark").show();
		$("#callLight").hide();
		var date = new Date();
		document.cookie = cookie_darkmode_name + "=false;expires=" + date.toGMTString() + ";path=/";
	}
}
