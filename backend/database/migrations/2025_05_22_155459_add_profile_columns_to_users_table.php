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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_picture')->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('profile_picture');
            $table->string('nationality', 100)->nullable()->after('date_of_birth');
            $table->text('address')->nullable()->after('nationality');
            $table->string('phone', 20)->nullable()->after('address');
            $table->text('bio')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profile_picture',
                'date_of_birth',
                'nationality',
                'address',
                'phone',
                'bio'
            ]);
        });
    }
};
