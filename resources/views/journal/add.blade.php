


<x-layout>

    <ul class="add-boxes">
        @foreach($types as [$label, $path])
            <li><a href="/journal/add/{{ $path }}@if($date)?date={{ $date }}@endif">{{ $label  }}</a></li>
        @endforeach

    </ul>

</x-layout>
