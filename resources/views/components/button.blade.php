<button {{ $attributes->merge(['type' => 'submit', 'class' => 'text-center w-full text-white uppercase bg-primary font-bold py-3 hover:bg-white hover:text-secondary']) }}>
    {{ $slot }}
</button>
