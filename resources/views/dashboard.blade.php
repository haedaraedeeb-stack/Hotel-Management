@extends('layouts.admin')
<<<<<<< Updated upstream

@section('title', 'Dashboard')
=======
@section('title', 'Home')
@section('content')

    <div class="py-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            {{-- Card 1: Total Bookings --}}
            @hasanyrole('admin|manager')
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-center">
                        <div
                            class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-blue-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="mb-1 text-2xl font-bold text-gray-900">{{ $stats['reservations_count'] }}</h3>
                            <p class="text-sm font-medium text-gray-500">Reservations</p>
                        </div>
                    </div>
                </div>
            @endhasanyrole


            {{-- Card 2: Total Revenue --}}
            @hasanyrole('admin|manager')
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-center">
                        <div
                            class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-green-500 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="mb-1 text-2xl font-bold text-gray-900">{{ $stats['revenue'] }}</h3>
                            <p class="text-sm font-medium text-gray-500">Revenue</p>
                        </div>
                    </div>
                </div>
            @endhasanyrole

            {{-- Card 3: Guests --}}
            @hasanyrole('admin|manager')
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-center">
                        <div
                            class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-purple-500 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-1a4 4 0 00-5-3.87M9 20H4v-1a4 4 0 015-3.87m6-7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="mb-1 text-2xl font-bold text-gray-900">{{ $stats['guests_count'] }}</h3>
                            <p class="text-sm font-medium text-gray-500">Active Guests</p>
                        </div>
                    </div>
                </div>
            @endhasanyrole

            {{-- Card 4: Rooms --}}
            @hasanyrole('admin|manager|receptionist')
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex items-center">
                        <div
                            class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-orange-500 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="mb-1 text-2xl font-bold text-gray-900">{{ $stats['occupancy'] }}%</h3>
                            <p class="text-sm font-medium text-gray-500">Occupancy Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        @endhasanyrole


        {{-- 2. Charts Section (Charts Grid) --}}
        @hasanyrole('admin|manager')
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mb-6">

                {{-- Chart 1: Revenue Chart (Area) --}}
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Monthly Revenue</h3>
                    </div>
                    <div id="revenue-chart"></div>
                </div>
            @endhasanyrole

            {{-- Chart 2: Room Types (Pie/Donut) --}}
            @hasanyrole('admin|manager|receptionist')
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Room Preferences</h3>
                    </div>
                    <div id="room-pie-chart"></div>
                </div>
            </div>
        @endhasanyrole
        <script>
            const monthlyReservations = @json($monthlyReservations);
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div
            style="background: white; padding: 20px; border-radius: 10px; margin-top: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 15px; color: #333;">Monthly Reservations Overview</h3>
            <canvas id="reservationsChart" style="max-height: 400px;"></canvas>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const canvas = document.getElementById('reservationsChart');

                if (!canvas) return;

                const ctx = canvas.getContext('2d');

                const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ];

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Monthly Reservations ({{ now()->year }})',
                            data: monthlyReservations,
                            backgroundColor: 'rgba(10, 40, 205, 0.7)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            });
        </script>

        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Recent Reservations</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Guest</th>
                            <th class="px-4 py-3">Room</th>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentBookings as $recentBooking)
                            <tr class="border-b">
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $recentBooking->user->name }}</td>
                                <td class="px-4 py-3">{{ $recentBooking->room->roomType->type }} '
                                    '{{ $recentBooking->room->room_number }}</td>
                                <td class="px-4 py-3">{{ $recentBooking->start_date }} ->
                                    {{ $recentBooking->end_date }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($recentBooking->status == 'confirmed')
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Confirmed</span>
                                    @elseif($recentBooking->status == 'pending')
                                        <span
                                            class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Pending</span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const revenueLabels = @json($chartData['labels']);
            const revenueValues = @json($chartData['values']);

            if (document.getElementById("revenue-chart") && typeof ApexCharts !== 'undefined') {
                const revenueOptions = {
                    chart: {
                        height: 350,
                        type: "area",
                        fontFamily: "Inter, sans-serif",
                        toolbar: {
                            show: false
                        },
                    },
                    fill: {
                        type: "gradient",
                        gradient: {
                            opacityFrom: 0.55,
                            opacityTo: 0
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 3
                    },
                    grid: {
                        show: true,
                        strokeDashArray: 4
                    },
                    series: [{
                        name: "Revenue ($)",
                        data: revenueValues.length > 0 ? revenueValues : [
                            0
                        ],
                        color: "#1A56DB",
                    }, ],
                    xaxis: {
                        categories: revenueLabels.length > 0 ? revenueLabels : ['No Data'],
                        labels: {
                            show: true
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return "$" + value;
                            }
                        }
                    },
                };
                const revenueChart = new ApexCharts(document.getElementById("revenue-chart"), revenueOptions);
                revenueChart.render();
            }

            const pieLabels = @json($roomTypeStats['labels']);
            const pieValues = @json($roomTypeStats['values']);

            if (document.getElementById("room-pie-chart") && typeof ApexCharts !== 'undefined') {
                const pieOptions = {
                    series: pieValues.length > 0 ? pieValues : [1], // قيمة افتراضية لكي لا يختفي الرسم
                    chart: {
                        height: 350,
                        type: 'donut',
                    },
                    labels: pieLabels.length > 0 ? pieLabels : ['No Bookings Yet'],

                    colors: ['#1C64F2', '#16BDCA', '#FDBA8C', '#E74694', '#F59E0B'],
                    legend: {
                        position: 'bottom',
                        fontFamily: 'Inter, sans-serif',
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    total: {
                                        showAlways: true,
                                        show: true,
                                        label: 'Total',
                                        formatter: function(w) {
                                            return w.globals.seriesTotals.reduce((a, b) => {
                                                return a + b
                                            }, 0)
                                        }
                                    }
                                }
                            }
                        }
                    }
                };
                const pieChart = new ApexCharts(document.getElementById("room-pie-chart"), pieOptions);
                pieChart.render();
            }
        });
    </script>
@endsection
