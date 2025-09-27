<div>
    <select class="form-select mb-4" wire:model.live="limit">
        <option value="{{ $arrayLimits[0] }}" selected>
            Выберите сколько выводить
        @foreach($arrayLimits as $k => $v)
            <option value="{{ $v }}" wire:key="{{ $k }}">{{ $v }}</option>
        @endforeach
    </select>
</div>
