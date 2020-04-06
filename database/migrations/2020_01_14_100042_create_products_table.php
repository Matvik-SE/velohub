<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('category_id')->unsigned()->index();

            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_stock')->default(false)->index();
            $table->boolean('is_sale')->default(false)->index();
            $table->boolean('is_parent')->default(false)->index();

            $table->float('price')->nullable();
            $table->float('price_sale')->nullable();
            $table->integer('stock')->nullable();
            $table->float('weight')->nullable();

            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('latin')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();

            $table->text('brief')->nullable();
            $table->text('text')->nullable();
            $table->text('images')->nullable();
            $table->text('videos')->nullable();
            $table->text('files')->nullable();

            $table->jsonb('features')->nullable();
            $table->text('settings')->nullable();

            $table->timestamps();
        });

        DB::statement("ALTER TABLE products ADD COLUMN search tsvector");
        DB::statement("UPDATE products SET search = (setweight(to_tsvector(name), 'B') ||
            setweight(to_tsvector(brand), 'C') ||
            setweight(to_tsvector(model), 'A')) WHERE id > 0");
        DB::statement("CREATE INDEX products_search_index ON products USING GIN(search)");

        /*
        DB::statement("CREATE TRIGGER search_update AFTER INSERT OR UPDATE ON products
            FOR EACH ROW EXECUTE update_search()");
        */
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
}
