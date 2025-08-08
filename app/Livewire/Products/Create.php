<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $category_id;
    public $price;
    public $description;
    public $image;
    public $is_available = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
        'is_available' => 'boolean',
    ];

    public function save()
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

        if ($this->image) {
            $imagePath = $this->image->store('products', 'public');
            $data['image'] = $imagePath;
        }

        Product::create($data);

        session()->flash('message', 'Produk berhasil ditambahkan');
        return redirect()->route('products.index');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.products.create', compact('categories'));
    }
}