@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <table class="table table-striped">
                <tr>
                    <th class="text-center" colspan="7">Highest Rated Package</th>
                </tr>
                <tr>
                    <th class="text-center" class="text-center">Package ID</th>
                    <th class="text-center">Package Month</th>
                    <th class="text-center">Package Year</th>
                    <th class="text-center">Package Genre</th>
                    <th class="text-center"># of Ratings</th>
                    <th class="text-center">Average Rating</th>
                </tr>
                <tr>
                    <td class="text-center">{{ $highest_rated_package->package_id }}</td>
                    <td class="text-center">{{ $highest_rated_package->package_month }}</td>
                    <td class="text-center">{{ $highest_rated_package->package_year }}</td>
                    <td class="text-center">{{ $highest_rated_package->genre_title }}</td>
                    <td class="text-center">{{ $highest_rated_package->package_rating_count }}</td>
                    <td class="text-center">{{ number_format((float) $highest_rated_package->package_rating, 2, '.', '') }}
                    </td>
                    <td class="text-center width-5"><a class="btn btn-secondary"
                            href="/packages/{{ $highest_rated_package->package_id }}">View</a></td>
                </tr>
            </table>

            <br />

            <table class="table table-striped">
                <tr>
                    <th class="text-center" colspan="7">Lowest Rated Package</th>
                </tr>
                <tr>
                    <th class="text-center" class="text-center">Package ID</th>
                    <th class="text-center">Package Month</th>
                    <th class="text-center">Package Year</th>
                    <th class="text-center">Package Genre</th>
                    <th class="text-center"># of Ratings</th>
                    <th class="text-center">Average Rating</th>
                </tr>
                <tr>
                    <td class="text-center">{{ $lowest_rated_package->package_id }}</td>
                    <td class="text-center">{{ $lowest_rated_package->package_month }}</td>
                    <td class="text-center">{{ $lowest_rated_package->package_year }}</td>
                    <td class="text-center">{{ $lowest_rated_package->genre_title }}</td>
                    <td class="text-center">{{ $lowest_rated_package->package_rating_count }}</td>
                    <td class="text-center">{{ number_format((float) $lowest_rated_package->package_rating, 2, '.', '') }}
                    </td>
                    <td class="text-center width-5"><a class="btn btn-secondary"
                            href="/packages/{{ $lowest_rated_package->package_id }}">View</a></td>
                </tr>
            </table>

            <br />

            <table class="table table-striped">
                <tr>
                    <th class="text-center">Unrated Sent Packages</th>
                    <th class="text-center">Percentage of Sent Packages Rated</th>
                    <th class="text-center">Total Sent Packages</th>
                </tr>
                <tr>
                    <td class="text-center">{{ $unrated_package_count->package_unrated_count }}</td>
                    <td class="text-center">
                        {{ (($total_sent_packages->total_sent_packages - $unrated_package_count->package_unrated_count) /
                            $total_sent_packages->total_sent_packages) * 100 }}%
                    </td>
                    <td class="text-center">{{ $total_sent_packages->total_sent_packages }}</td>
                </tr>
            </table>

            <br />

            <table class="table table-striped">
                <tr>
                    <th class="text-center" colspan="6">Sent Package Count by Genre
                    </th>
                </tr>
                <tr>
                    <th class="text-center">Genre ID</th>
                    <th class="text-center">Genre Title</th>
                    @if (!is_null($sent_packages_by_genre[0]->sent_package_year))
                        <th class="text-center">Year</th>
                    @endif
                    @if (!is_null($sent_packages_by_genre[0]->sent_package_month))
                        <th class="text-center">Month</th>
                    @endif
                    @if (!is_null($sent_packages_by_genre[0]->sent_package_day))
                        <th class="text-center">Day</th>
                    @endif
                    <th class="text-center">Sent Packages</th>
                </tr>
                @foreach ($sent_packages_by_genre as $sent_package_genre)
                    <tr>
                        <td class="text-center">{{ $sent_package_genre->genre_id }}</td>
                        <td class="text-center">{{ $sent_package_genre->genre_title }}</td>
                        @if (!is_null($sent_package_genre->sent_package_year))
                            <td class="text-center">{{ $sent_package_genre->sent_package_year }}</td>
                        @endif
                        @if (!is_null($sent_package_genre->sent_package_month))
                            <td class="text-center">{{ $sent_package_genre->sent_package_month }}</td>
                        @endif
                        @if (!is_null($sent_package_genre->sent_package_day))
                            <td class="text-center">{{ $sent_package_genre->sent_package_day }}</td>
                        @endif
                        <td class="text-center">{{ $sent_package_genre->sent_packages_by_genre }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
