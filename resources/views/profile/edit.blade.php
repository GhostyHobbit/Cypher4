<x-app-layout>
    <div class="grid grid-cols-4 h-full overflow-hidden">
        <!-- Sidebar Column -->
        <div class="ml-6 mt-6 flex flex-col">
            <h2 class="font-semibold text-3xl text-text-default leading-tight">
                {{ __('Profile settings') }}
            </h2>
            <div class="w-full bg-background-dark mt-8 flex flex-col items-center py-6 rounded-xl">
                <form action="{{ route('photo.upload', ['type' => 'user', 'id' => $user->id]) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center" x-data>
                    @csrf
                    <div class="relative group cursor-pointer w-32 aspect-square" @click="$refs.fileInput.click()">
                        <img src="{{ $user->image_src ? asset('storage/' . $user->image_src) : asset('images/apollopfp.jpg') }}" alt="profile_picture" class="rounded-full w-32 aspect-square object-cover transition-all group-hover:brightness-50"/>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                            <span class="text-text-default text-xs font-bold uppercase tracking-wider bg-background-dark/60 px-2 py-1 rounded">
                                Change
                            </span>
                        </div>
                    </div>
                    <input type="file" name="photo" x-ref="fileInput" @change="$el.form.submit()" class="hidden" accept="image/*">
                </form>
                @if ($errors->any())
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @error('profile_photo')
                <span class="text-xs text-red-500 mt-2">{{ $message }}</span>
                @enderror

                <p class="text-lg font-semibold mt-6">{{ $user->username }}</p>
                <p class="text-text-light text-sm">{{ $user->name }} - {{ $user->email }}</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-link-button :cat="false" :href="route('logout')"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-link-button>
            </form>
        </div>

        <!-- Scrollable Content Column -->
        <div class="py-12 mt-11 col-span-2 h-full overflow-y-auto scrollbar-hide">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6 pb-24">
                <livewire:settings.theme-switcher />

                <div class="p-4 sm:p-8 bg-background-dark shadow sm:rounded-lg">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="p-4 sm:p-8 bg-background-dark shadow sm:rounded-lg">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="p-4 sm:p-8 bg-background-dark shadow sm:rounded-lg">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <div></div>
    </div>
</x-app-layout>
