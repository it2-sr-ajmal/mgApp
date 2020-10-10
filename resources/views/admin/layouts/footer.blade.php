 <div class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
             
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="text-md-right footer-links d-none d-sm-block">
                     Powered by <a class="no-margin" target="_blank" href="https://www.pgsuae.com">PGSUAE</a>. <b>Version</b> 3.8 
                </div>
            </div>
        </div>
    </div>
</div>
<a href="#" id="toTop" style="display:none"> <span id="toTopHover" style="opacity: 1;"> </span></a>
@section('scripts')
@parent
<script>
$('#post-form').submit(function() {
	if ( typeof( tinyMCE) != "undefined" ) {
        tinyMCE.triggerSave();
    }
}).validate({ 
	ignore: '' 
});
</script>
@stop