<x-layout>


    <h3 class="mb-50">{{ $type }} / {{ $subtype }}  </h3>


    <x-add-form type="{{ $type }}" subtype="{{ $subtype }}" :journal="$journal" date="{{ $date }}">
        <div class="form-row">
            <textarea name="text" class="small">@if(!empty($journal)){{ $journal->text }}@endif</textarea>
        </div>
    </x-add-form>

</x-layout>
