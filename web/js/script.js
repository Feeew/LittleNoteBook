function confirmDelete(text){
	return confirm(text)
};

function confirmDelete_alert(text){
	return confirm(text)
};

function displayUserList(e, url){
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
	  if (this.readyState == 4 && this.status == 200) {
		  var madiv = document.getElementById("userList");
		  madiv.innerHTML = this.responseText;
		  madiv.style.display = 'block';

		  madiv.style.left = e.clientX  + "px";
		  madiv.style.top = e.clientY  + "px";
	  }
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}

$.urlParam = function(name){
	var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
	return results[1] || 0;
}

function displayNotifications(){
	if($('#notif_image').length)
		$('#notifications').css({top:$('#header').outerHeight()+37, left:$('#notif_image').position().left});
	$("#notifications").toggle();
}

function closeUserList(){
	$("#userList").toggle();
}