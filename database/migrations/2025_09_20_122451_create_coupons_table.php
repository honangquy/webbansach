<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã coupon
            $table->text('description')->nullable(); // Mô tả
            $table->enum('type', ['percentage', 'fixed']); // Loại: phần trăm hoặc cố định
            $table->decimal('value', 10, 2); // Giá trị giảm
            $table->decimal('minimum_order_amount', 10, 2)->nullable(); // Giá trị đơn hàng tối thiểu
            $table->decimal('maximum_discount', 10, 2)->nullable(); // Giảm tối đa (cho phần trăm)
            $table->integer('usage_limit')->nullable(); // Giới hạn số lần sử dụng tổng
            $table->integer('usage_limit_per_user')->nullable(); // Giới hạn số lần sử dụng mỗi user
            $table->integer('used_count')->default(0); // Số lần đã sử dụng
            $table->datetime('starts_at'); // Ngày bắt đầu
            $table->datetime('expires_at'); // Ngày kết thúc
            $table->boolean('is_active')->default(true); // Trạng thái
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
};
