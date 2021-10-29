@extends('admin.layouts.master')

@section('title','View User')

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
            <li class="breadcrumb-item active">View User
            </li>
          </ol>
        </div>

      </div>
    </div>
  </div>
</div>
        
<div class="content-body"><!-- Validation -->
  <section class="bs-validation">
    <div class="row">
      <div class="col-md-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">
              <h4>View User</h4>
            </div>
            <div class="card-toolbar">
              <a href="{{ route('user.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
          </div>

          <div class="card-body">
            
            <table class="table table-bordered ">
              <tr class="text-center">
                <th colspan="2"><h2 class="text-primary">Personal Details</h2></th>
              </tr>
              <tr>
                <th>Name</th>
                <td>{{ $data->name }}</td>
              </tr>
              <tr>
                <th>Father Name</th>
                <td>{{ $data->father_name }}</td>
              </tr>
              <tr>
                <th>Professional</th>
                <td>{{ $data->professional }}</td>
              </tr>
              <tr>
                <th>Birth Date</th>
                <td>{{ $data->birth_date }}</td>
              </tr>
              <tr>
                <th>Email</th>
                <td>{{ $data->email }}</td>
              </tr>
              <tr>
                <th>Mobile No</th>
                <td>{{ $data->mobile_no }}</td>
              </tr>
              <tr>
                <th>Physical Disability</th>
                <td>{{ $data->physical_isability == 1 ? "Yes" : "No" }}</td>
              </tr>
              <tr>
                <th>User Image</th>
                <td>
                  @if(@$data->father_profile_pic)
                    <img src="{{ asset('file/user/'.$data->user_profile_pic)}}" height="100" width="100" class="mt-1 mb-1">
                  @endif
                </td>
              </tr>
              <tr>
                <th>Father Image</th>
                <td>
                  @if(@$data->father_profile_pic)
                    <img src="{{ asset('file/user/'.$data->father_profile_pic)}}" height="100" width="100" class="mt-1 mb-1">
                  @endif
                </td>
              </tr>

              <tr class="text-center">
                <th colspan="2"><h2 class="text-primary">Contact Details</h2></th>
              </tr>
              
              <tr class="text-center">
                <th colspan="2"><h4 class="text-info">Present Address</h4></th>
              </tr>
              <tr>
                <th>Address</th>
                <td>{{ @$data->contact_detail->p_address }}</td>
              </tr>
              <tr>
                <th>City </th>
                <td>{{ @$data->contact_detail->p_city }}</td>
              </tr>
              <tr>
                <th>Pincode </th>
                <td>{{ @$data->contact_detail->p_pincode }}</td>
              </tr>
              <tr>
                <th>State </th>
                <td>{{ @$data->contact_detail->p_state }}</td>
              </tr>
              <tr>
                <th>Country </th>
                <td>{{ @$data->contact_detail->p_country }}</td>
              </tr>

              <tr class="text-center">
                <th colspan="2"><h4 class="text-info">Native Address</h4></th>
              </tr>
              <tr>
                <th>Address</th>
                <td>{{ @$data->contact_detail->n_address }}</td>
              </tr>
              <tr>
                <th>City </th>
                <td>{{ @$data->contact_detail->n_city }}</td>
              </tr>
              <tr>
                <th>Pincode </th>
                <td>{{ @$data->contact_detail->n_pincode }}</td>
              </tr>
              <tr>
                <th>State </th>
                <td>{{ @$data->contact_detail->n_state }}</td>
              </tr>
              <tr>
                <th>Country </th>
                <td>{{ @$data->contact_detail->n_country }}</td>
              </tr>

              <tr class="text-center">
                <th colspan="2"><h2 class="text-primary">Family Details</h2></th>
              </tr>

              @foreach(@$data->family_details as $key => $family)

                <tr class="text-center">
                  <th colspan="2"><h6><i>Member {{ $key + 1}}</i></h6></th>
                </tr>

                <tr>
                  <th>Name </th>
                  <td>{{ $family->name }}</td>
                </tr>
                <tr>
                  <th>Relation With User</th>
                  <td>{{ $family->relation }}</td>
                </tr>
                <tr>
                  <th>Birth Date</th>
                  <td>{{ $family->birth_date }}</td>
                </tr>
                <tr>
                  <th>Profile Pic of Person</th>
                  <td>
                    @if(@$family->profile_pic)
                      <img src="{{ asset('file/user/'.$family->profile_pic)}}" height="100" width="100" class="mt-1 mb-1">
                    @endif
                  </td>
                </tr>
                <tr>
                  <th>Blood Group</th>
                  <td>{{ $family->blood_group }}</td>
                </tr>
                <tr>
                  <th>Physical Disability</th>
                  <td>{{ $family->physical_isability == 1 ? "Yes" : "No" }}</td>
                </tr>
                <tr>
                  <th>Married Status</th>
                  <td>{{ $family->married_status }}</td>
                </tr>
                <tr>
                  <th>School Name 1 (Std 1 to 10)</th>
                  <td>{{ $family->school_name_1 }}</td>
                </tr>
                <tr>
                  <th>School Name 2 (Std 11 to 12)</th>
                  <td>{{ $family->school_name_2 }}</td>
                </tr>

                <tr class="text-center">
                  <th colspan="2"><h4 class="text-info">Degree Details</h4></th>
                </tr>

                <tr>
                  <th>Bachelor Degree</th>
                  <td>{{ $family->b_degree == 1 ? "Yes" : "No" }}</td>
                </tr>
                <tr>
                  <th>Bachelor Degree Name</th>
                  <td>{{ $family->b_degree_name ?? "-" }}</td>
                </tr>
                <tr>
                  <th>Bachelor Degree College Name</th>
                  <td>{{ $family->b_college_name ?? "-" }}</td>
                </tr>

                <tr>
                  <th>Master Degree</th>
                  <td>{{ $family->m_degree == 1 ? "Yes" : "No" }}</td>
                </tr>
                <tr>
                  <th>Master Degree Name</th>
                  <td>{{ $family->m_degree_name ?? "-" }}</td>
                </tr>
                <tr>
                  <th>Master Degree College Name</th>
                  <td>{{ $family->m_college_name ?? "-" }}</td>
                </tr>

              @endforeach

              <tr class="text-center">
                <th colspan="2"><h2 class="text-primary">Other Details</h2></th>
              </tr>

              <tr>
                <th>Ekling Ji Description</th>
                <td>{{ @$data->other_detail->ekling_ji_description }}</td>
              </tr>
              <tr>
                <th>Native Place Description</th>
                <td>{{ @$data->other_detail->native_place_description }}</td>
              </tr>
              <tr>
                <th>Samaj Vadi Name</th>
                <td>{{ @$data->other_detail->samaj_vadi_name }}</td>
              </tr>
              <tr>
                <th>Handled By</th>
                <td>{{ @$data->other_detail->handled_by }}</td>
              </tr>
              <tr>
                <th>Pic of Handled Person</th>
                <td>
                  @if(@$data->other_detail->handled_profile_pic)
                    <img src="{{ asset('file/user/'.$data->other_detail->handled_profile_pic)}}" height="100" width="100" class="mt-1 mb-1">
                  @endif
                </td>
              </tr>
            </table>

          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection


@push('css')

@endpush

@push('script')
  
@endpush
