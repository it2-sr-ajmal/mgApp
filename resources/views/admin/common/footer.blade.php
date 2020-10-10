    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script type="text/javascript">
      $.widget.bridge('uibutton', $.ui.button);
    </script>

     <script src="{{ asset('assets/admin/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- Morris.js charts 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{ asset('assets/admin/plugins/morris/morris.min.js')}}" type="text/javascript"></script>-->
    <!-- Sparkline -->
    <script src="{{ asset('assets/admin/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets/admin/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
    <!-- datepicker -->
    <script src="{{ asset('assets/admin/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('assets/admin/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/admin/plugins/fastclick/fastclick.min.js') }}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/plugins/dist/js/app.min.js') }}" type="text/javascript"></script>
	
	<script src="{{ asset('assets/admin/plugins/input-mask/jquery.inputmask.js') }}"></script>
	<!--<script src="{{ asset('assets/admin/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
	<script src="{{ asset('assets/admin/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>-->

    <!-- AdminLTE dashboard demo (This is only for demo purposes) 
    <script src="{{ asset('assets/admin/plugins/dist/js/pages/dashboard.js') }}" type="text/javascript"></script>-->
    <!-- AdminLTE for demo purposes -->
	<script src="<?php echo asset('assets/admin/plugins/timepicker/bootstrap-timepicker.min.js'); ?>" type="text/javascript"></script> 
    <script src="{{ asset('assets/admin/plugins/dist/js/demo.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function(){
			 	// $('.timepicker').timepicker({ showInputs: true}); 
		  });
		$(document).ready(function(e){
			$('body').on('keypress','.numOnly',function(e){
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
						   return false;
				}
			});
			/* $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});
			tinymce.init({
					selector: '#editor1',
					height:250,
					toolbar: "bullist | numlist | formate | forecolor | backcolor | sizeselect | bold | italic | underline | fontsizeselect | inserttable | alignleft | aligncenter | alignright | alignjustify | link | image",
					plugins: ["textcolor","table","image","link","spellchecker","preview","fullscreen","code"],			 
			}); */
		});
	</script>
  </body>
</html>