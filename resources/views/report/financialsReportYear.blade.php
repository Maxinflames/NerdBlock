@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="content">
            <table class="table table-striped">
                <tr>
                    <th class="text-center" colspan="7">Financials by {{ $timeframe }}</th>
                </tr>
                <tr>
                    <td class="text-center" colspan="7">Only data that is not empty will display below.</td>
                </tr>
                <tr>
                    <th class="text-center">Year</th>
                    <th class="text-center">Revenue</th>
                    <th class="text-center">Expenses</th>
                    <th class="text-center">Profit</th>
                </tr>
                @foreach ($retrieved_financial_data as $financial_data)
                    <tr>
                        <td class="text-center">{{ $financial_data->sent_package_year }}</td>
                        <td class="text-center safe">${{ number_format($financial_data->retrieved_income, 2, '.', ',') }}
                        </td>
                        <td class="text-center danger">${{ number_format($financial_data->retrieved_cost, 2, '.', ',') }}</td>
                        @if ($financial_data->retrieved_income - $financial_data->retrieved_cost < 0)
                            <td class="text-center danger">
                                $({{ number_format($financial_data->retrieved_cost - $financial_data->retrieved_income, 2, '.', ',') }})
                            </td>
                        @else
                            <td class="text-center safe">
                                ${{ number_format($financial_data->retrieved_income - $financial_data->retrieved_cost, 2, '.', ',') }}
                            </td>
                        @endif
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
