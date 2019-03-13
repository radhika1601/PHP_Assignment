var msg = document.getElementById('msg');
var send = document.getElementById('send');
console.log(msg.value);

send.addEventListener("click", function(e) {
	if (msg.value.length!=0) {
		var httpRequest1 = new XMLHttpRequest();
		console.log(msg.value);
		console.log(send.name);

		httpRequest1.open('POST', 'sendmsg.php');
		httpRequest1.setRequestHeader("Content-Type", "application/json");
		var data = JSON.stringify({"msg":msg.value ,"usr2": send.name});
		httpRequest1.send(data);
	}
});