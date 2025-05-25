@extends('layouts.master')

@section('title', 'Obat Management')

@push('styles')

@endpush

@section('content')
<div class="container">
    <form action="{{ route('obat.update',$data['product']->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Update {{ $data['product']->name }}`s</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group mb-8">
                    @include('layouts.alert')
                </div>
                
                <div class="form-group">
                    <label> Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="" name="name" value="{{ $data['product']->name }}">
                </div>

                <div class="form-group">
                    <label> Description </label>
                    <input type="text" class="form-control" placeholder="" name="description" value="{{ $data['product']->description }}">
                </div>

                <div class="form-group">
                    <label> Stock <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="" name="stock" value="{{ $data['product']->stock }}">
                </div>

                <div class="form-group">
                    <label> Price <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="" name="base_price" value="{{ $data['product']->base_price }}">
                </div>

                <div class="form-group">
                    <label> Category <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="select_model" name="category_id">
                        <option></option>
                        @foreach ($data['category'] as $item)
                            <option value="{{ $item->id }}" {{ $data['product']->category_id == $item->id ? 'selected' : '' }}> {{ $item->name }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="col-form-label">Enabled Product ?</label>
                    <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                        <input type="checkbox" name="is_active" {{ $data['product']->is_active == true ? 'checked' : '' }}>
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
</script>
@endpush