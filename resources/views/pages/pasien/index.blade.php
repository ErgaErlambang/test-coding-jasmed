@extends('layouts.master')

@section('title', 'Patient Management')

@push('styles')
<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.5')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="container">
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Patient Management</h3>
            </div>
            <div class="card-toolbar">
                <div class="dropdown dropdown-inline mr-2">
                    @if(\Auth::user()->getRole()->slug == 'admin' || \Auth::user()->getRole()->slug == 'registrasi')
                        <a href="{{ route('pasien.create') }}" class="btn btn-primary font-weight-bolder"><i class="la la-plus"></i>New Record</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body">
            @include('layouts.alert')
            <table class="table table-separate table-head-custom" id="kt_datatable_2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Identity</th>
                        <th>Registered At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@include('layouts.modal')
@endsection

@push('scripts')
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.5')}}"></script>
<script>
    $(document).ready(function() {
        $('#kt_datatable_2').DataTable({
            responsive: true,
            lengthMenu: [5, 10, 25, 50],
            processing: true,
            serverSide: true,
            ajax: "{{ route('pasien.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false}, // Kolom Nomor
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'no_identity', name: 'Identity'},
                {data: 'registered_at', name: 'Registered At'},
                {
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false
                },
            ]
        });
    });
</script>
<script>
    function showModalConfirm(formClass) {
        var $form = $('.' + formClass);
        $('#confirm').modal({
            backdrop: 'static',
            keyboard: false
        }).off('click', '#delete-btn').on('click', '#delete-btn', function () {
            $form.submit();
        });
    }
</script>
@endpush