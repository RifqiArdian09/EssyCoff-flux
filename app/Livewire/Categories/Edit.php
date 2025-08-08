<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class Edit extends Component
{
    public $category;
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function mount(Category $category)
    {
        $this->category = $category;
        $this->name = $category->name;
        $this->description = $category->description;
    }

    public function update()
    {
        $this->validate();

        $this->category->update([
            'name' => $this->name,
            'slug' => \Str::slug($this->name),
            'description' => $this->description,
        ]);

        session()->flash('message', 'Kategori berhasil diperbarui');
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.edit');
    }
}
