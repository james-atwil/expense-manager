@extends('layout.admin')

@section('title', __('User Profile'))

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="{{ route('profile') }}">User Profile</a></li>
    </ol>
@endsection

@section('content')
    @component('components.loading') @endcomponent
    <t-toasts ref="toasts"></t-toasts>
    <div class="container" v-cloak>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="my-4">User Profile</h2>
                <v-form ref="mainForm" @submit="actions.submit" :validation-schema="schema" :initial-values="record">
                    <div class="card mb-3">
                        <div class="card-header">General Information</div>
                        <div class="card-body">
                            <div class="form-group row mb-3">
                                <div class="col-md-3 fw-bold col-form-label">Display Name</div>
                                <div class="col-md-9">
                                    <div class="form-control">{{ $user->name_display }}</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 fw-bold col-form-label">Email</div>
                                <div class="col-md-9">
                                    <div class="form-control">{{ $user->email }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Change Password</div>
                        <div class="card-body">
                            <t-password name="password" label="New Password" v-model="record.password">
                                <div class="text-muted small mt-1">Fill in to change the user password.</div>
                            </t-password>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-labeled btn-primary me-1">
                                <span class="btn-label"><i :class="[states.submitting ? 'fa-cog fa-spin' : 'fa-save']" class="fas fa-fw"></i></span> Save
                            </button>
                        </div>
                    </div>
                </v-form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/modules/system/users/profile.js') }}"></script>
@endsection
