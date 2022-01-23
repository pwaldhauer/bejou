<?php $lastday = null ?>

@foreach($journals as $journal)

    <?php
        $thisdayYmd = date('Y-m-d', strtotime($journal->date));
        $thisday = date('l, d. F Y', strtotime($journal->date));
    ?>

    @if($thisday !== $lastday)
        <h3 class="journal-day-headline"><a href="/journal/?date={{ $thisdayYmd }}">{{ $thisday }}</a></h3>
        <?php $lastday = $thisday ?>
    @endif

    <article class="journal-entry">
        <div class="journal-entry__body">
            @if($journal->type === 'text')
                <p>{!! nl2br($journal->processedText()) !!}</p>
            @elseif($journal->type === 'gauge')
                <a href="/gauge/{{ $journal->subtype }}">{{ $journal->subtype }}</a>: {{ $journal->value }}
                @if(!empty($journal->text))
                    <p>{{ $journal->text }}</p>
                @endif
            @elseif($journal->type === 'event')
                <a href="/event/{{ $journal->subtype }}">{{ $journal->subtype }}</a>
                @if(!empty($journal->text))
                    <p>{{ $journal->text }}</p>
                @endif
            @else
                {{ $journal->type }} {{ $journal->subtype }} - No view
            @endif



        </div>
        <aside class="journal-entry__aside">
            <time>{{ date('H:i', strtotime($journal->date)) }}</time>
            <a class="edit-link" href="/journal/{{ $journal->id }}/edit">⚙️</a>
        </aside>

    </article>

@endforeach
