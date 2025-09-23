<div>
    <div>
        {{ $field }}

        @if($list[$name] !== $field)

            ⇅

        @elseif($directory === 'asc')
            ↑

        @else
            ↓
        @endif
    </div>
</div>
