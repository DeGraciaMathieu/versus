<a {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-primary text-center text-white hover:text-secondary hover:bg-white']) }}>
    {{ $slot }}
</a>
