jQuery(document).ready(function(){
	jQuery(".subscribe_button").click(function() {
		var regexp = /^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i;
		var form_email = document.getElementById("form_email").value;
		if (regexp.test(form_email) == false) {
			document.getElementById("form_email").style.borderStyle = "solid";
			document.getElementById("form_email").style.borderColor = "red";
			return false;
		} else {
			return true;
		}
	});
});