$(function(){

//tag delete
$('a.deleteTag').click(function(){
	var tag = $(this);

	var info = tag.attr('id').split('|');
	var tag_id = info[0];
	var photo_id = info[1];



	var dataStr = 'tag_id=' + tag_id + '&photo_id=' + photo_id;

	$.ajax({
		url: 'ajax/tag.php',
		dataType: 'html',
		success: function(data){
					if(data == 'ok')
					{
						tag.remove();
						$('#tooltip').remove();
					}else{
						alert('Error:' + data);
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

	return false;
});

imageInfo();
tooltip();
autocomplete();

$('#pass').keyup(function(e)
{	
	 var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
	 var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");

	if (strongRegex.test($(this).val())) {
		$('#passstrength').attr('class', 'message success');
		$('#passstrength').text('Δυνατός');
	} else if (mediumRegex.test($(this).val())) {
		$('#passstrength').attr('class', 'message alert');
		$('#passstrength').text('Μέτριος');
	} else {
		$('#passstrength').attr('class', 'message error');
		$('#passstrength').text('Αδύναμος');
	}

	 return true;
}
);

});

