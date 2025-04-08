<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary text-black']) }}>
    {{ $slot }}
</button>
