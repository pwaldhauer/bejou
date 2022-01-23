<div class="has-fixed-bottom">

    @if(!empty($journal))
        <form action="/journal/{{ $journal->id }}/edit" method="post">
            @else
                <form action="/journal/add/{{ $type }}@if(!empty($subtype))/{{ $subtype }}@endif" method="post">
                    @endif
                    @csrf

                    {{ $slot }}


                    <div class="form-row">
                        @if(!empty($journal))
                            <input type="datetime-local" name="date"
                                   value="{{ date('Y-m-d\TH:i', strtotime($journal->date))}}"/>
                        @else
                            <input type="datetime-local" name="date"
                                   value="@if(!empty($date)){{ date('Y-m-d\T\1\2\:\0\0', strtotime($date))}}@endif"/>
                        @endif

                    </div>

                    <div class="form-row fixed-bottom">
                        <input type="submit" value="Speichern" name="submit">
                    </div>


                </form>
</div>
