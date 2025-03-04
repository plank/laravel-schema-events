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
    }
};
