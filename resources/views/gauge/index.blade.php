


<x-layout>

    <h3 class="mb-50">Alle Messwerte</h3>

   <ul>

       @foreach($gauges as $gauge)
           <li><a href="/gauge/{{ $gauge }}">{{ $gauge }}</a></li>
       @endforeach
   </ul>


</x-layout>
