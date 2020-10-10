<script type="text/javascript" src="{{ asset('assets/admin/vendor/jquery/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/fancybox/jquery.fancybox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/stickymessage/sticky.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/jquery-validator/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/slimscroll/jquery.slimscroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/basictable/jquery.basictable.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/select2/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/inputmask/js/jquery.inputmask.bundle.js') }}"></script>
<script src="<?php echo asset('assets/admin/plugins/plupload/plupload.full.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/admin/vendor/pgs/js/admin.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
 
</script>

<script type="text/javascript">			
$(function() {
	<?php /* open parent menu by adding class */ ?>
	$('.submenu ').find('.nav-link').each(function(i,el){
		if($(el).hasClass('active')){
			$(el).closest('.submenu').addClass('show');
		}
	});
	
	$('.datepicker').datepicker({autoclose:true});
	$(".landphonemaskUAE").inputmask("99 999 9999");
	$(".mobileUAE").inputmask("00\\971 999 999 999");
	
	
	
	
}); 

$(document).ready(function() {
	PGSADMIN.init();
	if ($(".menu-list").length) {
		$('.menu-list').slimScroll({});
		}
	
	setTimeout(function(){
		$('.message-wrapper').fadeOut();
	},20000) 
	
	$('body').on('click','.deleteRecord',function(e){
		var _this = $(this);
		var _dataMsg = $(this).attr('data-message');
		
		var _message = (_dataMsg) ? _dataMsg :'{{empty($postType) ? 'Delete this entry ?' : 'Delete this '.$postType.' ?' }}'
		e.preventDefault();
		
		Swal.fire({
			title: 'Are you sure ?',
			text: _message,
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes !'
			}).then((result) => {
			if (result.value) {
				window.location.href = _this.attr('href');
			}
		});
		
	});
	$(".numOnly").keydown(function (e) {
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
		(e.keyCode >= 35 && e.keyCode <= 40)) {
			return;
		}
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	});
	
	@if(!empty($topMessage))
		$('#topMessage').html("{{ $topMessage }}");
		$('#topMessage').removeClass('hidden');
		setTimeout(function(){
			$('#topMessage').addClass('hidden');
			$('#topMessage').html('');
		},6000);
	@endif
	
	$('form').validate();
});
</script>

