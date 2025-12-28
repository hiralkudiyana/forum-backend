<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');

        $table->unsignedBigInteger('category_id'); // explicit

        $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');

        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
