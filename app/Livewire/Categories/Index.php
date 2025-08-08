<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $listeners = ['categoryDeleted' => 'refreshCategories'];

    public function refreshCategories()
    {
        // Method ini akan dipanggil ketika kategori dihapus
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $category->delete();
        
        $this->emit('categoryDeleted');
        $this->dispatchBrowserEvent('notify', ['message' => 'Kategori berhasil dihapus']);
    }

    public function render()
    {
        $categories = Category::when($this->search, function($query) {
            return $query->where('name', 'like', '%'.$this->search.'%');
        })
        ->paginate($this->perPage);

        return view('livewire.categories.index', compact('categories'));
    }
}