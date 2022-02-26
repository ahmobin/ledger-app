@extends('layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <h2 class="page-title">
                {{ __('Ledger') }}
            </h2>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            @include('layouts.flash_alerts')

            <div class="alert alert-info overflow-hidden">
                <div class="alert-title float-start">Ledger Data: Customer -> <span class="text-danger"> {{ $ledger[0]->customer->name }} </span> </div>
                <button type="button" class="btn btn-sm btn-success rounder float-end" data-bs-toggle="modal" data-bs-target="#customerAdd">
                    Update Ledger
                </button>
            </div>

            <div class="card">

                <div>
                    <form action="{{ route('customers.ledger.index',$ledger[0]->customer_id) }}" method="GET" class="w-75 d-flex justify-content-between my-3">
                        <input type="text" class="form-control"  placeholder="Search by date or type..." name="search">
                        <button class="btn btn-primary ms-2">Search</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Amount') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($ledger as $item)
                            <tr>
                                <td>{{ $item->date->format('d-m-y') }}</td>
                                <td>{{ $item->type }}</td>
                                <td>{{ $item->amount }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <button type="button" class="btn btn-sm btn-success rounder float-end" data-bs-toggle="modal" data-bs-target="#customerAdd">
                                        Open Ledger
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                @if( $ledger->hasPages() )
                    <div class="card-footer pb-0">
                        {{ $ledger->links() }}
                    </div>
                @endif
            </div>


            <div class="card mt-4">
                <h2 class="text-danger">Total Due: {{ number_format($ledger[0]->balance,2) }}</h2>
            </div>
        </div>
    </div>

    <!-- Create Customer Modal -->
    <div class="modal fade" id="customerAdd" tabindex="-1" aria-labelledby="customerAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerAddLabel">Ledger Update</h5>
                </div>
                <form action="{{ route('customers.ledger.store',$ledger[0]->customer_id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="type">Type</label>
                            <select name="type" class="form-control" id="type">
                                <option selected disabled>Select an option</option>
                                <option value="Due Added">Due Add</option>
                                <option value="Due Deducted">Due Deduct</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date') }}" id="date">
                        </div>

                        <div class="form-group mb-3">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" class="form-control" placeholder="500" value="{{ old('amount') }}" id="amount">
                        </div>

                        <input type="hidden" name="customer_id" value="{{ $ledger[0]->customer_id }}">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
