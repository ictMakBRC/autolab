<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary radius-30']) }}>
    {{ $slot }}
</button>
