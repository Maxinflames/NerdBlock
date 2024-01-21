@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="center">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Shipping Report </h1>
                </div>

                <div class="panel-body">
                    <div class="content">
                        <div class="panel-heading">
                            <h3>List of Shipments for '{{ $startDate }}' to '{{ $endDate }}'</h3>
                        </div>
                        @if (!$shipped_items->isEmpty())
                            <table class="table table-striped">
                                <tr>
                                    <th class="text-center">Shipment Id</th>
                                    <th class="text-center">Shipment Date</th>
                                    <th class="text-center">Shipment Destination</th>
                                    <th class="text-center">Shipment Type</th>
                                    <th class="text-center">Product Id</th>
                                    <th class="text-center">Genre Title</th>
                                    <th class="text-center">Unit Quantity</th>
                                    <th class="text-center">Unit Cost</th>
                                    <th class="text-center">Manufacturer</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">License</th>
                                </tr>
                                @php($current_shipment = 0)
                                @foreach ($shipped_items as $shipped_item)
                                    @if ($shipped_item->shipment_id != $current_shipment)
                                        @php($current_shipment = $shipped_item->shipment_id)
                                        <tr>
                                            <td>{{ $shipped_item->shipment_id }}</td>
                                            <td>{{ $shipped_item->shipment_date }}</td>
                                            <td>{{ $shipped_item->shipment_destination }}</td>
                                            @if ($shipped_item->shipment_outgoing == 1)
                                                <td>Outgoing</td>
                                            @else
                                                <td>Incoming</td>
                                            @endif
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="text-center" colspan="4"></td>
                                        <td class="text-center">{{ $shipped_item->product_id }}</td>
                                        <td class="text-center">{{ $shipped_item->genre_title }}</td>
                                        <td class="text-center">{{ $shipped_item->shipment_item_quantity }}
                                        </td>
                                        <td class="text-center">{{ $shipped_item->shipment_item_unit_cost }}</td>
                                        <td class="text-center">{{ $shipped_item->product_manufacturer }}</td>
                                        <td class="text-center">{{ $shipped_item->product_brand }}</td>
                                        <td class="text-center">{{ $shipped_item->product_license }}</td>
                                        <td class="text-center"><a class="btn btn-secondary"
                                                href="/products/{{ $shipped_item->product_id }}">View</a></td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="center">
                                No Shipments in this timespan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
