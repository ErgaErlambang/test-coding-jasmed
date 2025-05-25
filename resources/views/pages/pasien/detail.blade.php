@extends('layouts.master')

@section('title', $data->name)

@push('styles')
<style>
    .symbol.symbol-xl-90 .symbol-label {
        width: 300px;
        height: 200px;
    }
</style>
@endpush

@section('content')
    <div class="container">
        <div class="card card-custom gutter-b example example-compact">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">{{ $data->name }}</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="flex-row-auto" id="kt_profile_aside">
                            <div class="text-center mb-10">
                                <div class="symbol symbol-xl-90">
                                    <div class="symbol-label"
                                        style="background-image:url('{{ asset('uploads/data/'.$data->image) }}')">
                                    </div>
                                </div>
                                <h4 id="name_user" class="font-weight-bold my-2"></h4>
                                <div id="email_user" class="text-muted mb-2"></div>
                                <span class="label label-light-success label-inline font-weight-bold label-lg">
                                    Hidup
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <span>Full Name</span>
                            </div>
                            <div class="col-md-8">
                                <span>: {{ $data->name }}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <span>Email</span>
                            </div>
                            <div class="col-md-8">
                                <span>: {{ $data->email }}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <span>Date of Birth</span>
                            </div>
                            <div class="col-md-8">
                                <span>: {{ date('d F Y', strtotime($data->date_of_birth)) }}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <span>Identity</span>
                            </div>
                            <div class="col-md-8">
                                <span>: {{ $data->no_identity }}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <span>Country</span>
                            </div>
                            <div class="col-md-8">
                                <span>: {{ $data->country }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('pasien.rekam-medis-store', $data->id) }}" method="post">
                @csrf
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="form-group mb-8">
                            @include('layouts.alert')
                        </div>
                        @if(\Auth::user()->getRole()->slug == 'admin' || \Auth::user()->getRole()->slug == 'perawat')
                            <div class="form-group">
                                <label> Berat Badan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="" name="berat_badan" value="{{ $data->emr?->berat_badan }}">
                            </div>
    
                            <div class="form-group">
                                <label> Tekanan Darah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="" name="tekanan_darah" value="{{ $data->emr?->tekanan_darah }}">
                            </div>
                        @endif
                        @if(\Auth::user()->getRole()->slug == 'admin' || \Auth::user()->getRole()->slug == 'dokter')
                            <div class="form-group">
                                <label> Informasi Keluhan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="" name="keluhan" value="{{ $data->emr?->keluhan }}">
                            </div>
    
                            <div class="form-group">
                                <label> Hasil Diagnosa <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="" name="hasil_diagnosa" value="{{ $data->emr?->hasil_diagnosa }}">
                            </div>
                        @endif
                        <div class="form-group">
                            <label> Obat </label>
                            <select class="form-control select2" id="select_model" name="product_id">
                                <option></option>
                                @foreach ($obat as $item)
                                    <option value="{{ $item->id }}" {{ $data->emr?->obat?->id == $item->id ? 'selected' : '' }}> {{ $item->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary ml-auto btn-book">Save</button>
                    <a href="{{ route('pasien.index') }}" class="btn btn-info ml-auto">Back</a>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
<script>
    $('#datepicker').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        startDate: new Date(),
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }
    });

    $('#select_model').select2({
        placeholder: "Select or input option",
    });
    
</script>

@endpush
