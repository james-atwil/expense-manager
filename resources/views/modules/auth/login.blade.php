@extends('layout.login')

@section('content')
<div id="module" class="box-login bg-white border-left p-3 text-center">
    <v-form id="login" class="w-100" v-slot="{ handleSubmit }" :validation-schema="schema" as="div">
        <form @submit="handleSubmit($event, submit)" class="mt-5">
            <img src="{{ url('images/logo.svg') }}" width="96" height="96" class="mb-3">
            <h1 class="mt-0 mb-3 text-center h2">{{ settings('admin.meta.name') }}</h1>
            <div class="p-5 text-center bg-light" v-if="false">
                <img class="mb-3" src="{{ asset('/images/spinner-1.svg') }}" width="220" height="10">
                <div>Loading... please wait.</div>
            </div>
            <div v-cloak>
                <div class="alert alert-danger mb-3 text-left py-2" :style="{ display: success ? 'none': 'block'}" :class="{ 'fade-out': !invalid }">{{ __('Invalid username or password.') }}</div>
                <div class="alert alert-success mb-3 text-left py-2" v-if="success">{{ __('Login successful. Redirecting...') }}</div>
                <v-field v-slot="{ field, meta }" id="username" name="username" type="text" v-model="login.username">
                    <label for="username" class="sr-only">{{ __('Email Address') }}</label>
                    <input type="text" class="form-control text-center" placeholder="{{ __('Email Address') }}" autofocus
                           v-bind="field" :class="{ 'is-valid': meta.touched && meta.valid, 'is-invalid': meta.touched && !meta.valid }">
                </v-field>
                <v-field v-slot="{ field, meta }" id="password" name="password" type="password" v-model="login.password">
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input type="password" class="form-control text-center" placeholder="{{ __('Password') }}"
                           v-bind="field" :class="{ 'is-valid': meta.touched && meta.valid, 'is-invalid': meta.touched && !meta.valid }">
                </v-field>
                <div class="form-check form-check-inline mt-2">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember" value="1">
                    <label class="form-check-label" for="remember">{{ __('Remember me') }}</label>
                </div>

                <p class="d-grid mb-3 mt-3">
                    <button class="btn btn-lg btn-primary" type="submit">{{ __('Sign in') }}</button>
                </p>

                <?php if (false) : ?>
                <hr>
                <p class="mb-3 mt-3">
                    <a class="btn btn-lg btn-primary btn-block" href="{{ route('oauth.microsoft.redirect') }}">{{ __('Sign in via Office 365') }}</a>
                </p>
                <?php endif; ?>
            </div>
        </form>
    </v-form>
</div>
@endsection

@section('javascript')
    <script src="{{ asset('/js/modules/auth/login.js') }}"></script>
@endsection
