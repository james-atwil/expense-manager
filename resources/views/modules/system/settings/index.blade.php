@extends('layout.admin')

@section('title')
   Settings {{ ts() }} System
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('system.index') }}">System</a></li>
        <li class="breadcrumb-item active" aria-current="page">Settings</li>
    </ol>
@endsection

@section('content')
    @component('components.loading') @endcomponent
    <t-toasts ref="toasts"></t-toasts>
    <div class="content" v-cloak>
        <v-form id="form-block" class="my-3 position-relative" v-slot="{ handleSubmit }" :validation-schema="schema" >
            <form @submit="handleSubmit($event, saveSettings)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-3">
                            <div class="card mb-3 form-menu">
                                <div class="card-header p-3"><h2 class="h6 m-0">Sections</h2></div>
                                <div id="fmi" class="list-group list-group-flush">
                                    <a class="list-group-item list-group-item-action" href="#g-front" @click="scrollIntoView">Frontend</a>
                                    <a class="list-group-item list-group-item-action" href="#g-admin" @click="scrollIntoView">Admin Portal</a>
                                    <a class="list-group-item list-group-item-action" href="#g-profile" @click="scrollIntoView">Organization Profile</a>
                                    <a class="list-group-item list-group-item-action" href="#g-notify" @click="scrollIntoView">Notifications</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div id="g-front" class="card card-fieldset">
                                <div class="card-header"><h2 class="h6 m-0">Frontend</h2></div>
                                <div class="card-body">
                                    <t-input name="site-meta-name" label="Site Name" v-model="settings['site.meta.name']" required>
                                        <div class="text-muted small mt-1">The name of the website. Keep it simple and short.</div>
                                    </t-input>
                                    <t-input name="site-meta-title" label="Site Title" v-model="settings['site.meta.title']" required>
                                        <div class="text-muted small mt-1">The name of the website which will appear in the title bar of the browser.
                                            Usually, it is the same as the Site Name.</div>
                                    </t-input>
                                    <t-textarea name="site-meta-description" label="Site Description" v-model="settings['site.meta.description']" class="mb-3">
                                        <div class="text-muted small mt-1">Describe the website which will appear on the search results.</div>
                                    </t-textarea>
                                    <t-input name="site-meta-separator" label="Title Separator" v-model="settings['site.meta.separator']">
                                        <div class="text-muted small mt-1">A character or string to indicate the separation of the titles which
                                            will appear in the title bar of the browser.</div>
                                    </t-input>
                                    <t-input name="admin-ipp" label="Records Per Page" v-model="settings['site.ipp']">
                                        <div class="text-muted small mt-1">Number of records per page in a given result.</div>
                                    </t-input>
                                </div>
                                <div class="card-footer text-end">
                                    <t-button type="submit" :spinning="submitting">Submit</t-button>
                                </div>
                            </div>
                            <div id="g-admin" class="card card-fieldset">
                                <div class="card-header"><h2 class="h6 m-0">Admin Portal</h2></div>
                                <div class="card-body">
                                    <t-input name="admin-meta-name" label="Web App Name" v-model="settings['admin.meta.name']" required>
                                        <div class="text-muted small mt-1">The name of the web application. Keep it simple and short.</div>
                                    </t-input>
                                    <t-input name="admin-meta-title" label="Web App Title" v-model="settings['admin.meta.title']" required>
                                        <div class="text-muted small mt-1">The name of the web application that will appear in the title bar of the browser.</div>
                                    </t-input>
                                    <t-textarea name="admin-meta-description" label="Web App Description" v-model="settings['admin.meta.description']" class="mb-3">
                                        <div class="text-muted small mt-1">Describe the web application.</div>
                                    </t-textarea>
                                    <t-input name="admin-meta-separator" label="Title Separator" v-model="settings['admin.meta.separator']">
                                        <div class="text-muted small mt-1">A character or string to indicate the separation of the titles which
                                            will appear in the title bar of the browser.</div>
                                    </t-input>
                                    <t-input name="admin-ipp" label="Records Per Page" v-model="settings['admin.ipp']">
                                        <div class="text-muted small mt-1">Number of records per page in a given result.</div>
                                    </t-input>
                                </div>
                                <div class="card-footer text-end">
                                    <t-button type="submit" :spinning="submitting">Submit</t-button>
                                </div>
                            </div>
                            <div id="g-profile" class="card card-fieldset">
                                <div class="card-header"><h2 class="h6 m-0">Organization Profile</h2></div>
                                <div class="card-body">
                                    <p class="alert alert-info"><strong>Note:</strong> The values may or may not appear in the frontend and in the printouts.</p>
                                    <t-input name="profile-name" label="Organization Name" v-model="settings['profile.name']" required>
                                        <div class="text-muted small mt-1">The name of the organization.</div>
                                    </t-input>
                                    <t-textarea name="profile-address" label="Mailing Address" v-model="settings['profile.address']" class="mb-3">
                                        <div class="text-muted small mt-1">The address of the organization.</div>
                                    </t-textarea>
                                    <t-input name="profile-phone-land" label="Landline Phone No." v-model="settings['profile.phone.landline']">
                                        <div class="text-muted small mt-1">The main telephone number of the organization.</div>
                                    </t-input>
                                    <t-input name="profile-phone-mobile" label="Mobile Phone No." v-model="settings['profile.phone.mobile']">
                                        <div class="text-muted small mt-1">The main mobile number of the organization.</div>
                                    </t-input>
                                    <t-input name="profile-email" label="Email Address" v-model="settings['profile.email']">
                                        <div class="text-muted small mt-1">The email address of the organization. For notification, please use the Notifications
                                            Section instead.</div>
                                    </t-input>
                                    <t-input name="profile-website" label="Web Site" v-model="settings['profile.website']">
                                        <div class="text-muted small mt-1">The website of the organization.</div>
                                    </t-input>
                                </div>
                                <div class="card-footer text-end">
                                    <t-button type="submit" :spinning="submitting">Submit</t-button>
                                </div>
                            </div>
                            <div id="g-notify" class="card card-fieldset">
                                <div class="card-header"><h2 class="h6 m-0">Notifications</h2></div>
                                <div class="card-body">
                                    <t-input name="notify-from" label="Email From" v-model="settings['notify.from']">
                                        <div class="text-muted small mt-1">Usually it is used as the name of the Web Application.</div>
                                    </t-input>
                                    <t-input name="notify-email" label="Email Address" v-model="settings['notify.email']">
                                        <div class="text-muted small mt-1">For frontend and printout use, please use the Organization
                                            Profile Section instead.</div>
                                    </t-input>
                                </div>
                                <div class="card-footer text-end">
                                    <t-button type="submit" :spinning="submitting">Submit</t-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </v-form>
    </div>
@endsection

@section('javascript')
    @if(session()->has('message'))
        <script>window.bbxca.message = @json(session('message'))</script>
    @endif
    {!!  '<script src="' . asset('js/modules/system/settings/index.js') . '"></script>' !!}
@endsection
