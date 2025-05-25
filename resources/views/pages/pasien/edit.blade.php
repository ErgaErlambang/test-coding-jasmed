@extends('layouts.master')

@section('title', 'Patient Management')

@push('styles')

@endpush

@section('content')
<div class="container">
    <form action="{{ route('pasien.update',$data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Update {{ $data->name }}`s Patient</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group mb-8">
                    @include('layouts.alert')
                </div>
                
                <div class="form-group">
                    <label> Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="" name="name" value="{{ $data->name }}">
                </div>

                <div class="form-group">
                    <label> Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" placeholder="" name="email" value="{{ $data->email }}">
                </div>

                <div class="form-group">
                    <label> Phone Number <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="" name="phone" value="{{ $data->phone }}">
                </div>

                <div class="form-group">
                    <label> Sex </label>
                    <select class="form-control select2" id="select_model" name="sex">
                        <option></option>
                        <option value="male" {{ $data->sex == 'male' ? 'selected' : '' }}> Male </option>
                        <option label="female" {{ $data->sex == 'female' ? 'selected' : '' }}> Female </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <div class="input-group date" >
                        <input type="text" class="form-control" readonly name="date_of_birth" value="{{ $data->sex }}" id="kt_datepicker_3"/>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label> Identification Number <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="" name="no_identity" value="{{ $data->no_identity }}">
                </div>

                <div class="form-group">
                    <label> Insurance Number</label>
                    <input type="number" class="form-control" placeholder="" name="insurance" value="{{ $data->insurance }}">
                </div>

                <div class="form-group">
                    <label> Address </label>
                    <input type="text" class="form-control" placeholder="" name="address" value="{{ $data->address }}">
                </div>

                <div class="form-group">
                    <label> City </label>
                    <input type="text" class="form-control" placeholder="" name="city" value="{{ $data->city }}">
                </div>

                <div class="form-group">
                    <label> State </label>
                    <input type="text" class="form-control" placeholder="" name="state" value="{{ $data->state }}">
                </div>

                <div class="form-group">
                    <label> Country </label>
                    <input type="text" class="form-control" placeholder="" name="country" value="{{ $data->country }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label">Enabled Patient ?</label>
                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                        <input type="checkbox" name="is_active" {{ $data->is_active ? 'checked' : '' }}>
                        <span></span>
                    </label>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/crud/file-upload/image-input.js?v=7.0.5') }}"></script>
<script>
    var arrows = {
        leftArrow: '<i class="la la-angle-left"></i>',
        rightArrow: '<i class="la la-angle-right"></i>'
    }
    $('#select_model').select2({
        placeholder: "Select or input option",
    });
    $('#kt_datepicker_3').datepicker({
        todayBtn: "linked",
        clearBtn: true,
        todayHighlight: true,
        templates: arrows,
        format: 'dd-mm-yyyy',
    });
</script>
@endpush