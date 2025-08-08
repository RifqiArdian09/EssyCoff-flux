<div class="flex h-screen bg-gray-100 dark:bg-gray-900 p-4 gap-4">
    
    <!-- Products -->
    <div class="w-1/3 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg flex flex-col">
        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Products</h2>
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search"
            placeholder="Search products..."
            class="w-full p-2 mb-4 border rounded-lg dark:bg-gray-700 dark:text-white"
        >
        <div class="grid grid-cols-2 gap-3 overflow-y-auto">
            @foreach($products as $product)
                <div 
                    wire:click="addToCart({{ $product->id }})"
                    class="cursor-pointer p-2 rounded-lg border dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-700 transition flex flex-col"
                >
                    <img 
                        src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150' }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-20 object-cover rounded-md mb-2" 
                    />
                    <span class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $product->name }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-300">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Shopping Cart -->
    <div class="w-1/3 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg flex flex-col">
        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Shopping Cart</h2>
        @if(count($cart) == 0)
            <div class="flex flex-col items-center justify-center flex-grow text-gray-500 dark:text-gray-400">
                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p>Your cart is empty</p>
                <span class="text-xs">Start adding products by clicking on them</span>
            </div>
        @else
            <div class="space-y-2 overflow-y-auto max-h-[65vh]">
                @foreach($cart as $id => $item)
                    <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg">
                        <div class="flex items-center">
                            <img 
                                src="{{ $item['image'] ? asset('storage/' . $item['image']) : 'https://via.placeholder.com/150' }}" 
                                alt="{{ $item['name'] }}" 
                                class="w-12 h-12 object-cover rounded mr-2"
                            />
                            <div>
                                <p class="text-sm font-medium dark:text-white">{{ $item['name'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-300">{{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <button 
                                wire:click="decreaseQuantity({{ $id }})" 
                                class="px-2 py-1 bg-red-500 rounded text-white hover:bg-red-600" 
                                title="Kurangi"
                            >
                                -
                            </button>

                            <span class="text-sm font-medium dark:text-white">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Payment Details -->
    <div class="w-1/3 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg flex flex-col">
        <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Payment Details</h2>

        <div class="flex justify-between p-3 bg-gray-100 dark:bg-gray-700 rounded-lg mb-4">
            <span>Total:</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        <label class="block text-sm mb-1 text-gray-600 dark:text-gray-300">Cash Received</label>
        <input 
            type="number" 
            wire:model.live="payment" 
            wire:input="updatePayment($event.target.value)" 
            placeholder="0"
            class="w-full p-3 border rounded-lg dark:bg-gray-700 dark:text-white mb-4"
        >

        <div class="flex justify-between p-3 bg-gray-100 dark:bg-gray-700 rounded-lg mb-4">
            <span>Change:</span>
            <span>Rp {{ number_format($change, 0, ',', '.') }}</span>
        </div>

        <button 
            wire:click="$dispatch('confirm-payment')"
            class="mt-auto w-full py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium"
            @disabled($total <= 0 || $payment < $total)
        >
            Process Payment
        </button>
    </div>

</div>
