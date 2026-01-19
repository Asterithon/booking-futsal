<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Kelola User</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto py-6">

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded">
                {{ $errors->first() }}
            </div>
        @endif
<div class="bg-white p-4 rounded shadow">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">Nama</th>
                    <th class="border px-3 py-2">Email</th>
                    <th class="border px-3 py-2">Role</th>
                    <th class="border px-3 py-2">Status</th>
                    <th class="border px-3 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="{{ $user->trashed() ? 'bg-gray-100 text-gray-500' : '' }}">
                    <td class="border px-3 py-2">{{ $user->name }}</td>
                    <td class="border px-3 py-2">{{ $user->email }}</td>
                    <td class="border px-3 py-2">
                        <span class="px-2 py-1 rounded text-sm
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="border px-3 py-2">
                        {{ $user->trashed() ? 'Nonaktif' : 'Aktif' }}
                    </td>
                    <td class="border px-3 py-2">
                        @if(auth()->id() !== $user->id)
                        @if(!$user->trashed())
                            <form method="POST" action="{{ route('users.destroy', $user) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">
                                    Nonaktifkan
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('users.restore', $user->id) }}">
                                @csrf
                                @method('PATCH')
                                <button class="text-green-600 hover:underline">
                                    Restore
                                </button>
                            </form>
                        @endif
                        @else
                        <span class="text-gray-400 text-sm">Akun Anda</span>
                        @endif
                    </td>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table></div>
    </div>
</x-app-layout>
