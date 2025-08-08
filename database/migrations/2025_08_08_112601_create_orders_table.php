<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->enum('status', ['pending', 'processing', 'completed', 'declined'])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('cash', 10, 2); // uang yang diberikan customer
            $table->decimal('change', 10, 2); // kembalian
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // kasir yang memproses
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};