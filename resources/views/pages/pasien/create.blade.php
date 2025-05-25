@extends('layouts.master')

@section('title', 'Patient Management')

@push('styles')
<style>
    .image-input .image-input-wrapper {
        width: 240px;
        height: 212px;
        border-radius: 0.42rem;
        background-repeat: no-repeat;
        background-size: cover;
    }
    </style>
@endpush

@section('content')
<div class="container">
    <form action="{{ route('pasien.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">New Patient</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group mb-8">
                    @include('layouts.alert')
                </div>
                
                <div class="form-group">
                    <label> Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="" name="name" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label> Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" placeholder="" name="email" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label> Phone Number <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="" name="phone" value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label> Sex </label>
                    <select class="form-control select2" id="select_model" name="sex">
                        <option></option>
                        <option value="male"> Male </option>
                        <option label="female"> Female </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <div class="input-group date" >
                        <input type="text" class="form-control" readonly name="date_of_birth" value="" id="kt_datepicker_3"/>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="la la-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label> Identification Number <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="" name="no_identity" value="{{ old('no_identity') }}">
                </div>

                <div class="form-group">
                    <label> Insurance Number</label>
                    <input type="number" class="form-control" placeholder="" name="insurance" value="{{ old('insurance') }}">
                </div>

                <div class="form-group">
                    <label> Address </label>
                    <input type="text" class="form-control" placeholder="" name="address" value="{{ old('address') }}">
                </div>

                <div class="form-group">
                    <label> City </label>
                    <input type="text" class="form-control" placeholder="" name="city" value="{{ old('city') }}">
                </div>

                <div class="form-group">
                    <label> State </label>
                    <input type="text" class="form-control" placeholder="" name="state" value="{{ old('state') }}">
                </div>

                <div class="form-group">
                    <label> Country </label>
                    <input type="text" class="form-control" placeholder="" name="country" value="{{ old('country') }}">
                </div>

                <div class="form-group">
                    <label class="col-form-label">Enabled Patient ?</label>
                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                        <input type="checkbox" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
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