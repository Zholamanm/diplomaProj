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
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->enum('status', ['borrowed', 'returned', 'received'])->default('borrowed');
        });
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->date('received_at')->after('due_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->enum('status', ['borrowed', 'returned'])->default('borrowed');
        });
        Schema::table('borrowed_books', function (Blueprint $table) {
            $table->dropColumn('received_at');
        });
    }
};
