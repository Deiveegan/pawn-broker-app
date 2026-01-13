<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-premium btn-premium-primary']) }}>
    {{ $slot }}
</button>
