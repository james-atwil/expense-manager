@extends('layout.admin')

@section('title')
    Main {{ ts() }} System
@endsection

@section('breadcrumb')
    <ol class="breadcrumb fw-semibold">
        <li class="breadcrumb-item"><a href="{{ route('system.index') }}">System</a></li>
        <li class="breadcrumb-item active" aria-current="page">Main</li>
    </ol>
@endsection

@section('content')

@endsection