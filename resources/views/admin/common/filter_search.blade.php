<div >
			{{ Form::open(array('name'=>'filter-reg','url'=>route('post_index',[$postType]),'method'=>'get' )) }}				
				 <div class="row">						
					<div class="col-sm-4 form-group">
						<input type="text" name="post_title" class="form-control border {{ !empty(Input::get('post_title')) ? 'border-green' : '' }}" value="{{Input::get('post_title')}}" placeholder="Filter by Title" /> 
					</div>
					<div class="col-sm-4 form-group">
						<input type="submit" class=" btn btn-success"  /> 
						<a href="{{ route('post_index',[$postType]) }}"><input type="button" name="filterNow" class=" btn btn-primary" value="Reset" /></a> 
					</div>
				</div>
				
			{{ Form::close()}}
				
			</div>