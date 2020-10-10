<div id="filterOptions" style="{{empty(app('request')->input('filterNow')) ? '' : ''}}" class="card">
     <div class="card-body ">
        {{ Form::open(array('name'=>'filter-farms','url'=>route('contact-request'),'method'=>'get' )) }}
        <div class="row">
            <div class="col-md-4 form-group">
                <input type="text" name="name" class="dirChange form-control border {{ !empty(app('request')->input('name')) ? 'border-green' : '' }}" value="{{app('request')->input('name')}}" placeholder="Search by Name" />
            </div>
            <div class="col-md-4 form-group">
                <input type="text" name="email" class="dirChange form-control border {{ !empty(app('request')->input('email')) ? 'border-green' : '' }}" value="{{app('request')->input('email')}}" placeholder="Search by Email" />
            </div>
            <div class="col-md-4 form-group">
                 <select class="form-control {{ !empty(app('request')->input('enquire_about')) ? 'border-green' : '' }}" name="enquire_about" id="enquire_about" required>
	                  <option value=""  >Choose your option</option>
	                  <option {{ (app('request')->input('enquire_about') ==  "Investment/Partnership Opportunity" )?' selected ':'' }} value="Investment / Partnership Opportunity">Investment/Partnership Opportunity</option>
	                  <option {{ (app('request')->input('enquire_about') ==  "Products and Services")?'  selected  ':'' }} value="Products and Services">Products and Services</option>
	                  <option {{ (app('request')->input('enquire_about') == "Feedback/Suggestion")?' selected  ':'' }} value="Feedback/Suggestion">Feedback / Suggestion</option>
	                  <option {{ (app('request')->input('enquire_about') ==  "Job Opportunity")?'  selected ':'' }} value="Job Opportunity">Job Opportunity</option>
	                </select>
            </div>
    		<div class="col-md-4 form-group">
                <input type="text" name="from_date" class="datepicker form-control border {{ !empty(app('request')->input('from_date')) ? 'border-green' : '' }}" value="{{app('request')->input('from_date')}}" placeholder="Search by from Date" />
            </div>
            <div class="col-md-4 form-group">
                <input type="text" name="to_date" class="datepicker form-control border {{ !empty(app('request')->input('to_date')) ? 'border-green' : '' }}" value="{{app('request')->input('to_date')}}" placeholder="Search by to Date" />
            </div>
            <input type="hidden" name="sortCol" id="sortCol" value ="" />
            <input type="hidden" name="sortOrd" id="sortOrd" value ="" />

            <div class="col-md-4 form-group">
                <div class="">
                    <input type="submit" name="filterNow" id="filterNow" class="btn btn-outline-success" value="Search" />
                    <a href="{{ route('contact-request') }}" class=" btn btn-outline-primary">Reset</a>
                </div>

            </div>
        </div>
        {{ Form::close() }}

    </div>
</div>