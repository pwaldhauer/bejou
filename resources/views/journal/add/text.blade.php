


<x-layout>

    <x-add-form type="{{ $type }}" subtype="{{ $subtype }}" :journal="$journal" date="{{ $date }}">
        <div class="form-row">
            <textarea name="text" >@if(!empty($journal)){{ $journal->text }}@endif</textarea>
        </div>
    </x-add-form>

</x-layout>
