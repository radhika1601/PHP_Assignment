var username = document.getElementById('username');

var u;

username.addEventListener("keypress", function(e) {
	if (username.value.length!=0) {
		var httpRequest1 = new XMLHttpRequest();

		httpRequest1.open('POST', 'username.php');
		httpRequest1.setRequestHeader("Content-Type", "application/json");
		var usrname = JSON.stringify({"username": username.value});
		httpRequest1.send(usrname);

		httpRequest1.onreadystatechange = function() {
			if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
				if (this.responseText == "Username Available") {
					u = 0;
					unamediv.style.borderColor = "Green";
					unamediv.style.borderStyle = "Solid";
				} else if(this.responseText == "Username not Available") {
					u=1;
					unamediv.style.borderStyle = "Red";
					unamediv.style.borderStyle = "Solid";
				}
			}
		};
	}
});