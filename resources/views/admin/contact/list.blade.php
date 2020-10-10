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
         <div class="page-header">
            <h2 class="pageheader-title">Contact Request List
               <a class="float-sm-right" href="{{ route('contact-request-download',request()->all()) }}"> 
               <button class="btn btn-success btn-flat">{{ lang('download') }}</button>
               </a> 
            </h2>
         </div>
            @include('admin.contact.filters')  
		 </div>
   </div>

   <div class="row">
      
      <div class="col-sm-12">
         @include('admin.common.user_message')
      </div>
      <!-- ============================================================== -->
      <!-- striped table -->
      <!-- ============================================================== -->
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
         <div class="card">
            <div class="col-sm-12 card-header my-table-header">
               <div class="row align-items-center">
                  <div class="col-sm-6">
                     <h5 class="">{{ $contactUsDetails->total() }} {{ lang('results_found') }}</h5>
                  </div>
                  <?php /*<div class="col-sm-6"><h5 class="text-right">Showing {{ $hubList->currentPage() }} of {{  $hubList->total() }} pages</h5></div> */ ?>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive-md">
                  <table class="table table-striped table-bordered">
                     <thead>
                        <tr>		
                           <th scope="col">#</th>
                           <th scope="col">Name</th>
                           <th scope="col">Email</th>
                           <th scope="col">Phone Number</th>
                           <th scope="col">Enquire About</th>
                           <th scope="col">Message</th>
                           <th scope="col">Submission Date</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if( !empty($contactUsDetails) && $contactUsDetails->count() >0 )
                        <?php $inc = getPaginationSerial($contactUsDetails);   ?>
                        @foreach($contactUsDetails as $key => $submission)      
							<tr>
							   <th scope="row">{{ $inc++ }}</th>
							   <td>{{$submission->cu_name}}</td>
							   <td>{{$submission->cu_email}}</td>
							   <td>{{$submission->cu_phone_code}}{{$submission->cu_phone_number}}</td>
							   <td>{{$submission->cu_enquire_about}}</td>
							   <td>{{$submission->cu_message}}</td>
							   <td>{{ ($submission->created_at) ? date('d M Y  h:i A',strtotime($submission->created_at)) : '-' }}</td>
							  
							</tr>
                        @endforeach
                        <tr>
                           <td colspan="10">{{ $contactUsDetails->appends(request()->all())->links() }}</td>
                        </tr>
                        @else
                        <tr class="no-records">
                           <td colspan="10" class="text-center text-danger">No details found</td>
                        </tr>
                        @endif
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
      <!-- ============================================================== -->
      <!-- end striped table -->
      <!-- ============================================================== -->
   </div>
</div>

@stop
@section('scripts')
@parent

@stop