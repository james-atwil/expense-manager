@extends('layout.admin')

@section('title')
    Users {{ ts() }} Users Management
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Users Management</li>
        <li class="breadcrumb-item active" aria-current="page">Users</li>
    </ol>
@endsection

@section('content')
    @component('components.loading') @endcomponent

    <t-toasts ref="toasts"></t-toasts>
    <div class="container py-3" v-cloak>
        <div class="row">
            <div class="col">
                <table class="table table-data table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="name">Name</th>
                            <th class="">Email Address</th>
                            <th class="role">Role</th>
                            <th class="timestamp">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="states.loading">
                            <td class="text-center p-5" colspan="10">Loading data... please wait.</td>
                        </tr>
                        <tr v-for="record in result.data" @click="actions.edit(record)" v-if="!states.loading && result.data.length > 0">
                            <td class="name">@{{ record.name_display }}</td>
                            <td class="">@{{ record.email }}</td>
                            <td class="role">@{{ record.role.name }}</td>
                            <td class="timestamp">@{{ record.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-end">
                    <button type="button" class="btn btn-labeled btn-primary" @click="actions.addNew">
                        <span class="btn-label"><i class="fas fa-fw fa-sm fa-plus"></i></span> Add New
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-form" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-form-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <v-form ref="mainForm" @submit="actions.submit" :validation-schema="schema" :initial-values="record">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modal-form-title"> @{{ record.id > 0 ? 'Edit' : 'Add' }} User</h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <v-field name="id" v-model="record.id">
                            <input type="text" class="d-none" name="id" v-model="record.id">
                        </v-field>
                        <t-input name="name_display" label="Display Name" v-model="record.name_display" required></t-input>
                        <t-input name="email" label="Email Address" v-model="record.email" required>
                            <div class="text-muted small mt-1">This will be served as the username.</div>
                        </t-input>
                        <t-password name="password" label="Password" v-model="record.password">
                            <div class="text-muted small mt-1">Fill in to change the user password. Blank passwords won&apos;t do anything if you update.</div>
                        </t-password>
                        <t-typeahead name="role" label="Role" v-model="record.role"
                                     :url="roleService.url + '?q=%q%&l=0&m=1'"
                                     class="mb-0">
                        </t-typeahead>

                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between w-100">
                            <div class="section-s">
                                <button type="button" class="btn btn-labeled btn-danger" v-if="record.id > 0" @click="actions.confirmDelete" :disabled="record.role.id === 1002">
                                    <span class="btn-label"><i :class="[states.submitting ? 'fa-cog fa-spin' : 'fa-trash']" class="fas fa-fw"></i></span> Delete
                                </button>
                            </div>
                            <div class="section-e">
                                <button type="submit" class="btn btn-labeled btn-primary me-1" :disabled="record.role?.id === 1002">
                                    <span class="btn-label"><i :class="[states.submitting ? 'fa-cog fa-spin' : 'fa-save']" class="fas fa-fw"></i></span> @{{ record.id > 0 ? 'Update' : 'Save' }}
                                </button>
                                <button type="reset" class="btn btn-secondary btn-labeled" data-bs-dismiss="modal">
                                    <span class="btn-label"><i :class="[states.submitting ? 'fa-cog fa-spin' : 'fa-times']" class="fas fa-fw"></i></span> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </v-form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-delete-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modal-form-title"> Delete User</h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure that you will delete the User named <strong>@{{ record.name_display }}</strong>?
                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-end w-100">
                        <button type="button" class="btn btn-labeled btn-danger me-1" @click="actions.delete">
                            <span class="btn-label"><i :class="[states.submitting ? 'fa-cog fa-spin' : 'fa-exclamation-triangle']" class="fas fa-fw"></i></span> Yes
                        </button>
                        <button type="button" class="btn btn-secondary btn-labeled" data-bs-dismiss="modal">
                            <span class="btn-label"><i :class="[states.submitting ? 'fa-cog fa-spin' : 'fa-times']" class="fas fa-fw"></i></span> No
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    {!!  '<script src="' . asset('js/modules/system/users/index.js') . '"></script>' !!}
@endsection
