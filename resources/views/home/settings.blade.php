@extends('layouts.app')

@section('content')
    <h1 class="font-bold text-3xl text-white mt-8 mb-6 md:w-2/3 md:mx-auto md:flex md:items-center">
        Paramètres
    </h1>
    <form action="{{ route('home.updateSettings') }}" method="post" enctype="multipart/form-data" class="md:w-2/3 md:mx-auto mb-4 text-white font-bold">
        @method('put')
        @csrf
        <div class="mb-4">
            <x-label for="avatar">Avatar</x-label>
            <div id="preview" class="h-32 w-32 bg-white bg-cover bg-center relative" style="background-image: url({{ route('image', $user->getPhoto()) }})">
                <label for="photo" class="bg-secondary-light text-white absolute bottom-0 right-0 p-2 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    <input id="photo" name="photo" type="file" class="hidden" accept="image/*"/>
                </label>
            </div>
            @error('photo')
                <span class="text-red-500 text-sm font-semibold">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <x-label for="name">Nom</x-label>
            <x-input id="name" type="text" name="name" :value="old('name', $user->name)" />
        </div>
        <div class="mb-4">
            <x-label for="email">Email</x-label>
            <x-input id="email" type="text" name="email" :value="old('email', $user->email)" />
        </div>

        <x-button class="w-full">
            Enregistrer
        </x-button>
    </form>
    <script>
        let input = document.getElementById('photo');
        input.addEventListener('change', fileSelectHandle, false);

        function fileSelectHandle(e) {
            let files = e.target.files || e.dataTransfer.files;

            if (! files) {
                return;
            }

            let reader = new FileReader();

            reader.onload = function (e) {
                let preview = document.getElementById('preview');
                preview.style.backgroundImage = 'url(' + e.target.result + ')';
            }

            reader.readAsDataURL(files[0]);
        }
    </script>
@endsection

