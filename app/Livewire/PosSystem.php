<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class PosSystem extends Component
{
    public $search = '';
    public $cart = [];
    public $payment = 0;
    public $change = 0;

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']++;
        } else {
            $this->cart[$productId] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }
        $this->updateChange();
    }

    // Tambah fungsi untuk mengurangi qty satu item
    public function decreaseQuantity($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity']--;
            if ($this->cart[$productId]['quantity'] <= 0) {
                unset($this->cart[$productId]);
            }
            $this->updateChange();
        }
    }

    public function removeFromCart($productId)
    {
        if (isset($this->cart[$productId])) {
            unset($this->cart[$productId]);
            $this->updateChange();
        }
    }

    public function updatePayment($amount)
    {
        $this->payment = $amount;
        $this->updateChange();
    }

    public function updateChange()
{
    $payment = floatval($this->payment);
    $total = $this->getTotal();

    $this->change = $payment - $total;
    if ($this->change < 0) $this->change = 0;
}


    public function getTotal()
    {
        return array_reduce($this->cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function render()
    {
        $products = Product::when($this->search, function($query) {
            return $query->where('name', 'like', '%'.$this->search.'%');
        })->get();

        return view('livewire.pos-system', [
            'products' => $products,
            'total' => $this->getTotal(),
        ]);
    }
}
