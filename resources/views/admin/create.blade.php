<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">
        <h2 class="text-lg font-semibold mb-4">Create User</h2>

        @if($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <input type="text" name="role" value="{{ old('role') }}" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="e.g. Super User, Admin, Patient" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password (optional)</label>
                <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>
            <div class="flex justify-end">
                <a href="{{ route('admin.index') }}" class="mr-2 text-gray-600">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg">Create</button>
            </div>
        </form>
    </div>
</x-app-layout>


