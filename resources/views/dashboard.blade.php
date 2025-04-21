<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 text-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="mb-6">Here's an overview of your sales data:</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sales Per Day Chart -->
                    <div class="bg-gray-800 p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-2">Sales Per Day (This Month)</h3>
                        <canvas id="salesPerDayChart"></canvas>
                    </div>

                    <!-- Product Sales Count Chart -->
                    <div class="bg-gray-800 p-4 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-2">Product Sales Count</h3>
                        <canvas id="productSalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sales Per Day Chart
        const salesPerDayCtx = document.getElementById('salesPerDayChart').getContext('2d');
        const salesPerDayChart = new Chart(salesPerDayCtx, {
            type: 'line',
            data: {
                labels: @json($salesPerDay->pluck('date')),
                datasets: [{
                    label: 'Total Sales',
                    data: @json($salesPerDay->pluck('total')),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 2,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Sales (in currency)'
                        }
                    }
                }
            }
        });

        // Product Sales Count Chart
        const productSalesCtx = document.getElementById('productSalesChart').getContext('2d');
        const productSalesChart = new Chart(productSalesCtx, {
            type: 'bar',
            data: {
                labels: @json($productSales->pluck('product.name')),
                datasets: [{
                    label: 'Total Sales',
                    data: @json($productSales->pluck('total_sales')),
                    backgroundColor: 'rgba(153, 102, 255, 0.6)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Product'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Sales Count'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
