@extends('admin.layouts.master')

@section('title')
{{ isset($edit) ? "Edit" : "Add" }} User
@endsection

@section('content')

<div class="content-header row">
  <div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
      <div class="col-12">
        <h2 class="content-header-title float-start mb-0">User</h2>
        <div class="breadcrumb-wrapper">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">List</a>
            </li>
            <li class="breadcrumb-item active">{{ isset($edit) ? "Edit" : "Add" }} User
            </li>
          </ol>
        </div>

      </div>
    </div>
  </div>
</div>


<div class="content-body"><!-- Validation -->
  <section class="">
    <div class="row">
      <div class="col-md-12 col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">User Details</h4>
          </div>
          <div class="card-body">
            <form id="myForm" class="repeater">
              @csrf

              @if(isset($edit))
              <input type="hidden" name="id" value="{{ $edit->id }}">
              @endif

              <div class="row mt-2">
                <div class="col-md-12">
                  <h4 class="text-primary">Personal Details</h5>
                  <hr>
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>Name <span class="required">*</span> </label>
                  <input type="text" name="name" placeholder="Enter Name" class="form-control" @if(isset($edit)) value="{{ @$edit->name }}" @endif >
                </div>

                <div class="col-md-6">
                  <label>Father Name <span class="required">*</span> </label>
                  <input type="text" name="father_name" placeholder="Enter Father Name" class="form-control" @if(isset($edit)) value="{{ @$edit->father_name }}" @endif >
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>Professional <span class="required">*</span></label>
                  <select class="form-control" name="professional">
                    <option value="">Select Professional</option>
                    
                    @foreach(\App\Models\User::$professionals as $key => $value)
                      <option value="{{ $value }}" @if(isset($edit) && $value == $edit['professional']) selected="" @endif>{{ $value }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <label>Birth Date <span class="required">*</span></label>
                  <input type="date" max="{{ date("Y-m-d") }}" name="birth_date" placeholder="Enter Birth Date" class="form-control" @if(isset($edit)) value="{{ @$edit->birth_date }}" @endif >
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>Email <span class="required">*</span></label>
                  <input type="email" name="email" placeholder="Enter Email" class="form-control" @if(isset($edit)) value="{{ @$edit->email }}" @endif >
                </div>

                <div class="col-md-6">
                  <label>Mobile No <span class="required">*</span></label>
                  <input type="text" name="mobile_no" placeholder="Enter Mobile No" class="form-control" @if(isset($edit)) value="{{ @$edit->mobile_no }}" @endif >
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>Blood Group <span class="required">*</span></label>
                  <select class="form-control" name="blood_group">
                    <option value="">Select Blood Group</option>
                    
                    @foreach(\App\Models\User::$blood_groups as $key => $value)
                      <option value="{{ $value }}" @if(isset($edit) && $value == $edit->blood_group) selected="" @endif >{{ $value }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6">
                  <div class="row mt-2">
                    <div class="col-md-6 mb-1">
                      <label>Physical Disability <span class="required">*</span></label>
                    </div>

                    <div class="col-md-6 mb-1">
                      <div class="form-radio">
                        <input class="form-radio-input physical_disability" type="radio" value="1" name="physical_disability" @if(isset($edit) && $edit->physical_disability == 1) checked="" @endif/>
                        <label class="form-radio-label" for="b_degree">
                          Yes
                        </label>

                        <input class="form-radio-input physical_disability" type="radio" value="0" name="physical_disability" @if((isset($edit) && $edit->physical_disability == 0) || !isset($edit)) checked="" @endif />
                        <label class="form-radio-label" for="b_degree">
                          No
                        </label>
                      </div>
                    </div>
                  </div>

                </div>
              </div>


              @if(!isset($edit))
              <div class="row mb-1">
                <div class="col-md-6">
                  <label>Password <span class="required">*</span></label>
                  <input type="password" name="password" id="password" placeholder="Enter password" class="form-control">
                </div>

                <div class="col-md-6">
                  <label>Confirm Password <span class="required">*</span></label>
                  <input type="password" name="confirm_password" placeholder="Enter confirm password" class="form-control">
                </div>
              </div>
              @endif

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>User Image <span class="required">*</span></label>
                  <input type="file" name="user_profile_pic" accept="image/*" class="form-control">
                  @if(isset($edit) && @$edit->user_profile_pic)
                    <img src="{{ asset('file/user/'.$edit->user_profile_pic)}}" height="100" width="100" class="mt-1 mb-1">
                  @endif

                </div>

                <div class="col-md-6">
                  <label>Father Image <span class="required">*</span></label>
                  <input type="file" name="father_profile_pic" accept="image/*" class="form-control">
                  @if(isset($edit) && @$edit->father_profile_pic)
                    <img src="{{ asset('file/user/'.$edit->father_profile_pic)}}" height="100" width="100" class="mt-1 mb-1">
                  @endif

                </div>

              </div>


              <div class="row mt-4">
                <div class="col-md-12">
                  <h4 class="text-primary">Contact Details</h5>
                  <hr>
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-12">
                  <h6 class="text-info">Present Address</h6>
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-12">
                  <label>Address <span class="required">*</span></label>
                  <textarea name="p_address" placeholder="Enter Address" class="form-control">@if(isset($edit)){{ @$edit->contact_detail->p_address }}@endif</textarea>
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>City <span class="required">*</span></label>
                  <input type="text" name="p_city" placeholder="Enter City" class="form-control" @if(isset($edit)) value="{{ @$edit->contact_detail->p_city }}" @endif >
                </div>

                <div class="col-md-6">
                  <label>Pincode <span class="required">*</span></label>
                  <input type="text" name="p_pincode" placeholder="Enter Pincode" class="form-control"  @if(isset($edit)) value="{{ @$edit->contact_detail->p_pincode }}" @endif>
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>State <span class="required">*</span></label>
                  <input type="text" name="p_state" placeholder="Enter State" class="form-control" @if(isset($edit)) value="{{ @$edit->contact_detail->p_state }}" @endif >
                </div>

                <div class="col-md-6">
                  <label>Country <span class="required">*</span></label>
                  <input type="text" name="p_country" placeholder="Enter Country" class="form-control" @if(isset($edit)) value="{{ @$edit->contact_detail->p_country }}" @endif>
                </div>
              </div>

              <div class="row mb-1 mt-4">
                <div class="col-md-6">
                  <h6 class="text-info">Native Address</h6>
                </div>

                <div class="col-md-6">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="both_address_same" name="both_address_same"/>
                    <label class="form-check-label" for="both_address_same">
                      Same As Present Address
                    </label>
                  </div>
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-12">
                  <label>Address </label>
                  <textarea name="n_address" placeholder="Enter Address" class="form-control">@if(isset($edit)){{ @$edit->contact_detail->n_address }}@endif</textarea>
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>City </label>
                  <input type="text" name="n_city" placeholder="Enter City" class="form-control" @if(isset($edit)) value="{{ @$edit->contact_detail->n_city }}" @endif >
                </div>

                <div class="col-md-6">
                  <label>Pincode </label>
                  <input type="text" name="n_pincode" placeholder="Enter Pincode" class="form-control"  @if(isset($edit)) value="{{ @$edit->contact_detail->n_pincode }}" @endif>
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>State </label>
                  <input type="text" name="n_state" placeholder="Enter State" class="form-control" @if(isset($edit)) value="{{ @$edit->contact_detail->n_state }}" @endif>
                </div>

                <div class="col-md-6">
                  <label>Country </label>
                  <input type="text" name="n_country" placeholder="Enter Country" class="form-control"  @if(isset($edit)) value="{{ @$edit->contact_detail->n_country }}" @endif>
                </div>
              </div>


              <div class="family_details">
                
                <div class="row mt-4">
                  <div class="col-md-12">
                    <h4 class="text-primary">Family Details</h5>
                    <hr>
                  </div>
                </div>

                <div data-repeater-list="family_details">
                  
                  @if(isset($edit))

                    @foreach($edit->family_details as $key => $family)

                      <div data-repeater-item class="family_details_item">
                      
                        <div class="row mb-1">
                          <div class="col-md-6">
                            <label>Name <span class="required">*</span></label>
                            <input type="text" name="name" placeholder="Enter Name" class="form-control family_details_name" value= "{{ $family->name }}" >
                          </div>

                          <div class="col-md-6">
                            <label>Relation With User <span class="required">*</span></label>

                            <select class="form-control family_details_relation" name="relation">
                              <option value="">Select Relation</option>
                              
                              @foreach(\App\Models\FamilyDetail::$relation_data as $key => $value)
                                <option value="{{ $value }}" @if($family->relation == $value) selected="" @endif>{{ $value }}</option>
                              @endforeach
                            </select>

                          </div>
                        </div>

                        <div class="row mb-1">
                          <div class="col-md-6">
                            <label>Birth Date <span class="required">*</span></label>
                            <input type="date" max="{{ date("Y-m-d") }}" name="birth_date" placeholder="Enter Birth Date" class="form-control family_details_birth_date" value="{{ $family->birth_date }}" >
                          </div>

                          <div class="col-md-6">
                            <label>Profile Pic of Person</label>
                            <input type="hidden" name="profile_pic" value="{{ $family->profile_pic }}">
                            <input type="file" name="profile_pic" accept="image/*" class="form-control">

                            @if(@$family->profile_pic)
                              <img src="{{ asset('file/user/'.$family->profile_pic)}}" height="100" width="100" class="mt-1 mb-1">
                            @endif

                          </div>
                        </div>

                        <div class="row mb-1">
                          <div class="col-md-6">
                            <label>Blood Group <span class="required">*</span></label>
                            <select class="form-control family_details_blood_group" name="blood_group">
                              <option value="">Select Blood Group</option>
                              
                              @foreach(\App\Models\User::$blood_groups as $key => $value)
                                <option value="{{ $value }}" @if($family->blood_group == $value) selected="" @endif >{{ $value }}</option>
                              @endforeach
                            </select>
                          </div>

                          <div class="col-md-6">
                            <div class="row mt-2">
                              <div class="col-md-6 mb-1">
                                <label>Physical Disability <span class="required">*</span></label>
                              </div>

                              <div class="col-md-6 mb-1">
                                <div class="form-radio">
                                  <input class="form-radio-input family_details_physical_disability" type="radio" value="1" name="physical_disability" />
                                  <label class="form-radio-label" for="b_degree">
                                    Yes
                                  </label>

                                  <input class="form-radio-input family_details_physical_disability" type="radio" value="0" name="physical_disability" checked="" />
                                  <label class="form-radio-label" for="b_degree">
                                    No
                                  </label>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>

                        <div class="row mb-1">
                          <div class="col-md-6">
                            <label>Married Status <span class="required">*</span></label>

                            <select class="form-control" name="married_status">
                              <option value="">Select Married Status</option>
                              
                              @foreach(\App\Models\FamilyDetail::$married_status as $key => $value)
                                <option value="{{ $value }}" @if($family->married_status == $value) selected="" @endif >{{ $value }}</option>
                              @endforeach
                            </select>

                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12 mb-1">
                            <label>School Name 1 (Std 1 to 10) <span class="required">*</span></label>
                            <input type="text" name="school_name_1" placeholder="Enter School Name" class="form-control family_details_school_name_1" value="{{ $family->school_name_1 }}">
                          </div>

                          <div class="col-md-6 mb-1">
                            <div class="form-check">
                              <input class="form-check-input both_school_same" type="checkbox" value="1" name="both_school_same" />
                              <label class="form-check-label" for="both_school_same">
                                Same As School Name 1
                              </label>
                            </div>
                          </div>

                          <div class="col-md-12 mb-1">
                            <label>School Name 2 (Std 11 to 12)</label>
                            <input type="text" name="school_name_2" placeholder="Enter School Name" class="form-control family_details_school_name_2" value="{{ $family->school_name_2 }}">
                          </div>
                        </div>

                        <div class="row mb-1 mt-3">
                          <div class="col-md-12">
                            <h6 class="text-info">Degree Details</h6>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-3 mb-1">
                            <label>Bachelor Degree <span class="required">*</span></label>
                          </div>

                          <div class="col-md-9 mb-1">
                            <div class="form-radio">
                              <input class="form-radio-input family_details_b_degree" type="radio" value="1" name="b_degree" checked="" />
                              <label class="form-radio-label" for="b_degree">
                                Yes
                              </label>

                              <input class="form-radio-input family_details_b_degree" type="radio" value="0" name="b_degree" />
                              <label class="form-radio-label" for="b_degree">
                                No
                              </label>
                            </div>
                          </div>

                          <div class="col-md-12 mb-1">
                            <label>Bachelor Degree Name</label>
                            <input type="text" name="b_degree_name" placeholder="Enter Bachelor Degree Name" class="form-control family_details_b_degree_name"  value="{{ $family->b_degree_name }}">
                          </div>

                          <div class="col-md-12 mb-1">
                            <label>Bachelor Degree College Name</label>
                            <input type="text" name="b_college_name" placeholder="Enter Bachelor Degree College Name" class="form-control family_details_b_college_name"  value="{{ $family->b_college_name }}">
                          </div>
                        </div>

                        <div class="row mt-2">
                          <div class="col-md-3 mb-1">
                            <label>Master Degree <span class="required">*</span></label>
                          </div>

                          <div class="col-md-9 mb-1">
                            <div class="form-radio">
                              <input class="form-radio-input family_details_m_degree" type="radio" value="1" name="m_degree" checked="" />
                              <label class="form-radio-label" for="m_degree">
                                Yes
                              </label>

                              <input class="form-radio-input family_details_m_degree" type="radio" value="0" name="m_degree" />
                              <label class="form-radio-label" for="m_degree">
                                No
                              </label>
                            </div>
                          </div>

                          <div class="col-md-12 mb-1">
                            <label>Master Degree Name</label>
                            <input type="text" name="m_degree_name" placeholder="Enter Master Degree Name" class="form-control family_details_m_degree_name"  value="{{ $family->m_degree_name }}">
                          </div>

                          <div class="col-md-12 mb-1">
                            <label>Master Degree College Name</label>
                            <input type="text" name="m_college_name" placeholder="Enter Master Degree College Name" class="form-control family_details_m_college_name"  value="{{ $family->m_college_name }}">
                          </div>
                        </div>

                        @if($key > 0)
                        <div class="row mb-1">
                          <div class="col-md-12">
                            <a href="javascript:" class="btn btn-danger" data-repeater-delete> Remove Member</a>
                          </div>
                        </div>
                        @endif

                        <div class="row mb-1">
                          <div class="col-md-12">
                            <hr>
                          </div>
                        </div>

                      </div>

                    @endforeach

                  @else
                  
                    <div data-repeater-item class="family_details_item">
                      
                      <div class="row mb-1">
                        <div class="col-md-6">
                          <label>Name <span class="required">*</span></label>
                          <input type="text" name="name" placeholder="Enter Name" class="form-control family_details_name" value="" >
                        </div>

                        <div class="col-md-6">
                          <label>Relation With User <span class="required">*</span></label>

                          <select class="form-control family_details_relation" name="relation">
                            <option value="">Select Relation</option>
                            
                            @foreach(\App\Models\FamilyDetail::$relation_data as $key => $value)
                              <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                          </select>

                        </div>
                      </div>

                      <div class="row mb-1">
                        <div class="col-md-6">
                          <label>Birth Date <span class="required">*</span></label>
                          <input type="date" max="{{ date("Y-m-d") }}" name="birth_date" placeholder="Enter Birth Date" class="form-control family_details_birth_date" value="" >
                        </div>

                        <div class="col-md-6">
                          <label>Profile Pic of Person</label>
                          <input type="file" name="profile_pic" accept="image/*" class="form-control">
                        </div>
                      </div>

                      <div class="row mb-1">
                        <div class="col-md-6">
                          <label>Blood Group <span class="required">*</span></label>
                          <select class="form-control family_details_blood_group" name="blood_group">
                            <option value="">Select Blood Group</option>
                            
                            @foreach(\App\Models\User::$blood_groups as $key => $value)
                              <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="col-md-6">
                          <div class="row mt-2">
                            <div class="col-md-6 mb-1">
                              <label>Physical Disability <span class="required">*</span></label>
                            </div>

                            <div class="col-md-6 mb-1">
                              <div class="form-radio">
                                <input class="form-radio-input family_details_physical_disability" type="radio" value="1" name="physical_disability" />
                                <label class="form-radio-label" for="b_degree">
                                  Yes
                                </label>

                                <input class="form-radio-input family_details_physical_disability" type="radio" value="0" name="physical_disability" checked="" />
                                <label class="form-radio-label" for="b_degree">
                                  No
                                </label>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>

                      <div class="row mb-1">
                        <div class="col-md-6">
                          <label>Married Status <span class="required">*</span></label>

                          <select class="form-control" name="married_status">
                            <option value="">Select Married Status</option>
                            
                            @foreach(\App\Models\FamilyDetail::$married_status as $key => $value)
                              <option value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                          </select>

                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 mb-1">
                          <label>School Name 1 (Std 1 to 10) <span class="required">*</span></label>
                          <input type="text" name="school_name_1" placeholder="Enter School Name" class="form-control family_details_school_name_1">
                        </div>

                        <div class="col-md-6 mb-1">
                          <div class="form-check">
                            <input class="form-check-input both_school_same" type="checkbox" value="1" name="both_school_same" />
                            <label class="form-check-label" for="both_school_same">
                              Same As School Name 1
                            </label>
                          </div>
                        </div>

                        <div class="col-md-12 mb-1">
                          <label>School Name 2 (Std 11 to 12)</label>
                          <input type="text" name="school_name_2" placeholder="Enter School Name" class="form-control family_details_school_name_2">
                        </div>
                      </div>

                      <div class="row mb-1 mt-3">
                        <div class="col-md-12">
                          <h6 class="text-info">Degree Details</h6>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-3 mb-1">
                          <label>Bachelor Degree <span class="required">*</span></label>
                        </div>

                        <div class="col-md-9 mb-1">
                          <div class="form-radio">
                            <input class="form-radio-input family_details_b_degree" type="radio" value="1" name="b_degree" checked="" />
                            <label class="form-radio-label" for="b_degree">
                              Yes
                            </label>

                            <input class="form-radio-input family_details_b_degree" type="radio" value="0" name="b_degree" />
                            <label class="form-radio-label" for="b_degree">
                              No
                            </label>
                          </div>
                        </div>

                        <div class="col-md-12 mb-1">
                          <label>Bachelor Degree Name</label>
                          <input type="text" name="b_degree_name" placeholder="Enter Bachelor Degree Name" class="form-control family_details_b_degree_name"  >
                        </div>

                        <div class="col-md-12 mb-1">
                          <label>Bachelor Degree College Name</label>
                          <input type="text" name="b_college_name" placeholder="Enter Bachelor Degree College Name" class="form-control family_details_b_college_name"  >
                        </div>
                      </div>

                      <div class="row mt-2">
                        <div class="col-md-3 mb-1">
                          <label>Master Degree <span class="required">*</span></label>
                        </div>

                        <div class="col-md-9 mb-1">
                          <div class="form-radio">
                            <input class="form-radio-input family_details_m_degree" type="radio" value="1" name="m_degree" checked="" />
                            <label class="form-radio-label" for="m_degree">
                              Yes
                            </label>

                            <input class="form-radio-input family_details_m_degree" type="radio" value="0" name="m_degree" />
                            <label class="form-radio-label" for="m_degree">
                              No
                            </label>
                          </div>
                        </div>

                        <div class="col-md-12 mb-1">
                          <label>Master Degree Name</label>
                          <input type="text" name="m_degree_name" placeholder="Enter Master Degree Name" class="form-control family_details_m_degree_name"  >
                        </div>

                        <div class="col-md-12 mb-1">
                          <label>Master Degree College Name</label>
                          <input type="text" name="m_college_name" placeholder="Enter Master Degree College Name" class="form-control family_details_m_college_name"  >
                        </div>
                      </div>

                      <div class="row mb-1">
                        <div class="col-md-12">
                          <a href="javascript:" class="btn btn-danger" data-repeater-delete> Remove Member</a>
                        </div>
                      </div>

                      <div class="row mb-1">
                        <div class="col-md-12">
                          <hr>
                        </div>
                      </div>

                    </div>

                  @endif

                </div>

                <div class="row mb-1">
                  <div class="col-md-12">
                    <a href="javascript:" class="btn btn-primary" data-repeater-create> Add New Member</a>
                  </div>
                </div>

              </div>

              <div class="row mb-1 mt-4">
                <div class="col-md-12">
                  <h4 class="text-primary">Other Details</h5>
                  <hr>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 mb-1">
                  <label>Ekling Ji Description</label>
                  <textarea name="ekling_ji_description" placeholder="Enter Ekling Ji Description" class="form-control">@if(isset($edit)){{ @$edit->other_detail->ekling_ji_description }} @endif</textarea>
                </div>

                <div class="col-md-12 mb-1">
                  <label>Native Place Description</label>
                  <textarea name="native_place_description" placeholder="Enter Native Place Description" class="form-control">@if(isset($edit)){{ @$edit->other_detail->native_place_description }} @endif</textarea>
                </div>

              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>Samaj Vadi Name</label>
                  <input type="text" name="samaj_vadi_name" placeholder="Enter Samaj Vadi Name" class="form-control" @if(isset($edit)) value="{{ @$edit->other_detail->samaj_vadi_name }}" @endif >
                </div>

                <div class="col-md-6">
                  <label>Handled By</label>
                  <input type="text" name="handled_by" placeholder="Enter Handled By" class="form-control" @if(isset($edit)) value="{{ @$edit->other_detail->handled_by }}" @endif>
                </div>
              </div>

              <div class="row mb-1">
                <div class="col-md-6">
                  <label>Pic of Handled Person</label>
                  <input type="file" name="handled_profile_pic" accept="image/*" class="form-control">

                  @if(isset($edit) && @@$edit->other_detail->handled_profile_pic)
                    <img src="{{ asset('file/user/'.@$edit->other_detail->handled_profile_pic)}}" height="100" width="100" class="mt-1 mb-1">
                  @endif

                </div>
              </div>


              <div class="form-group row text-right">
                <div class="col col-sm-10 col-lg-9">
                  <button type="submit" class="btn btn-space btn-primary">{{ isset($edit) ? "Update" : "Save" }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection


@push('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
  $(document).ready(function() {
    $('body').on("submit", "#myForm", function (e) {
      e.preventDefault();
      var validator = validate_form();
      if (validator.form() != false) {
        $.ajax({
          url: "{{route('user.store')}}",
          type: "POST",
          data: new FormData($("#myForm")[0]),
          async: false,
          processData: false,
          contentType: false,
          success: function (data) {
            if (data.status) {
              toast_success(data.message)
              setTimeout(function(){
                  window.location.reload();
              },1500)
            } else {
              toast_error(data.message);
            }
          },
          error: function () {
            toast_error("Something went to wrong !");
          },
        });
      }
    });

    function validate_form(){
      var validator = $("#myForm").validate({
          errorClass: "is-invalid",
          validClass: "is-valid",
          rules: {
              name:{
                required: true,
                maxlength: 185,
              },
              father_name:{
                required: true,
                maxlength: 185,
              },
              professional:{
                required: true,
              },
              birth_date:{
                required: true,
              },
              blood_group:{
                required: true,
              },
              physical_disability:{
                required: true,
              },
              email:{
                required:true,
                maxlength: 185,
              },
              mobile_no:{
                required:true,
                digits:true,
                minlength:10,
                maxlength:10,
              },

              @if(!isset($edit))
              password:{
                required:true,
                minlength:8,
              },
              confirm_password:{
                required:true,
                minlength:8,
                equalTo : "#password"
              },
              user_profile_pic:{
                required:true,
              },
              father_profile_pic:{
                required:true,
              },
              @endif

              p_address:{
                required: true,
                maxlength: 250,
              },
              p_city:{
                required: true,
                maxlength: 250,
              },
              p_state:{
                required: true,
                maxlength: 250,
              },
              p_country:{
                required: true,
                maxlength: 250,
              },
              p_pincode:{
                required: true,
                digits:true,
                minlength:6,
                maxlength:6,
              },
              n_address:{
                // required: true,
                maxlength: 250,
              },
              n_city:{
                // required: true,
                maxlength: 250,
              },
              n_state:{
                // required: true,
                maxlength: 250,
              },
              n_country:{
                // required: true,
                maxlength: 250,
              },
              n_pincode:{
                // required: true,
                digits:true,
                minlength:6,
                maxlength:6,
              },


              ekling_ji_description:{
                maxlength: 250,
              },
              native_place_description:{
                maxlength: 250,
              },
              samaj_vadi_name:{
                maxlength: 250,
              },
              handled_by:{
                maxlength: 250,
              },

          },
          messages: {
              
              name:{
                required: "Please enter name.",
              },
              email:{
                required:"Please enter email.",
              },
              phone_number:{
                required:"Please enter phone number.",
                digits:"Please enter valid phone number.",
                minlength:"Please enter valid phone number.",
                maxlength:"Please enter valid phone number.",
              }
          },
      });

      $('.family_details_name').each(function() {
        $(this).rules('add', {
          required: true,
          maxlength:185,
          messages: {
            
          }
        });
      });

      $('.family_details_relation').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            
          }
        });
      });

      $('.family_details_birth_date').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            
          }
        });
      });

      $('.family_details_married_status').each(function() {
        $(this).rules('add', {
          required: true,
          messages: {
            
          }
        });
      });

      $('.family_details_school_name_1').each(function() {
        $(this).rules('add', {
          required: true,
          maxlength:185,
          messages: {
            
          }
        });
      });

      $('.family_details_school_name_2').each(function() {
        $(this).rules('add', {
          maxlength:185,
          messages: {
            
          }
        });
      });

      $('.family_details_b_degree_name').each(function() {
        $(this).rules('add', {
          maxlength:185,
          messages: {
            
          }
        });
      });

      $('.family_details_b_college_name').each(function() {
        $(this).rules('add', {
          maxlength:185,
          messages: {
            
          }
        });
      });

      $('.family_details_m_degree_name').each(function() {
        $(this).rules('add', {
          maxlength:185,
          messages: {
            
          }
        });
      });

      $('.family_details_m_college_name').each(function() {
        $(this).rules('add', {
          maxlength:185,
          messages: {
            
          }
        });
      });

      $('.family_details_b_degree').each(function() {
        $(this).rules('add', {
          required:true,
          messages: {
            
          }
        });
      });

      $('.family_details_m_degree').each(function() {
        $(this).rules('add', {
          required:true,
          messages: {
            
          }
        });
      });

      $('.family_details_physical_disability').each(function() {
        $(this).rules('add', {
          required:true,
          messages: {
            
          }
        });
      });

      $('.family_details_blood_group').each(function() {
        $(this).rules('add', {
          required:true,
          messages: {
            
          }
        });
      });

      return validator;
    }

    $(document).on('click', '#both_address_same', function(event) {
      //event.preventDefault();
      
      if($('#both_address_same').is(':checked')){

        $("[name='n_address']").val($("[name='p_address']").val());
        $("[name='n_address']").prop('readonly', true);

        $("[name='n_city']").val($("[name='p_city']").val());
        $("[name='n_city']").prop('readonly', true);

        $("[name='n_pincode']").val($("[name='p_pincode']").val());
        $("[name='n_pincode']").prop('readonly', true);

        $("[name='n_state']").val($("[name='p_state']").val());
        $("[name='n_state']").prop('readonly', true);

        $("[name='n_country']").val($("[name='p_country']").val());
        $("[name='n_country']").prop('readonly', true);

      }else{
        $("[name='n_address']").val("");
        $("[name='n_address']").prop('readonly', false);

        $("[name='n_city']").val("");
        $("[name='n_city']").prop('readonly', false);

        $("[name='n_pincode']").val("");
        $("[name='n_pincode']").prop('readonly', false);

        $("[name='n_state']").val("");
        $("[name='n_state']").prop('readonly', false);

        $("[name='n_country']").val("");
        $("[name='n_country']").prop('readonly', false);

      }

    });

    $(document).on('click', '.both_school_same', function(event) {
      //event.preventDefault();
      
      if($(this).is(':checked')){

        $(this).closest('.family_details_item').find(".family_details_school_name_2").val($(this).closest('.family_details_item').find(".family_details_school_name_1").val());
        $(this).closest('.family_details_item').find(".family_details_school_name_2").prop('readonly', true);
        

      }else{

        $(this).closest('.family_details_item').find(".family_details_school_name_2").val("");
        $(this).closest('.family_details_item').find(".family_details_school_name_2").prop('readonly', false);

      }

    });


    $(document).on('click', '.family_details_b_degree', function(event) {
      //event.preventDefault();
      
      if($(this).val() == 0){
        $(this).closest('.family_details_item').find(".family_details_b_college_name").prop('readonly', true);
        $(this).closest('.family_details_item').find(".family_details_b_degree_name").prop('readonly', true);
      }else{
        $(this).closest('.family_details_item').find(".family_details_b_college_name").prop('readonly', false);
        $(this).closest('.family_details_item').find(".family_details_b_degree_name").prop('readonly', false);
      }

    });

    $(document).on('click', '.family_details_m_degree', function(event) {
      //event.preventDefault();
      
      if($(this).val() == 0){
        $(this).closest('.family_details_item').find(".family_details_m_college_name").prop('readonly', true);
        $(this).closest('.family_details_item').find(".family_details_m_degree_name").prop('readonly', true);
      }else{
        $(this).closest('.family_details_item').find(".family_details_m_college_name").prop('readonly', false);
        $(this).closest('.family_details_item').find(".family_details_m_degree_name").prop('readonly', false);
      }

    });


    $('.repeater').repeater({
      initEmpty: false,
      show: function () {

        $(this).find('.family_details_b_degree[value="0"]').trigger('click'); //.prop('checked', true);
        $(this).find('.family_details_m_degree[value="0"]').trigger('click'); //.prop('checked', true);
        $(this).find('.family_details_physical_disability[value="0"]').trigger('click'); //.prop('checked', true);
        $(this).find('img').remove(); //.prop('checked', true);

        $(this).slideDown();
      },
      hide: function (deleteElement) {
        if(confirm('Are you sure you want to delete this element?')) {
            $(this).slideUp(deleteElement);
        }
      },
      ready: function (setIndexes) {
      },
      isFirstItemUndeletable: true,
    });


    @if(isset($edit))
      $('.physical_disability[value="'+{{ $edit->physical_disability }}+'"]').trigger('click');

      @if((isset($edit) && @$edit->contact_detail->both_address_same == 1)) 
        $('#both_address_same').trigger('click');
      @endif


      @foreach($edit->family_details as $key => $family)
        $('.family_details_b_degree[value="0"]').eq({{$key}}).trigger('click');
        $('.family_details_m_degree[value="0"]').eq({{$key}}).trigger('click');
        $('.family_details_physical_disability[value="0"]').eq({{$key}}).trigger('click');

        @if($family->both_school_same == 1) 
           $('.both_school_same').eq({{$key}}).trigger('click');
        @endif

      @endforeach

    @endif

   
  });
</script>
@endpush