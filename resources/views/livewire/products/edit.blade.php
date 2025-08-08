<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form wire:submit.prevent="update">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-2">Nama Produk</label>
                <input type="text" wire:model="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 font-medium mb-2">Kategori</label>
                <select wire:model="category_id" id="category_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-medium mb-2">Harga</label>
                <input type="number" wire:model="price" id="price" min="0" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                <textarea wire:model="description" id="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mb-4">
                <label for="newImage" class="block text-gray-700 font-medium mb-2">Gambar Produk</label>
                @if($currentImage)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $currentImage) }}" alt="{{ $name }}" class="h-20 w-20 object-cover rounded">
                </div>
                @endif
                <input type="file" wire:model="newImage" id="newImage" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('newImage') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                @if($newImage)
                    <div class="mt-2">
                        <img src="{{ $newImage->temporaryUrl() }}" class="h-20 w-20 object-cover rounded">
                    </div>
                @endif
            </div>
            <div class="mb-4 flex items-center">
                <input type="checkbox" wire:model="is_available" id="is_available" class="mr-2">
                <label for="is_available" class="text-gray-700">Tersedia</label>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
            </div>
        </form>
    </div>
</div>