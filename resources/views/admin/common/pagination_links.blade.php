@if($post_items instanceof \Illuminate\Pagination\LengthAwarePaginator )
	<div class="row">
		<div class="col-sm-12">
			{!! $post_items->appends(Input::get())->links() !!}
		</div>
	</div>
@endif