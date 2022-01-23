<x-layout>
        <div class="search mb-50">
            <form action="/journal" method="get">
                <input type="text" name="text" value="" placeholder="Suche…" />
            </form>
        </div>

    @if($streak)
        <div class="highlight mb-50">Streak: {{$streak['days']}} Tage, seit
            dem {{date('d.m.Y', strtotime($streak['start']))}}.
        </div>
    @endif

    @if($onthisdayCount)
    <div class="on-this-day mb-50">{{$onthisdayCount}} Posts an diesem Tag in:
        <ul class="on-this-day__years">
            @foreach($onthisdayYears as $year)
                <li><a href="/journal?date={{ $year }}-{{ date('m-d') }}&mode=on-this-day">{{ $year }}</a></li>
            @endforeach
        </ul>
    </div>
    @endif

    <a href="/journal/add" class="btn btn-secondary mb-50">An diesem Tag hinzufügen</a>

    <hr>

    @include('journal.snippets.journal-list')
</x-layout>
