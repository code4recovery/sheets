<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar');
            $table->string('locale');
            $table->string('google_id');
            $table->string('token');
            $table->dropColumn('password');
        });

        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('meetings')->default(0);
            $table->string('spreadsheet_id');
            $table->string('sheet_id');
            $table->string('timezone');
            $table->string('website');
            $table->timestamp('refreshed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('feed_user', function (Blueprint $table) {
            $table->unsignedBigInteger('feed_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('feed_id')->references('id')->on('feeds');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::dropIfExists('password_resets');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_user');

        Schema::dropIfExists('feeds');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('locale');
            $table->dropColumn('google_id');
            $table->dropColumn('token');
            $table->string('password');
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }
}
