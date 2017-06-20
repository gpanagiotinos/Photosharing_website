this.autocomplete = function()
{
	$(window).click(function(){
		$('.suggestion').remove();
	});

	$('#autocomplete').live('keyup', function(e)
	{
		//find suggestions
		var position = $(this).position();
		var width = $(this).width();
		var rel = $(this).attr('rel');

		var str = $(this).val();
		var dataStr = 'str=' + str + '&rel=' + rel;
		var topOffset = 27;
		var leftOffset = 4;

		$.ajax({
			url: 'ajax/autocomplete.php',
			dataType: 'html',
			success: function(data){
						if(data != 'empty')
						{
							$('body').append('<div class="suggestion"></div>');
							//append data to suggestion div.
							$('.suggestion').css('top',(position.top + topOffset) + 'px');
							$('.suggestion').css('left',(position.left + leftOffset) + 'px');
							$('.suggestion').width(width+6);
							$('.suggestion').html(data).fadeIn();
						}
						else{
							$('.suggestion').remove();
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

	});


	$('.suggestion ul li a').live('click', function(){
		var text = this.title;
		var rel = $(this).attr('rel');

		var currentInput = $('#autocomplete[rel='+rel+']');
		var current = currentInput.val();
		currentInput.val(current + text + ' ').focus();

		$('.suggestion').remove();
		return false;
	});
}
