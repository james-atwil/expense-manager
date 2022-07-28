@extends('layout.admin')

@section('title', 'Dashboard')

@section('content')
    @component('components.loading') @endcomponent
    <div class="container py-3" v-cloak>
        <div class="row" v-if="loading">
            <div class="spinner p-5 text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div>Please wait while the system is loading the page elements...</div>
            </div>
        </div>
        <div class="row justify-content-center" v-if="!loading">
            <div class="col-md-8">
                <h2 class="my-5">My Expenses</h2>
            </div>
        </div>
        <div class="row justify-content-center" v-if="!loading">
            <div class="col-md-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th class="amount">Total</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr v-for="record in tabularData.data">
                            <td>@{{ record['name'] }}</td>
                            <td class="amount">@{{ record['amount'] }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="col-md-4">
                <apexchart type="pie" width="100%" :options="chartOptions" :series="series"></apexchart>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    {!!  '<script src="' . asset('js/modules/index/dashboard.js') . '"></script>' !!}
@endsection
