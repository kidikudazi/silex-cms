<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('type');
            $table->json("role");
            $table->timestamps();
        });

        # Set default timezone
        date_default_timezone_set('Africa/Lagos');

        $roleData = [[
            "blog" => true,
            "account" => true,
            "videos" => true,
            "gallery" => true,
            "team" => true,
            "partners" => true,
            "page_builder" => true,
            "site_settings" => true
        ]];

        # create default data
        DB::table('user_roles')->insert([
            'user_id'=>1,
            'type'=>'admin',
            'role' => json_encode($roleData)
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
