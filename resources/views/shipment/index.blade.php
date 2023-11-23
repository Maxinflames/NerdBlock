@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Checks if there are any posts to display, if not, notifies the user -->
        @if (count($shipments) == 0)
            <p class="text-center">Currently there are no Shipments!</p>
        @endif
        <div class="form-group text-center">
            @if (Session::has('active_user'))
                @if (session()->get('user_type') == 'A')
                    <a href="/shipments/create" class="btn btn-primary">Create New Shipment</a>
                @endif
            @endif
            <!-- Searches for a post using ID of the post -->
            @if (count($shipments) != 0)
                <div class="text-end">
                    <form method="POST" action="/shipments/search">
                        {{ csrf_field() }}
                        <br>
                        <div class="content form-group">
                            @if ($selection_type == "all")
                                <input class="radio-input" id="type1" type="radio" name="shipment_outgoing"
                                    checked="true" value="all" />
                                <label class="radio-label" for="type1">All</label>
                            @else
                                <input class="radio-input" id="type1" type="radio" name="shipment_outgoing"
                                    value="all" />
                                <label class="radio-label" for="type1">All</label>
                            @endif
                            @if ($selection_type == "1")
                                <input class="radio-input" id="type2" type="radio" name="shipment_outgoing"
                                    checked="true" value="1" />
                                <label class="radio-label" for="type2">Outgoing</label>
                            @else
                                <input class="radio-input" id="type2" type="radio" name="shipment_outgoing"
                                    value="1" />
                                <label class="radio-label" for="type2">Outgoing</label>
                            @endif
                            @if ($selection_type == "0")
                                <input class="radio-input" id="type3" type="radio" name="shipment_outgoing"
                                    checked="true" value="0" />
                                <label class="radio-label" for="type3">Incoming</label><br>
                            @else
                                <input class="radio-input" id="type3" type="radio" name="shipment_outgoing"
                                    value="0" />
                                <label class="radio-label" for="type3">Incoming</label><br>
                            @endif
                        </div>

                        @if (Session::has('search_error'))
                            <label for="search_text">{{ Session::pull('search_error') }}</label>
                        @endif
                        <input class="width-30" id="search_text" name="search_text"
                            placeholder="Search for a Date, or associated Product here..." type="text" />
                        <button class="btn btn-secondary">Search</button>
                    </form>
                </div>
            @endif
        </div>
        <table class="table table-striped">
            <!-- Table column headers -->
            <tr>
                <th class="text-center">Shipment ID</th>
                <th class="text-center">Shipment Date</th>
                <th class="text-center">Shipment Destination</th>
                <th class="text-center">Shipment Type</th>
                <th colspan="2"></th>
            </tr>
            <!-- loop through database data and display for each entry -->
            @foreach ($shipments as $shipment)
                <tr>
                    <td class="text-center">{{ $shipment->shipment_id }}</td>
                    <td class="text-center">{{ $shipment->shipment_date }}</td>
                    <td class="text-center width-15">{{ $shipment->shipment_destination }}</td>
                    @if ($shipment->shipment_outgoing == true)
                        <td class="text-center">Outgoing</td>
                    @else
                        <td class="text-center">Incoming</td>
                    @endif
                    <td class="text-center width-5"><a class="btn btn-secondary"
                            href="/shipments/{{ $shipment->shipment_id }}">View</a></td>
                    @if (session()->get('user_type') == 'A')
                        <td class="text-center width-5"><a class="btn btn-secondary"
                                href="/shipments/edit/{{ $shipment->shipment_id }}">Edit</a></td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
@endsection
