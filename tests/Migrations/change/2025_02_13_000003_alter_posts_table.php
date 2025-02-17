<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('subtitle')->after('title');
            $table->string('slug')->after('subtitle');
            $table->unique('slug');
            $table->longText('body')->change();
            $table->foreignId('publisher_id')->constrained();
            $table->string('published_at');
            $table->index(['published_at']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('description', 'blurb');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('teaser');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['tag']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->renameIndex('posts_category_index', 'category_index');
        });
    }
};
