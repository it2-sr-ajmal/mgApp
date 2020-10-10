<div id="filterOptions" style="{{empty(Request::get('filterNow')) ? '' : ''}}">
    <div class="card-body"> 
    {{ Form::open(array('name'=>'filter-reg','url'=>Config::get('app.admin_prefix').'/admin_users','method'=>'get' )) }}
        <div class="row">                                            
            <div class="col-md-4 form-group">
                <input type="text" name="name" class="dirChange form-control border {{ !empty(Request::get('name')) ? 'border-green' : '' }}" value="{{Request::get('name')}}" placeholder="Search by Name" /> 
            </div>  
			<div class="col-md-4 form-group">
                <input type="text" name="email" class="dirChange form-control border {{ !empty(Request::get('email')) ? 'border-green' : '' }}" value="{{Request::get('email')}}" placeholder="Search by Email" /> 
            </div>   
            
            <div class="col-md-4 form-group">
                <select name="status" class="border form-control {{ !empty(Request::get('status')) ? 'border-green' : '' }}">
                    <option value="">Search By Status</option>
                    <option value="1" {!! (Request::get('status') ==1 ) ? 'selected="selected"' : '' !!}>Active</option>
                    <option value="2" {!! (Request::get('status') ==2 ) ? 'selected="selected"' : '' !!}>Pending</option>
                </select>
            </div>            
            <input type="hidden" name="sortCol" id="sortCol" value ="" />
            <input type="hidden" name="sortOrd" id="sortOrd" value ="" />
            <div class="clearfix"></div>
            <div class="col-md-4 form-group">
                <div class="btn-group">
                    <input type="submit" name="filterNow" id="filterNow" class="btn btn-outline-success" value="Search" /> 
                    <a href="{{ URL::to(Config::get('app.admin_prefix').'/admin_users') }}" class="btn btn-outline-primary">Reset</a> 
                </div>
            </div>
        </div>
    {{ Form::close() }}
</div>
    
</div>