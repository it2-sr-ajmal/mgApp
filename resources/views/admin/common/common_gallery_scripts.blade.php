<script>
	$(document).ready(function(){
		var sortableWrapper = "#{{ (!empty($galleryLister))?$galleryLister:'galleryWrapper' }}";
		$(sortableWrapper).sortable({
			connectWith: sortableWrapper,
			 start: function (event, ui) {
				ui.item.toggleClass("highlight");
			  },
			  over: function(event, ui) {
				if ($(this).closest("ul").prop("id") == "draggable") {
				  $(ui.placeholder).css('display', '');
				} else {
				  var item = $(ui.item);
				  var from = item.parent().is("#draggable");
				  if (from && $(this).children().length > 4) {
					$(ui.placeholder).css('display', 'none');
				  } else {
					$(ui.placeholder).css('display', '');
				  }
				}
			  },
			  stop: function (event, ui) {
				var item = $(ui.item);
				var to = item.parent().is(".droppable");
				var siblingsCount = item.siblings().length;
				if (to && siblingsCount > 3) {
				  return false;
				}
				ui.item.toggleClass("highlight");
			  },
			update: function (event, ui) {
				var idsInOrder =$(sortableWrapper).sortable("toArray");
				var dataToSend={'ids':idsInOrder,'_token':$('meta[name="csrf-token"]').attr('content')}
				PGSADMIN.utils.sendAjax('{{ route('post_media_update_priority') }}', 'POST', dataToSend,function(responseData){});
				
			}
		}).disableSelection();
		
		
	});
	
	$(function() {
		$('.myFileLister').on('blur','.changeText', function(){
			var _this=$(this);
			var _text=_this.val();
			var _text_id=_this.attr('data-id');
			var _text_type=_this.attr('data-type');
			var dataToSend={
				'_text':_text,
				'_text_id':_text_id,
				'_text_type':_text_type,
				'_token':$('meta[name="csrf-token"]').attr('content')};
				//console.log(dataToSend);
			PGSADMIN.utils.sendAjax('{{ route('post_media_update_text') }}', 'POST', dataToSend,function(responseData){
				if(!responseData.status){
					Swal.fire({
						title: 'Error',
						text: responseData.message,
						type: 'error',
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ok'
					});
				}
				
				_this.parent().addClass('textUpdated');
				setTimeout(function(){
					_this.parent().removeClass('textUpdated');
				},1000);
				
			});
		});
		
		
		 $('.myFileLister').on('change','.cardLang',function(){
			var _this=$(this);
			var _text=_this.val();
			
			var _text_id=$(this).attr('data-id');
			var _text_type='pm_lang';
			var dataToSend={
				'_text':_text,
				'_text_id':_text_id,
				'_text_type':_text_type,
				'_token':$('meta[name="csrf-token"]').attr('content')};
				//console.log(dataToSend);
			PGSADMIN.utils.sendAjax('{{ route('post_media_update_text') }}', 'POST', dataToSend,function(responseData){
				if(!responseData.status){
					Swal.fire({
						title: 'Error',
						text: responseData.message,
						type: 'error',
						confirmButtonColor: '#3085d6',
						confirmButtonText: 'Ok'
					});
				}
				
				_this.parent().addClass('textUpdated');
				setTimeout(function(){
					_this.parent().removeClass('textUpdated');
				},1000);
				
			});
		});
});
</script>