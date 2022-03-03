@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 mt-5">
            <div class="text-start">
                <h4>All Visitor</h4>
            </div>
            <div class="text-end">
                <a href="{{route('export')}}" class="btn btn-primary">Export CSV</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Short Url</th>
                        <th scope="col">Ip</th>
                        <th scope="col">OS</th>
                        <th scope="col">Browser</th>
                        <th scope="col">Device</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visitors as $visitor)
                        <tr>
                            <th>{{url('/').'/'.$visitor->shortlink->hash}}</th>
                            <td>{{$visitor->ip}}</td>
                            <td>{{$visitor->os}}</td>
                            <td>{{$visitor->browser}}</td>
                            <td>{{$visitor->device}}</td>
                            <td>
                                <a href="javascript:void(0)" title="Copy Short Url" data-clipboard-text="{{url('/').'/'.$visitor->shortLink->hash}}" class="btn btn-primary btn-sm copy">Copy</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="100%">No Data Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{$visitors->links()}}
            
        </div>


    <div class="col-xl-12 my-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">@lang('Monthly most visited website')</h5>
                <div id="apex-bar-chart"> </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 my-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Last 30 days Login By Browser</h5>
                <canvas id="userBrowserChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 my-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Last 30 days Login By OS</h5>
                <canvas id="userOsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 my-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Last 30 days Login By Country</h5>
                <canvas id="userCountryChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
<script>
    $('.copy').on('click',function(){
        var clipboard = new ClipboardJS('.copy');
        notify('success','URL copied : '+$(this).data('clipboard-text'))
    });

    var options = {
        series: [{
            name: 'Total Click',
            data: [
            @foreach($months as $month)
            {{ @$visitorMonth->where('months',$month)->first()->data}},
            @endforeach
            ]
        }],
        chart: {
            type: 'bar',
            height: 400,
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: @json($months),
        },
        yaxis: {
            title: {
                text: "Most visited website of the month",
                style: {
                    color: '#7c97bb'
                }
            }
        },
        grid: {
            xaxis: {
                lines: {
                    show: false
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            },
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val
                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
    chart.render();


    var ctx = document.getElementById('userBrowserChart');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($browser_counter->keys()),
            datasets: [{
                data: {{ $browser_counter->flatten() }},
                backgroundColor: [
                '#ff7675',
                '#6c5ce7',
                '#ffa62b',
                '#ffeaa7',
                '#D980FA',
                '#fccbcb',
                '#45aaf2',
                '#05dfd7',
                '#FF00F6',
                '#1e90ff',
                '#2ed573',
                '#eccc68',
                '#ff5200',
                '#cd84f1',
                '#7efff5',
                '#7158e2',
                '#fff200',
                '#ff9ff3',
                '#08ffc8',
                '#3742fa',
                '#1089ff',
                '#70FF61',
                '#bf9fee',
                '#574b90'
                ],
                borderColor: [
                    'rgba(231, 80, 90, 0.75)'
                ],
                borderWidth: 0,
            }]
        },
        options: {
            aspectRatio: 1,
            responsive: true,
            maintainAspectRatio: true,
            elements: {
                line: {
                    tension: 0 // disables bezier curves
                }
            },
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }]
            },
            legend: {
                display: false,
            }
        }
    });


    var ctx = document.getElementById('userOsChart');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($os_counter->keys()),
            datasets: [{
                data: {{ $os_counter->flatten() }},
                backgroundColor: [
                '#ff7675',
                '#6c5ce7',
                '#ffa62b',
                '#ffeaa7',
                '#D980FA',
                '#fccbcb',
                '#45aaf2',
                '#05dfd7',
                '#FF00F6',
                '#1e90ff',
                '#2ed573',
                '#eccc68',
                '#ff5200',
                '#cd84f1',
                '#7efff5',
                '#7158e2',
                '#fff200',
                '#ff9ff3',
                '#08ffc8',
                '#3742fa',
                '#1089ff',
                '#70FF61',
                '#bf9fee',
                '#574b90'
                ],
                borderColor: [
                'rgba(0, 0, 0, 0.05)'
                ],
                borderWidth: 0,

            }]
        },
        options: {
            aspectRatio: 1,
            responsive: true,
            elements: {
                line: {
                    tension: 0 // disables bezier curves
                }
            },
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }]
            },
            legend: {
                display: false,
            }
        },
    });

    var ctx = document.getElementById('userCountryChart');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: @json($country_counter->keys()),
            datasets: [{
                data: {{ $country_counter->flatten() }},
                backgroundColor: [
                    '#ff7675',
                    '#6c5ce7',
                    '#ffa62b',
                    '#ffeaa7',
                    '#D980FA',
                    '#fccbcb',
                    '#45aaf2',
                    '#05dfd7',
                    '#FF00F6',
                    '#1e90ff',
                    '#2ed573',
                    '#eccc68',
                    '#ff5200',
                    '#cd84f1',
                    '#7efff5',
                    '#7158e2',
                    '#fff200',
                    '#ff9ff3',
                    '#08ffc8',
                    '#3742fa',
                    '#1089ff',
                    '#70FF61',
                    '#bf9fee',
                    '#574b90'
                ],
                borderColor: [
                    'rgba(231, 80, 90, 0.75)'
                ],
                borderWidth: 0,

            }]
        },
        options: {
            aspectRatio: 1,
            responsive: true,
            elements: {
                line: {
                    tension: 0 // disables bezier curves
                }
            },
            scales: {
                xAxes: [{
                    display: false
                }],
                yAxes: [{
                    display: false
                }]
            },
            legend: {
                display: false,
            }
        }
    });
</script>
@endpush