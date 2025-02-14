<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW post_authors AS
            SELECT 
                posts.title,
                users.name as author_name
            FROM posts
            LEFT JOIN users ON posts.author_id = users.id
        ");
    }
};