<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-premium btn-premium-danger']) }}>
    {{ $slot }}
</button>
