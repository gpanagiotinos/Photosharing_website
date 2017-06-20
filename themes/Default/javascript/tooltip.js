this.tooltip = function(){

	var xOffset = -22;
	var yOffset = -15;

	$('a.tooltip').hover(function(e){
		var title = this.rel;
		$('body').append('<div id="tooltip">'+title+'</div>');
		
		$('#tooltip')
		.css('top', (e.pageY - xOffset) + 'px')
		.css('left', (e.pageX + yOffset) + 'px')
		.fadeIn("fast");;
	},
	function(){
		$('#tooltip').remove();
	})

	//Follow mouse
	$("a.tooltip").mousemove(function(e){
		$("#tooltip")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});


};