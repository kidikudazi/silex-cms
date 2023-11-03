<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $opening_hour = "8:00";
        $closing_hour = "4:00";
        $phones = (Object) [
            "first" => "08012345678",
            "second" => "09012345678"
        ];
        $socials = (Object) [
            "facebook" => "",
            "twitter" => "",
            "youtube" => "",
            "instagram" => ""
        ];
        $address = "15b Muhammed Yahaya Way, Abuja";
        SiteSetting::create([
            "opening_hour" => $opening_hour,
            "closing_hour" => $closing_hour,
            "phone_numbers" => json_encode($phones),
            "socials" => json_encode($socials),
            "address" => $address
        ]);
    }
}