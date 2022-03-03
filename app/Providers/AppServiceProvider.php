<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Visitor;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        view()->composer('report', function ($view) {
            $report['months'] = collect([]);
            $visitorMonth = Visitor::where('created_at', '>=', Carbon::now()->subYear())
                ->selectRaw("COUNT(short_link_id) as data")
                ->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")
                ->orderBy('created_at')
                ->groupBy('months')->get();
            $visitorMonth->map(function ($depositData) use ($report) {
                $report['months']->push($depositData->months);
            });
            $visitorData = Visitor::where('created_at', '>=', Carbon::now()->subDay(30))->get(['browser', 'os']);
            $view->with([
                'visitorMonth'   => $visitorMonth,
                'months'   => $report['months'],
                'visitors'       => Visitor::select('short_link_id', 'ip', 'os', 'browser', 'device')->with('shortlink')->paginate(8),
                'browser_counter'=> $visitorData->groupBy('browser')->map(function ($item, $key) { return collect($item)->count(); }),
                'os_counter'     => $visitorData->groupBy('os')->map(function ($item, $key) { return collect($item)->count(); }),
                'country_counter'=> $visitorData->groupBy('country')->map(function ($item, $key) { return collect($item)->count(); }),
            ]);
        });
    }
}
