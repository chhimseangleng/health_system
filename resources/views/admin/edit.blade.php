<x-app-layout>
    <div class="p-6 max-w-xl mx-auto">
        <h2 class="text-lg font-semibold mb-4">Edit User</h2>

        @if($errors->any())
            <div class="mb-4 text-red-600">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.update', $user) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <input type="text" name="role" value="{{ old('role', $user->role) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Password (leave blank to keep current)</label>
                <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md">
            </div>
            <div class="flex justify-end">
                <a href="{{ route('admin.index') }}" class="mr-2 text-gray-600">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg">Save</button>
            </div>
        </form>
    </div>
</x-app-layout>


