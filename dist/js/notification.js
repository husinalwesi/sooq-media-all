/*
function callAjaxNotificationsListCreate()
{
	$.ajax({
				type: "POST",
				url: "index.php?type=ajax",
				data: "action=fetchNotificationsList",//change action called fetchNotifications
				dataType: 'json',
				success: function(data){
					if(data.status = 200){
						var json_data = data.dataObject;
//							console.log(json_data);
							$.each( json_data, function( key, value ) {
								var fullText = value.full_name+' : '+value.msg ;
								$("#notificationsMenu").append("<li><a href='index.php?type=notifications&action=view'><i class='fa fa-users text-theme'></i> "+fullText+" </a></li>");
							});
					}
		},
				error: function(){
		}
	});
		return false;
}

callAjaxNotificationsListCreate();


function callAjaxNotifications()
{
	$.ajax({
				type: "POST",
				url: "index.php?type=ajax",
				data: "action=fetchNotifications",//change action called fetchNotifications
				dataType: 'json',
				success: function(data){
					if(data.status = 200){

						var json_data = data.dataObject;

							console.log(json_data);
							$.each( json_data, function( key, value ) {
								var options = {
									body: value.full_name+' : \n'+value.msg,
									icon: value.profile_pic,
									dir : "ltr"
								};
								var notification = new Notification('Notification System',options);

								notification.onclick = function () {
									window.open("index.php?type=notifications&action=view");
								};

								var fullText = value.full_name+' : '+value.msg ;
								$("#notificationsMenu").append("<li><a href='index.php?type=notifications&action=view'><i class='fa fa-users text-theme'></i> "+fullText+" </a></li>");


							});

					}


		},
				error: function(){
		}
	});
		return false;
}

function notifyMe() {
	if (!("Notification" in window)) {
		alert("This browser does not support desktop notification");
	}
	else if (Notification.permission === "granted") {
		callAjaxNotifications();
	}
	else if (Notification.permission !== 'denied') {
		Notification.requestPermission(function (permission) {
			if (!('permission' in Notification)) {
				Notification.permission = permission;
			}
			if (permission === "granted") {
				callAjaxNotifications();
			}
		});
	}
}
var interval = setInterval(function () { notifyMe(); }, 10000);

*/
