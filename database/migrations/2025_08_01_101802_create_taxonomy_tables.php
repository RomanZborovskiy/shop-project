<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomyTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createTermsTable();

        $this->createTermablesTable();
    }

    /**
     * Taxonomy terms table
     */
    public function createTermsTable()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id('id');

            $table->string('name');
            $table->string('slug')->nullable()->index();
            $table->text('body')->nullable();
            $table->text('description')->nullable();


            $table->integer('weight')->default(0);
            $table->boolean('has_nested')->default(false);
            // Used Nested https://github.com/lazychaser/laravel-nestedset
            $table->unsignedInteger('_lft')->default(0);
            $table->unsignedInteger('_rgt')->default(0);
            $table->unsignedInteger('parent_id')->nullable();

            $table->string('vocabulary')->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function createTermablesTable()
    {
         Schema::create('termables', function (Blueprint $table) {
             $table->foreignId('term_id')->constrained()->onDelete('CASCADE');
             $table->morphs('termable');
             $table->unsignedInteger('weight')->default(0);
             $table->string('comment')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('termables');
        Schema::dropIfExists('terms');
    }
}
