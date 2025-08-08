<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;

class Create extends Component
{
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => \Str::slug($this->name),
            'description' => $this->description,
        ]);

        session()->flash('message', 'Kategori berhasil ditambahkan');
        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.categories.create');
    }
}