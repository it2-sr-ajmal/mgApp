<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">
			<h5 class="card-header">{{ lang('search') }}</h5>
			<div class="card-body">
				{{ Form::open(array('method'=>'get' )) }}
					@if(!empty($filters))
						<div class="row" >
						@foreach($filters as $key => $filter)
						<?php //dd($filter['type']); ?>
							<div class="col-sm-3">
								<div class="form-group">
									<label>{{ lang($key) }}</label>
									@if($filter['type'] == 'select')
									
										<select name="{{ $filter['name'] }}" class="form-control">
											<option value="">{{ lang('select_one') }}</option>
											<?php if(!empty($filter['data'])) {?>
												<?php foreach($filter['data'] as $key => $val) {  ?>
													<option value="{{ $key }}" {!! (Input::get($key) == $key ) ? 'selected="selected"' : '' !!}>{{ $val }}</option>	
												<?php } ?>
											<?php } ?>
										</select>
									@else
										<div class="input-group">
											<input type="text" id="{{  $filter['name'] }}"  name="{{  $filter['name'] }}" value="{{ Input::get( $filter['name']) }}" class="form-control">
										</div>
									@endif
								</div>
							</div>
						@endforeach
						</div>
					@endif
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group float-sm-right">
								<input type="submit" class="btn btn-info btn-flat" name="search" value="{{ lang('search') }}" />	
								<a href=""><input type="button" name="filterNow" class=" btn btn-primary" value="{{ lang('reset') }}" /></a> 
							</div>
						</div>
					</div>
				
				{{ Form::close() }}
				
				
			</div>
		</div>
	</div>
</div>