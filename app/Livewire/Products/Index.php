<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $categoryFilter = '';

    protected $listeners = ['productDeleted' => 'refreshProducts'];

    public function refreshProducts()
    {
        // Method ini akan dipanggil ketika produk dihapus
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        
        // Hapus gambar jika ada
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        $this->emit('productDeleted');
        $this->dispatchBrowserEvent('notify', ['message' => 'Produk berhasil dihapus']);
    }

    public function render()
    {
        $products = Product::with('category')
            ->when($this->search, function($query) {
                return $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->when($this->categoryFilter, function($query) {
                return $query->where('category_id', $this->categoryFilter);
            })
            ->paginate($this->perPage);

        $categories = \App\Models\Category::all();

        return view('livewire.products.index', compact('products', 'categories'));
    }
}