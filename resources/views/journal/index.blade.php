<x-layout>

    @if(empty($otd) && $filters)
        <x-slot name="belowHeader">
            <div class="filter-info-wrapper">
                <div class="filter-info mb-50">
                    <ul>
                        @foreach($filters as [$label, $value])
                            <li>{{ $label }}: {{ $value }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </x-slot>
    @endif

    @if(!empty($otd))
        <x-slot name="belowHeader">
            <div class="filter-info-wrapper">


                <div class="filter-otd mb-50">
                    <div>
                        An diesem Tag: {{ $otd['date'] }}
                    </div>

                    <ul>
                        @if(!empty($otd['prevYear']))
                            <li><a href="/journal/?date={{ $otd['prevYear'] }}&mode=on-this-day">&larr;</a></li>
                        @endif
                        <li><span class="current">{{ $otd['year'] }}</span></li>
                        @if(!empty($otd['nextYear']))
                            <li><a href="/journal/?date={{ $otd['nextYear'] }}&mode=on-this-day">&rarr;</a></li>
                        @endif
                    </ul>
                </div>


            </div>

        </x-slot>
    @endif

    @if($hasDateFilter)
        <a href="/journal/add/?date={{ $hasDateFilter }}" class="btn btn-secondary mb-50">An diesem Tag hinzufügen</a>
    @endif

    @include('journal.snippets.journal-list')
</x-layout>
