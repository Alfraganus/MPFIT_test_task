<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->unsignedBigInteger('category_id');
            $table->text('description');
            $table->unsignedBigInteger('price');
            $table->integer('quantity')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->integer('status');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        DB::table('products')->insert([
            ['product_name' => 'Бородинский хлеб', 'category_id' => 1, 'description' => 'Традиционный ржаной хлеб с кориандром.', 'price' => 120, 'quantity' => 100, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Пельмени "Сибирская коллекция"', 'category_id' => 1, 'description' => 'Мясные пельмени из говядины и свинины.', 'price' => 450, 'quantity' => 50, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Икра красная "Русское море"', 'category_id' => 1, 'description' => 'Качественная лососевая икра для праздничного стола.', 'price' => 2500, 'quantity' => 20, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Шоколад "Аленка"', 'category_id' => 1, 'description' => 'Классический молочный шоколад.', 'price' => 150, 'quantity' => 200, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Чай "Принцесса Нури"', 'category_id' => 1, 'description' => 'Черный байховый чай высокого качества.', 'price' => 200, 'quantity' => 150, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Варенье из малины "Махеев"', 'category_id' => 1, 'description' => 'Натуральное малиновое варенье без консервантов.', 'price' => 300, 'quantity' => 80, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Сгущенное молоко "Рогачев"', 'category_id' => 1, 'description' => 'Классическое сгущенное молоко ГОСТ.', 'price' => 180, 'quantity' => 120, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Колбаса "Докторская"', 'category_id' => 1, 'description' => 'Мягкая вареная колбаса из свинины и говядины.', 'price' => 550, 'quantity' => 60, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Мороженое "Чистая Линия"', 'category_id' => 1, 'description' => 'Натуральное мороженое без искусственных добавок.', 'price' => 250, 'quantity' => 100, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Водка "Белуга"', 'category_id' => 2, 'description' => 'Премиальная русская водка.', 'price' => 3500, 'quantity' => 30, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Квас "Очаковский"', 'category_id' => 2, 'description' => 'Традиционный русский квас.', 'price' => 90, 'quantity' => 500, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Сковорода "Нева Металл Посуда"', 'category_id' => 3, 'description' => 'Алюминиевая сковорода с антипригарным покрытием.', 'price' => 1500, 'quantity' => 75, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Стиральный порошок "Миф"', 'category_id' => 3, 'description' => 'Популярный российский стиральный порошок.', 'price' => 350, 'quantity' => 200, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Зубная паста "Лесной бальзам"', 'category_id' => 3, 'description' => 'Натуральная паста с экстрактами трав.', 'price' => 120, 'quantity' => 300, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Часы "Ракета"', 'category_id' => 1, 'description' => 'Российские механические часы.', 'price' => 15000, 'quantity' => 10, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Ноутбук "IRBIS"', 'category_id' =>2, 'description' => 'Доступный российский ноутбук.', 'price' => 25000, 'quantity' => 40, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Смартфон "BQ"', 'category_id' => 3, 'description' => 'Бюджетный российский смартфон.', 'price' => 9000, 'quantity' => 150, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Пылесос "Polaris"', 'category_id' => 1, 'description' => 'Компактный пылесос с мощной тягой.', 'price' => 8000, 'quantity' => 50, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Телевизор "DEXP"', 'category_id' => 2, 'description' => 'Российский телевизор с хорошими характеристиками.', 'price' => 28000, 'quantity' => 30, 'created_at' => now(), 'status' => 1],
            ['product_name' => 'Утюг "Scarlett"', 'category_id' => 3, 'description' => 'Недорогой и качественный утюг.', 'price' => 2500, 'quantity' => 150, 'created_at' => now(), 'status' => 1],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
