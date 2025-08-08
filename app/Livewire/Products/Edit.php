<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $product;
    public $name;
    public $category_id;
    public $price;
    public $description;
    public $newImage;
    public $is_available;
    public $currentImage;

    protected $rules = [
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'newImage' => 'nullable|image|max:2048',
        'is_available' => 'boolean',
    ];

    public $categories = [];

public function mount(Product $product)
{
    $this->product = $product;
    $this->name = $product->name;
    $this->category_id = $product->category_id;
    $this->price = $product->price;
    $this->description = $product->description;
    $this->is_available = $product->is_available;
    $this->currentImage = $product->image;

    $this->categories = Category::all(); // simpan di properti
}



    public function update()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'slug' => \Str::slug($this->name),
            'category_id' => $this->category_id,
            'price' => $this->price,
            'description' => $this->description,
            'is_available' => $this->is_available,
        ];

        if ($this->newImage) {
            // Hapus gambar lama jika ada
            if ($this->currentImage) {
                \Storage::disk('public')->delete($this->currentImage);
            }
            
            $imagePath = $this->newImage->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $this->product->update($data);

        session()->flash('message', 'Produk berhasil diperbarui');
        return redirect()->route('products.index');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.products.edit', compact('categories'));
    }
}