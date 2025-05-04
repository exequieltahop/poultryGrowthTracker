<x-auth-layout title="Logs">
    {{-- vite --}}

    @vite(['resources/js/logs.js'])

    <style>
        /* Customize pagination container */
        .pagination {
            display: flex !important;
            justify-content: center !important;
            list-style-type: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Pagination list items */
        .pagination li {
            margin: 0 5px !important;
        }

        /* Pagination links */
        .pagination li a,
        .pagination li span {
            display: inline-block !important;
            padding: 6px 12px !important;
            font-size: 14px !important;
            /* Adjust to smaller size */
            border-radius: 4px !important;
            color: #007bff !important;
            text-decoration: none !important;
            border: 1px solid #ddd !important;
        }

        /* Pagination link hover effect */
        .pagination li a:hover {
            background-color: #0056b3 !important;
            color: white !important;
        }

        /* Active pagination item */
        .pagination li.active span {
            background-color: #007bff !important;
            color: white !important;
        }

        /* Disabled pagination item */
        .pagination li.disabled span {
            color: #ccc !important;
        }
    </style>

    {{-- section card list table data --}}
    <section class="container-fluid mt-3 p-0" style="width: 90%;">
        {{-- card --}}
        <div class="card bg-white shadow-lg">
            {{-- card header --}}
            <div class="card-header">
                <h5 class="card-title m-0 text-primary">
                    <i class="bi bi-journal-text" style="font-style: normal;"> Logs</i>
                </h5>
            </div>
            {{-- card body --}}
            <div class="card-title table-responsive p-4" style="max-height: 60vh;">
                <table class="table" {{-- id="table-data-logs" --}}>
                    {{-- thead --}}
                    <thead>
                        <th>No</th>
                        <th>Temperature</th>
                        <th>Humidity</th>
                        <th>Ammonia</th>
                        <th>Bulb Status</th>
                        <th>Fan Status</th>
                        <th>Date Log</th>
                    </thead>
                    {{-- tbody --}}
                    <tbody class="">
                        @foreach ($paginator as $item)
                        @php
                        $validator = App\Http\Controllers\SensorDataHandler::controlDevices($item->temperature,
                        $item->humidity, $item->amonia)
                        @endphp

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->temperature}}</td>
                            <td>{{$item->humidity}}</td>
                            <td>{{$item->amonia}}</td>
                            <td>
                                {{ $validator['bulbOn'] == true ? 'ON' : 'OFF' }}
                            </td>
                            <td>
                                {{ $validator['fanOn'] == true ? 'ON' : 'OFF' }}
                            </td>
                            <td>{{$item->created_at->format('Y-m-d h:i A')}}</td>
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
            </div>
            <div class="p-3 position-relative" style="min-width: 100px;">
                @if ($paginator->hasPages())
                <nav aria-label="Pagination" class="overflow-auto d-flex justify-content-start">
                    <ul class="pagination d-flex" style="flex-wrap: wrap;">
                        <!-- Previous Page Link -->
                        @if ($paginator->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a href="{{ $paginator->previousPageUrl() }}" class="page-link">Previous</a>
                        </li>
                        @endif
                        <!-- Pagination Links -->
                        @foreach ($paginator->links()->elements as $element)
                        @if (is_string($element))
                        <li class="page-item disabled">
                            <span class="page-link">{{ $element }}</span>
                        </li>
                        @elseif (is_array($element))
                        @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                        @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        </li>
                        @endif
                        @endforeach
                        @endif
                        @endforeach

                        <!-- Next Page Link -->
                        @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a href="{{ $paginator->nextPageUrl() }}" class="page-link">Next</a>
                        </li>
                        @else
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                        @endif
                    </ul>
                </nav>
                @endif
            </div>
        </div>
    </section>
</x-auth-layout>