@extends('layout.admin')

@section('title')
    Expenses {{ ts() }} Expenses Management
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Expenses Management</li>
        <li class="breadcrumb-item active" aria-current="page">Expenses</li>
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
                            <th class="category">Category</th>
                            <th class="">Name</th>
                            <th class="amount">Amount</th>
                            <th class="timestamp">Entry Date</th>
                            <th class="timestamp">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="states.loading">
                            <td class="text-center p-5" colspan="10">Loading data... please wait.</td>
                        </tr>
                        <tr v-if="!states.loading && result.data.length === 0">
                            <td class="text-center p-5" colspan="10">No entry yet.</td>
                        </tr>
                        <tr v-for="record in result.data" @click="actions.edit(record)" v-if="!states.loading && result.data.length > 0">
                            <td class="category">@{{ record.category.name }}</td>
                            <td class="">@{{ record.name }}</td>
                            <td class="amount">@{{ record.amount.toFixed(2) }}</td>
                            <td class="timestamp">@{{ record.entry_at }}</td>
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
                        <h5 class="modal-title" id="modal-form-title"> @{{ record.id > 0 ? 'Update' : 'Add' }} Expense</h5>
                        <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="alert alert-info">All fields are required</p>
                        <t-typeahead name="category" label="Category" v-model="record.category" :url="categoryService.url + '?q=%q%&l=0&m=1'"></t-typeahead>
                        <t-input name="name" label="Name" v-model="record.name"></t-input>
                        <t-input name="amount" label="Amount" v-model="record.amount"></t-input>
                        <t-input type="date" name="entry_at" label="Entry Date" v-model="record.entry_at"></t-input>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between w-100">
                            <div class="section-s">
                                <button type="button" class="btn btn-labeled btn-danger" v-if="record.id > 0" @click="actions.confirmDelete">
                                    <span class="btn-label"><i :class="[states.submitting ? 'fa-cog fa-spin' : 'fa-trash']" class="fas fa-fw"></i></span> Delete
                                </button>
                            </div>
                            <div class="section-e">
                                <button type="submit" class="btn btn-labeled btn-primary me-1">
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
                    <h5 class="modal-title" id="modal-form-title"> Delete Expense</h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure that you will delete the Expense named <strong>@{{ record.name }}</strong>?
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
    {!!  '<script src="' . asset('js/modules/expenses/expenses/index.js') . '"></script>' !!}
@endsection
