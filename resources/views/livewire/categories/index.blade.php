<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Daftar Kategori</h1>
        <a href="{{ route('categories.create') }}"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" wire:navigate>
            Tambah Kategori
        </a>
    </div>

    <div class="mb-4 flex justify-between">
        <div class="w-1/3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kategori..."
                class="w-full px-4 py-2 border rounded-lg">
        </div>
        <div>
            <select wire:model.live="perPage" class="px-4 py-2 border rounded-lg">
                <option value="10">10 per halaman</option>
                <option value="25">25 per halaman</option>
                <option value="50">50 per halaman</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $category->description ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('categories.edit', $category->id) }}"
                                class="text-indigo-600 hover:text-indigo-900 mr-3" wire:navigate>Edit</a>
                            <button wire:click="deleteCategory({{ $category->id }})"
                                class="text-red-600 hover:text-red-900"
                                onclick="confirm('Apakah Anda yakin ingin menghapus kategori ini?') || event.stopImmediatePropagation()">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center">Tidak ada data kategori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
