this.imageInfo = function(){

	//config vars
	var xOffset = 5;
	var yOffset = 10;

	//hover info
	$('a.imageArcher').hover(function(e){
	//over
	var dataStr = 'id=' + this.id;
	$("body").append("<div id='tooltip'><img src='themes/Default/images/icons/loader.gif'/></div>");
	$.ajax({
		url: 'ajax/imageinfo.php',
		dataType: 'html',
		success: function(data){
					if(data != 'empty')
					{
						$('#tooltip').html(data);

					}
					else{
						$('#tooltip').text('Χωρίς πληροφορίες');
					}	
				},
		data: dataStr,
		method: 'get',
		statusCode: {
			404:function() {
					alert("404:Page not found!");
				}
			}
	});

									 
	$("#tooltip")
		.css("top",(e.pageY - xOffset) + "px")
		.css("left",(e.pageX + yOffset) + "px")
		.fadeIn("fast");
	},
	function(){
	//off
	$("#tooltip").remove();
	});

	//Follow mouse
	$("a.imageArcher").mousemove(function(e){
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});


};

