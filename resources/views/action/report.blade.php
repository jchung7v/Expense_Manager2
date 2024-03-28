<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Report
        </h2>
    </x-slot>

    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script>{!! $pieChartJS !!}</script>

    <div id="piechart" class="w-[700px] h-[400px] mx-auto bg-transparent"></div>
    {!! $reportTable !!}
</x-app-layout>
