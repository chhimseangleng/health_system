<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>
        <p class="mt-1 text-sm text-gray-600">
            Update your account's profile information and email address.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo -->
        <div>
            <x-input-label for="photo" value="Profile Photo" />

            <div class="mt-2 flex items-center space-x-4">

                {{-- Show photo or avatar --}}
                @if ($user->hasPhoto())
                    <img src="{{ $user->photo_url }}"
                         alt="{{ $user->name }}"
                         class="h-20 w-20 rounded-full object-cover border-2 border-gray-300">
                @else
                    <div class="h-20 w-20 rounded-full bg-indigo-500 flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <div class="flex-1">
                    <input type="file" name="photo" id="photo"
                           accept="image/*"
                           class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2 file:px-4 file:rounded-lg
                                  file:border-0 file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100" />

                    <p class="mt-1 text-xs text-gray-500">PNG, JPG up to 2MB</p>
                    <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                </div>
            </div>
        </div>

        <!-- Name -->
        <div>
            <x-input-label value="Name" />
            <x-text-input name="name" type="text" class="mt-1 block w-full"
                :value="old('name', $user->name)" required />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label value="Email" />
            <x-text-input name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Save</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{show:true}" x-show="show" x-transition
                   x-init="setTimeout(()=>show=false,2000)"
                   class="text-sm text-gray-600">Saved.</p>
            @endif
        </div>
    </form>
</section>
