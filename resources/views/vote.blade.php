@extends('layouts.app')

@section('content')
    <vote/>
@push('scripts')
    <script src="{{ asset('js/vote.js') }}"></script>
@endpush
@endsection
