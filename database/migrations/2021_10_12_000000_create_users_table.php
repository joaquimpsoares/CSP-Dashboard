<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('username')->nullable()->index();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->default('\images\profile\profile.png');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->unsignedSmallInteger('notifications_preferences')->default(1);;
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('confirmation_token', 60)->nullable();
            $table->unsignedSmallInteger('status_id')->index()->default(5);

            $table->integer('two_factor_country_code')->nullable();
            $table->integer('two_factor_phone')->nullable();
            $table->text('two_factor_options')->nullable();
            $table->tinyInteger('removable')->default('0');
            $table->unsignedBigInteger('user_level_id')->nullable(false);
            $table->unsignedInteger('created_by')->default('0');
            $table->unsignedInteger('associated_id')->default('0');
            $table->boolean('notify')->default(false);
            $table->boolean('notified')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->foreign('reseller_id')->references('id')->on('resellers');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('user_level_id')->references('id')->on('user_levels');
            $table->foreign('status_id')->references('id')->on('statuses');

        });

        DB::statement("ALTER TABLE users AUTO_INCREMENT = 110000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
