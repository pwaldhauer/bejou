


<x-layout>

    <div class="mb-50"><a href="/event">Alle Events</a></div>


    <h3>{{ $subtype }}</h3>

    <ul>
        @foreach($all as $journal)
            <li>
                {{$journal->date}}:
                @if(!empty($journal->diffToPrevious)): {{ $journal->diffToPrevious }} Tage @endif
                @if(!empty($journal->text)): {{ $journal->text }} @endif
            </li>
        @endforeach

    </ul>

</x-layout>
