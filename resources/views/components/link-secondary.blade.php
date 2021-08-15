<a {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-secondary-dark text-center text-white hover:text-secondary hover:bg-white']) }}>
    {{ $slot }}
</a>
