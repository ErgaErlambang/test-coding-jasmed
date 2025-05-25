@extends('layouts.master')

@section('title', 'Obat Management')

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
    <form action="{{ route('obat.store') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
        @csrf
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">New Obat</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group mb-8">
                    @include('layouts.alert')
                </div>
                
                <div class="form-group">
                    <label> Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="" name="name" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label> Description </label>
                    <input type="text" class="form-control" placeholder="" name="description" value="{{ old('description') }}">
                </div>

                <div class="form-group">
                    <label> Stock <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="" name="stock" value="{{ old('stock') }}">
                </div>

                <div class="form-group">
                    <label> Price <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="" name="base_price" value="{{ old('base_price') }}">
                </div>

                <div class="form-group">
                    <label> Category <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="select_model" name="category_id">
                        <option></option>
                        @foreach ($data['category'] as $item)
                            <option value="{{ $item->id }}"> {{ $item->name }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label">Enabled Product ?</label>
                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                        <input type="checkbox" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                        <span></span>
                    </label>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <a href="{{ route('obat.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
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