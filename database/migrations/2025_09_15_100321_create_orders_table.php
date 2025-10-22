<?php

use App\Enums\PaymentEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('address');
            $table->string('phone_number');
            $table->decimal('total', 10)->default(0);
            $table->enum('payment_method', PaymentEnum::getValues())->default(PaymentEnum::CASH->value);
            $table->enum('status', StatusEnum::getValues())->default(StatusEnum::PENDING->value);
            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
