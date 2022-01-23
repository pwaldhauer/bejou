


<x-layout>

    <h3 class="mb-50">Alle Events</h3>

   <ul>

       @foreach($events as $event)
           <li><a href="/event/{{ $event }}">{{ $event }}</a></li>
       @endforeach
   </ul>


</x-layout>
