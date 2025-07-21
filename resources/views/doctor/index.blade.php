<x-app-layout>
    <div class="py-12">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border-2 border-gray-200 border-dashed overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg">
                    
                    <div class="overflow-x-auto border border-gray-200 rounded-xl shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="text-xs tracking-wider uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nº</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Email</th>
                                    <th scope="col" class="px-6 py-3">Special List</th>
                                    <th scope="col" class="px-6 py-3">Created At</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($user as $doctor)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition duration-150">
                                        <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-center">{{ $doctor->name }}</td>
                                        <td class="px-6 py-4 text-center">{{ $doctor->email }}</td>
                                        <td class="px-6 py-4 text-center">{{ $doctor->role ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            {{ \Carbon\Carbon::parse($doctor->created_at)->format('Y-m-d H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
