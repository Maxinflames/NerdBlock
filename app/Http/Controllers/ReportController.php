<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\subscription;
use App\shipment;
use App\package;
use App\product;
use Session;

use Illuminate\Support\Str;
use Carbon\Carbon;

class ReportController extends Controller
{
    //
    public function index()
    {
        if (Session::has('active_user')) {
            if (session()->get('user_type') == 'A') {
                return view('report.index');
            }
        }
        return redirect('/');
    }

    public function financials()
    {
        if (Session::has('active_user')) {
            if (session()->get('user_type') == 'A') {
                return view('report.financials');
            }
        }
        return redirect('/');
    }

    public function generate_financial_report()
    {
        $timeframe = request('timeframe');
        $startDate = request('package_start_date');
        $set_count = request('set_count');

        $date_array = [];

        $this->validate(request(), [
            'package_start_date' => ['regex:/^([0-9]{4})$|^([0-9]{4}-[0-9]{2})$|^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
            'set_count' => 'required|numeric|min:1',
        ]);

        if (Str::length($startDate) == 4) {
            $startDate = $startDate . "-01";
            $startDate = Carbon::parse($startDate)->startOfYear()->toDateString();
        } else if (Str::length($startDate) == 7) {
            $startDate = Carbon::parse($startDate)->startOfMonth()->toDateString();
        } else {
            $startDate = Carbon::parse($startDate)->toDateString();
        }

        $startYear = Carbon::parse($startDate)->year;

        if ($timeframe == 'Week') {
            session()->put('entry_error', 'Not implemented yet... Sorry!');
        } else if ($timeframe == 'Month') {
            $endDate = Carbon::parse($startDate)->addMonths($set_count)->toDateString();

            $retrieved_financial_data = package::select([
                db::raw('sum(subscription.subscription_cost) as retrieved_income'),
                db::raw('sum(shipment_item.shipment_item_unit_cost * shipment_item.shipment_item_quantity) as retrieved_cost'),
                db::raw('YEAR(sent_package.sent_package_date) as sent_package_year'),
                db::raw('MONTH(sent_package.sent_package_date) as sent_package_month')
            ])
                ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->join('packaged_item', 'package.package_id', '=', 'packaged_item.package_id')
                ->join('product', 'packaged_item.product_id', '=', 'product.product_id')
                ->join('shipment_item', 'product.product_id', '=', 'shipment_item.product_id')
                ->whereRaw('sent_package.sent_package_date >= ?', $startDate)
                ->whereRaw('sent_package.sent_package_date <= ?', $endDate)
                ->groupBy(['sent_package_year', 'sent_package_month'])
                ->get();

            return view('report.financialsReportMonth', compact('retrieved_financial_data', 'timeframe', 'set_count', 'startYear'));
        } else if ($timeframe == 'Quarter') {
            $endDate = Carbon::parse($startDate)->addQuarters($set_count)->toDateString();

            $retrieved_financial_data = package::select([
                db::raw('sum(subscription.subscription_cost) as retrieved_income'),
                db::raw('sum(shipment_item.shipment_item_unit_cost * shipment_item.shipment_item_quantity) as retrieved_cost'),
                db::raw('YEAR(sent_package.sent_package_date) as sent_package_year'),
                db::raw('QUARTER(sent_package.sent_package_date) as sent_package_quarter')
            ])
                ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->join('packaged_item', 'package.package_id', '=', 'packaged_item.package_id')
                ->join('product', 'packaged_item.product_id', '=', 'product.product_id')
                ->join('shipment_item', 'product.product_id', '=', 'shipment_item.product_id')
                ->whereRaw('sent_package.sent_package_date >= ?', $startDate)
                ->whereRaw('sent_package.sent_package_date <= ?', $endDate)
                ->groupBy(['sent_package_year', 'sent_package_quarter'])
                ->get();

            return view('report.financialsReportQuarter', compact('retrieved_financial_data', 'timeframe', 'set_count', 'startYear'));
        } else {
            $endDate = Carbon::parse($startDate)->addYears($set_count)->toDateString();

            $retrieved_financial_data = package::select([
                db::raw('sum(subscription.subscription_cost) as retrieved_income'),
                db::raw('sum(shipment_item.shipment_item_unit_cost * shipment_item.shipment_item_quantity) as retrieved_cost'),
                db::raw('YEAR(sent_package.sent_package_date) as sent_package_year')
            ])
                ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->join('packaged_item', 'package.package_id', '=', 'packaged_item.package_id')
                ->join('product', 'packaged_item.product_id', '=', 'product.product_id')
                ->join('shipment_item', 'product.product_id', '=', 'shipment_item.product_id')
                ->whereRaw('sent_package.sent_package_date >= ?', $startDate)
                ->whereRaw('sent_package.sent_package_date <= ?', $endDate)
                ->groupBy(['sent_package_year'])
                ->get();

            return view('report.financialsReportYear', compact('retrieved_financial_data', 'timeframe', 'set_count', 'startYear'));
        }

        return redirect('/reports/financials');
    }

    public function shipping()
    {
        if (Session::has('active_user')) {
            if (session()->get('user_type') == 'A') {
                return view('report.shipping');
            }
        }
        return redirect('/');
    }

    public function generate_shipping_report()
    {
        $this->validate(request(), [
            'shipment_start_date' => ['regex:/^([0-9]{4}-[0-9]{2})$|^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
            'shipment_end_date' => ['regex:/^([0-9]{4}-[0-9]{2})$|^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
        ]);

        $outgoing = request('shipment_outgoing');
        $startDate = request('shipment_start_date');
        $endDate = request('shipment_end_date');
        try {
            $startDate = Carbon::parse($startDate)->toDateString();
            $endDate = Carbon::parse($endDate)->toDateString();
            if ($outgoing == 'all') {
                $shipped_items = shipment::select([
                    'shipment.*',
                    'product.product_id',
                    'product.genre_id',
                    'shipment_item.shipment_item_quantity',
                    'shipment_item.shipment_item_unit_cost',
                    'genre.genre_title',
                    'product.product_title',
                    'product.product_manufacturer',
                    'product.product_brand',
                    'product.product_license'
                ])
                    ->join('shipment_item', 'shipment.shipment_id', '=', 'shipment_item.shipment_id')
                    ->join('product', 'shipment_item.product_id', '=', 'product.product_id')
                    ->join('genre', 'product.genre_id', '=', 'genre.genre_id')
                    ->where('shipment.shipment_date', '>=', $startDate)
                    ->where('shipment.shipment_date', '<=', $endDate)
                    ->orderBy('shipment.shipment_date', 'desc')
                    ->orderBy('shipment.shipment_id', 'desc')
                    ->get();
            } else {
                $shipped_items = shipment::select([
                    'shipment.*',
                    'product.product_id',
                    'product.genre_id',
                    'shipment_item.shipment_item_quantity',
                    'shipment_item.shipment_item_unit_cost',
                    'genre.genre_title',
                    'product.product_title',
                    'product.product_manufacturer',
                    'product.product_brand',
                    'product.product_license'
                ])
                    ->join('shipment_item', 'shipment.shipment_id', '=', 'shipment_item.shipment_id')
                    ->join('product', 'shipment_item.product_id', '=', 'product.product_id')
                    ->join('genre', 'product.genre_id', '=', 'genre.genre_id')
                    ->where('shipment.shipment_outgoing', '=', $outgoing)
                    ->where('shipment.shipment_date', '>=', $startDate)
                    ->where('shipment.shipment_date', '<=', $endDate)
                    ->orderBy('shipment.shipment_date', 'desc')
                    ->orderBy('shipment.shipment_id', 'desc')
                    ->get();
            }


            return view('report.shippingReport', compact('shipped_items', 'startDate', 'endDate'));
        } catch (\Exception $e) {
            session()->put('entry_error', 'Invalid Date Entered!');
        }
        return redirect('/reports/shipping');
    }

    public function packages()
    {
        if (Session::has('active_user')) {
            if (session()->get('user_type') == 'A') {
                return view('report.package');
            }
        }
        return redirect('/');
    }

    public function generate_package_report()
    {
        $timeframe = request('timeframe');
        $startDate = request('package_start_date');
        $endDate = request('package_end_date');

        if ($timeframe == "Yearly") {
            $this->validate(request(), [
                'package_start_date' => ['regex:/^([0-9]{4})$|^([0-9]{4}-[0-9]{2})$|^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
                'package_end_date' => ['regex:/^([0-9]{4})$|^([0-9]{4}-[0-9]{2})$|^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
            ]);
            if (Str::length($startDate) == 4) {
                $startDate = $startDate . "-01";
            }
            if (Str::length($endDate) == 4) {
                $endDate = $endDate . "-12";
            }

            try {
                $startDate = Carbon::parse($startDate)->startOfYear()->toDateString();
                $endDate = Carbon::parse($endDate)->endOfYear()->toDateString();

                $highest_rated_package = package::select([
                    'package.*',
                    'genre.genre_title',
                    db::raw('count(sent_package.sent_package_rating) as package_rating_count'),
                    db::raw('avg(sent_package.sent_package_rating) as package_rating')
                ])
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->whereNotNull('sent_package.sent_package_rating')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->groupBy('package.package_id')
                    ->orderBy('package_rating', 'desc')
                    ->first();

                $lowest_rated_package = package::select([
                    'package.*',
                    'genre.genre_title',
                    db::raw('count(sent_package.sent_package_rating) as package_rating_count'),
                    db::raw('avg(sent_package.sent_package_rating) as package_rating')
                ])
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->whereNotNull('sent_package.sent_package_rating')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->groupBy('package.package_id')
                    ->orderBy('package_rating', 'asc')
                    ->first();

                $unrated_package_count = package::select(db::raw('count(IFNULL(sent_package.sent_package_rating, 1)) as package_unrated_count'))
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->whereNull('sent_package.sent_package_rating')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->first();

                $total_sent_packages = package::select(db::raw('count(sent_package.sent_package_id) as total_sent_packages'))
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->first();

                $sent_packages_by_genre = package::select([
                    'genre.genre_id',
                    'genre.genre_title',
                    db::raw('count(sent_package.sent_package_id) as sent_packages_by_genre'),
                    db::raw('YEAR(sent_package.sent_package_date) as sent_package_year')
                ])
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->groupBy(['subscription.genre_id', 'sent_package_year'])
                    ->orderBy('sent_package_year', 'desc')
                    ->get();

                return view('report.packageReport', compact('highest_rated_package', 'lowest_rated_package', 'unrated_package_count', 'total_sent_packages', 'sent_packages_by_genre'));
            } catch (\Exception $e) {
                session()->put('entry_error', 'Invalid Date Entered!');
            }
        } else if ($timeframe == "Monthly") {
            $this->validate(request(), [
                'package_start_date' => ['regex:/^([0-9]{4}-[0-9]{2})$|^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
                'package_end_date' => ['regex:/^([0-9]{4}-[0-9]{2})$|^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
            ]);

            try {
                $startDate = Carbon::parse($startDate)->startOfMonth()->toDateString();
                $endDate = Carbon::parse($endDate)->endOfMonth()->toDateString();

                $highest_rated_package = package::select([
                    'package.*',
                    'genre.genre_title',
                    db::raw('count(sent_package.sent_package_rating) as package_rating_count'),
                    db::raw('avg(sent_package.sent_package_rating) as package_rating')
                ])
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->whereNotNull('sent_package.sent_package_rating')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->groupBy('package.package_id')
                    ->orderBy('package_rating', 'desc')
                    ->first();

                $lowest_rated_package = package::select([
                    'package.*',
                    'genre.genre_title',
                    db::raw('count(sent_package.sent_package_rating) as package_rating_count'),
                    db::raw('avg(sent_package.sent_package_rating) as package_rating')
                ])
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->whereNotNull('sent_package.sent_package_rating')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->groupBy('package.package_id')
                    ->orderBy('package_rating', 'asc')
                    ->first();

                $unrated_package_count = package::select(db::raw('count(IFNULL(sent_package.sent_package_rating, 1)) as package_unrated_count'))
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->whereNull('sent_package.sent_package_rating')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->first();

                $total_sent_packages = package::select(db::raw('count(sent_package.sent_package_id) as total_sent_packages'))
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->first();

                $sent_packages_by_genre = package::select([
                    'genre.genre_id',
                    'genre.genre_title',
                    db::raw('count(sent_package.sent_package_id) as sent_packages_by_genre'),
                    db::raw('YEAR(sent_package.sent_package_date) as sent_package_year'),
                    db::raw('MONTH(sent_package.sent_package_date) as sent_package_month')
                ])
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->groupBy(['subscription.genre_id', 'sent_package_year', 'sent_package_month'])
                    ->orderBy('sent_package_year', 'desc')
                    ->orderBy('sent_package_month', 'desc')
                    ->get();

                return view('report.packageReport', compact('highest_rated_package', 'lowest_rated_package', 'unrated_package_count', 'total_sent_packages', 'sent_packages_by_genre'));
            } catch (\Exception $e) {
                session()->put('entry_error', 'Invalid Date Entered!');
            }

        } else if ($timeframe == "Daily") {
            $this->validate(request(), [
                'package_start_date' => ['regex:/^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
                'package_end_date' => ['regex:/^([0-9]{4}-[0-9]{2}-[0-9]{2})$/'],
            ]);
            try {
                $startDate = Carbon::parse($startDate)->toDateString();
                $endDate = Carbon::parse($endDate)->toDateString();

                $highest_rated_package = package::select([
                    'package.*',
                    'genre.genre_title',
                    db::raw('count(sent_package.sent_package_rating) as package_rating_count'),
                    db::raw('avg(sent_package.sent_package_rating) as package_rating')
                ])
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->whereNotNull('sent_package.sent_package_rating')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->groupBy('package.package_id')
                    ->orderBy('package_rating', 'desc')
                    ->first();

                $lowest_rated_package = package::select([
                    'package.*',
                    'genre.genre_title',
                    db::raw('count(sent_package.sent_package_rating) as package_rating_count'),
                    db::raw('avg(sent_package.sent_package_rating) as package_rating')
                ])
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->whereNotNull('sent_package.sent_package_rating')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->groupBy('package.package_id')
                    ->orderBy('package_rating', 'asc')
                    ->first();

                $unrated_package_count = package::select(db::raw('count(IFNULL(sent_package.sent_package_rating, 1)) as package_unrated_count'))
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->whereNull('sent_package.sent_package_rating')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->first();

                $total_sent_packages = package::select(db::raw('count(sent_package.sent_package_id) as total_sent_packages'))
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->first();

                $sent_packages_by_genre = package::select([
                    'genre.genre_id',
                    'genre.genre_title',
                    db::raw('count(sent_package.sent_package_id) as sent_packages_by_genre'),
                    db::raw('YEAR(sent_package.sent_package_date) as sent_package_year'),
                    db::raw('MONTH(sent_package.sent_package_date) as sent_package_month'),
                    db::raw('DAY(sent_package.sent_package_date) as sent_package_day')
                ])
                    ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                    ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->where('sent_package.sent_package_date', '>=', $startDate)
                    ->where('sent_package.sent_package_date', '<=', $endDate)
                    ->groupBy(['subscription.genre_id', 'sent_package_year', 'sent_package_month', 'sent_package_day'])
                    ->orderBy('sent_package_year', 'desc')
                    ->orderBy('sent_package_month', 'desc')
                    ->orderBy('sent_package_day', 'desc')
                    ->get();

                return view('report.packageReport', compact('highest_rated_package', 'lowest_rated_package', 'unrated_package_count', 'total_sent_packages', 'sent_packages_by_genre'));
            } catch (\Exception $e) {
                session()->put('entry_error', 'Invalid Date Entered!');
            }
        } else {
            $highest_rated_package = package::select([
                'package.*',
                'genre.genre_title',
                db::raw('count(sent_package.sent_package_rating) as package_rating_count'),
                db::raw('avg(sent_package.sent_package_rating) as package_rating')
            ])
                ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->whereNotNull('sent_package.sent_package_rating')
                ->groupBy('package.package_id')
                ->orderBy('package_rating', 'desc')
                ->first();

            $lowest_rated_package = package::select([
                'package.*',
                'genre.genre_title',
                db::raw('count(sent_package.sent_package_rating) as package_rating_count'),
                db::raw('avg(sent_package.sent_package_rating) as package_rating')
            ])
                ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->whereNotNull('sent_package.sent_package_rating')
                ->groupBy('package.package_id')
                ->orderBy('package_rating', 'asc')
                ->first();

            $unrated_package_count = package::select(db::raw('count(IFNULL(sent_package.sent_package_rating, 1)) as package_unrated_count'))
                ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                ->whereNull('sent_package.sent_package_rating')
                ->first();

            $total_sent_packages = package::select(db::raw('count(sent_package.sent_package_id) as total_sent_packages'))
                ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                ->first();

            $sent_packages_by_genre = package::select(['genre.genre_id', 'genre.genre_title', db::raw('count(sent_package.sent_package_id) as sent_packages_by_genre')])
                ->join('sent_package', 'package.package_id', '=', 'sent_package.package_id')
                ->join('subscription', 'sent_package.subscription_id', '=', 'subscription.subscription_id')
                ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                ->groupBy('subscription.genre_id')
                ->get();

            return view('report.packageReport', compact('highest_rated_package', 'lowest_rated_package', 'unrated_package_count', 'total_sent_packages', 'sent_packages_by_genre'));
        }
        return redirect('/reports/packages');
    }

    public function subscriptions()
    {
        if (Session::has('active_user')) {
            if (session()->get('user_type') == 'A') {
                $total_subscriptions = subscription::select(db::raw('count(*) as total_subscription_count'))
                    ->first();

                $active_subscriptions = Count(DB::select(db::raw('select subscription.*, sent_package.sent_package_id from subscription
                join sent_package on subscription.subscription_id = sent_package.subscription_id 
                where sent_package.subscription_id = subscription.subscription_id
                group by subscription.subscription_id
                having subscription.subscription_length - count(sent_package.sent_package_id) != 0')));

                $inactive_subscriptions = Count(DB::select(db::raw('select client.client_id from (select client.client_id from client left join subscription on client.client_id = subscription.client_id
                where last_day(date_add(subscription.subscription_date, interval subscription.subscription_length month)) <= current_date() 
                OR subscription.subscription_id is null order by subscription.subscription_date) as client
                group by client.client_id')));

                $average_subscription_length = subscription::select(db::raw('avg(subscription.subscription_length) as average_length'))
                    ->first();

                $genre_subscription_counts = subscription::select('genre.genre_id', 'genre.genre_title', db::raw('count(genre.genre_id) as genre_count'))
                    ->join('genre', 'subscription.genre_id', '=', 'genre.genre_id')
                    ->groupBy(['genre.genre_id'])
                    ->orderBy('genre.genre_id')
                    ->get();

                return view('report.subscription', compact('total_subscriptions', 'active_subscriptions', 'inactive_subscriptions', 'average_subscription_length', 'genre_subscription_counts'));
            }
        }
        return redirect('/');
    }

    public function generate_subscription_report()
    {
        $inactive_accounts = DB::select(db::raw('select client.*
        from (select user.user_first_name, user.user_last_name, user.user_email_address, client.* from client 
        join user on client.user_id = user.user_id
        left join subscription on client.client_id = subscription.client_id
        where last_day(date_add(subscription.subscription_date, interval subscription.subscription_length month)) <= current_date()
        order by last_day(date_add(subscription.subscription_date, interval subscription.subscription_length month)) desc) as client
        group by client.client_id'));

        $never_active_accounts = DB::select(db::raw('select client.* 
        from (select user.user_first_name, user.user_last_name, user.user_email_address, client.* from client 
        join user on client.user_id = user.user_id
        left join subscription on client.client_id = subscription.client_id
        where subscription.subscription_id is null 
        order by last_day(date_add(subscription.subscription_date, interval subscription.subscription_length month)) desc) as client
        group by client.client_id'));

        return view('report.subscriptionReport', compact('inactive_accounts', 'never_active_accounts'));
    }


    public function products()
    {
        if (Session::has('active_user')) {
            if (session()->get('user_type') == 'A') {
                $products_in_stock = product::select(['product.*', 'genre.genre_title', db::raw('SUM(product.product_quantity * product.product_cost) as total_product_cost')])
                ->join('genre','product.genre_id','=','genre.genre_id')
                ->where('product.product_quantity', '!=', '0')
                ->groupBy(['product.product_id'])
                ->get();

                return view('report.product', compact('products_in_stock'));
            }
        }
        return redirect('/');
    }
}
