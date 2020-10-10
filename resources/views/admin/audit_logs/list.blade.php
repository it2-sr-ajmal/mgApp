@extends('admin.layouts.master')
@section('styles')
@parent
@stop
@section('content')
@section('bodyClass')
@parent
hold-transition skin-blue sidebar-mini
@stop
<div class="container-fluid dashboard-content">
   <div class="row">
   		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="card">
				<div class="card-header d-flex">
					<h3 class="card-header-title">Log Entries</h3>
				</div>
				<div id="filterOptions" style="{{empty(app('request')->input('filterNow')) ? '' : ''}}">
     <div class="card-body ">
        {{ Form::open(array('name'=>'filter-farms','url'=>apa('audit_logs'),'method'=>'get' )) }}
        <div class="row">

    		<div class="col-md-4 form-group">
                <input type="text" autocomplete="off" name="from_date" class="datepicker form-control border {{ !empty(app('request')->input('from_date')) ? 'border-green' : '' }}" value="{{app('request')->input('from_date')}}" placeholder="Search by from Date" />
            </div>
            <div class="col-md-4 form-group">
                <input type="text" autocomplete="off" name="to_date" class="datepicker form-control border {{ !empty(app('request')->input('to_date')) ? 'border-green' : '' }}" value="{{app('request')->input('to_date')}}" placeholder="Search by to Date" />
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
				<div class="card-body border-bottom" style="{{(empty($userMessage)) ? 'display: none' : ''}}">
					@include('admin.common.user_message')
				</div>
				<div class="card-body ">
					<h4>{{ $auditList->total() }} entries found.</h4>

					<div class="row">
						<?php if (count($auditList) > 0) {
	?>
							<?php
$inc = getPaginationSerial($auditList);
	foreach ($auditList as $key => $audit) {

		?>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
								<div class="card mb-3">
									<div class="card-body">
										<div class="section-block">
											<h5 class="section-title">Action - <span class="badge badge-secondary ml-3">{{ ucfirst($audit->event) }}</span></h5>

										</div>
										<div class="tab-outline">
											<ul class="nav nav-tabs " id="myTab{{ $key }}" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" id="basic-tab{{ $key }}" data-toggle="tab" href="#basic{{$key}}" role="tab" aria-controls="basic{{ $key }}" aria-selected="true">Basic Details</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="old-tab{{ $key }}" data-toggle="tab" href="#old{{ $key }}" role="tab" aria-controls="old{{ $key }}" aria-selected="false">Old value</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="new-tab{{ $key }}" data-toggle="tab" href="#new{{ $key }}" role="tab" aria-controls="new{{ $key }}" aria-selected="false">New Value</a>
											</li>
											</ul>
											<div class="tab-content" id="myTabContent{{ $key }}">
												<div class="tab-pane fade show active" id="basic{{ $key }}" role="tabpanel" aria-labelledby="basic-tab{{ $key }}">


													<ul class="list-group">
														<li class="list-group-item d-flex justify-content-between align-items-center">
														URL :
														<span class="limite_word_break">{{ (substr($audit->url, -1) == "?")?substr($audit->url,0,-1):$audit->url }}</span>
														</li>
														<li class="list-group-item d-flex justify-content-between align-items-center">
														IP :
														<span class="limite_word_break">{{ $audit->ip_address }}</span>
														</li>
														<li class="list-group-item d-flex justify-content-between align-items-center">
														Action :
															<span class="limite_word_break">{{ ucfirst($audit->event) }}</span>
														</li>
														@if(isset($audit->user))
															<li class="list-group-item d-flex justify-content-between align-items-center">USER:
																<span>{{ ucfirst($audit->user->user_full_name) }}</span>
															</li>
														@endif
														<li class="list-group-item d-flex justify-content-between align-items-center">
														Date Time :
															<span class="limite_word_break">{{ date('d M,Y h:i a',strtotime($audit->created_at)) }}</span>
														</li>
													</ul>

												</div>
												<div class="tab-pane fade" id="old{{ $key }}" role="tabpanel" aria-labelledby="old-tab{{ $key }}">
													<table class="table table-bordered table-hover hide_td_overflow" style="width:100%">
														@foreach($audit->old_values as $attribute  => $value)
                                                            @if(!in_array($attribute,['product_misc']))
															<tr>
																<td width="40%"><b>{{ str_replace('_',' ',$attribute)  }}</b></td>
																<td>{{ $value }}</td>
															</tr>
                                                            @endif
														@endforeach
													</table>
												</div>
												<div class="tab-pane fade" id="new{{ $key }}" role="tabpanel" aria-labelledby="new-tab{{ $key }}">
													<table class="table table-bordered table-hover hide_td_overflow" style="width:100%">
														@foreach($audit->new_values as  $attribute  => $data)
														   @if(!in_array($attribute,['product_misc']))
															<tr>
																<td width="40%"><b>{{ str_replace('_',' ',$attribute)  }}</b></td>
																<td>{{ $data }}</td>
															</tr>
															@endif
														@endforeach
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php }?>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
								<div class="card mb-3">
									<div class="card-body">
										{{ $auditList->links() }}
									</div>
								</div>
							</div>
						<?php } else {?>
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
								<div class="card mb-3">
									<div class="card-body">
										<div class="alert alert-danger alert-dismissable">
											<i class="fa fa-ban"></i>
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<b>Alert!</b> No Records Found!.
										</div>
									</div>
								</div>
							</div>
						<?php }?>

					</div>

				</div>
			</div>
		</div>

   </div>

   <?php /* <div class="row">

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<div class="card">

<div class="card-body">
<div class="table-responsive">

<?php  if(count($auditList)>0){ ?>
<table id="members1" class="table table-bordered table-hover">
<thead>
<tr>
<th>#</th>
<th>Action</th>
<th>Old value</th>
<th>New Value</th>
<th>Date Time</th>
</tr>
</thead>
<tbody>
<?php
$inc=getPaginationSerial($auditList);
foreach ($auditList as $audit){

?>
<tr>
<td>{{ $inc++ }}</td>
<td>
<ul>
<li>URL: {{ (substr($audit->url, -1) == "?")?substr($audit->url,0,-1):$audit->url }}</li>
<li>IP: {{ $audit->ip_address }}</li>
<li>ACTION: {{ ucfirst($audit->event) }}</li>
@if(isset($audit->user))
<li>USER: {{ ucfirst($audit->user->user_full_name) }}</li>
@endif
</ul>
</td>
<td>
<table class="table table-bordered table-hover" style="width:100%">
@foreach($audit->old_values as $attribute  => $value)
<tr>
<td><b>{{ str_replace('_',' ',$attribute)  }}</b></td>
<td>{{ $value }}</td>
</tr>
@endforeach
</table>
</td>
<td>
<table class="table table-bordered table-hover" style="width:100%">
@foreach($audit->new_values as  $attribute  => $data)
<tr>
<td><b>{{ str_replace('_',' ',$attribute)  }}</b></td>
<td>{{ $data }}</td>
</tr>
@endforeach
</table>
</td>
<td>{{ date('d M,Y h:i a',strtotime($audit->created_at)) }}</td>
</tr>
<?php } ?>
<tr><td colspan="5">{{ $auditList->links() }}</td></tr>
</tbody>
</table>
<?php }else{ ?>
<div class="row col-sm-12">
<div class="alert alert-danger alert-dismissable">
<i class="fa fa-ban"></i>
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<b>Alert!</b> No Records Found!.
</div>
</div>
<?php } ?>
</div>
</div>
</div>
</div>

</div>  */?>
</div>

@stop
@section('scripts')
@parent
@stop