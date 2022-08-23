<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            'description'=>"An online auction project that holds online auctions of various products on a website and serves sellers and bidders accordingly.

            The system is designed to allow users to set up their products for auctions and bidders to register and bid for various products available for bidding.",
            'short_des'=>"Online Auction management system is a web based application which will help users to buy or sell items; they can trade anything they want by posting ad .",
            'photo'=>"image.jpg",
            'logo'=>'logo.jpg',
            'address'=>" Bahir Dar",
            'email'=>"hyihune@gmail.com",
            'phone'=>"+251918509520",
        );
        DB::table('settings')->insert($data);
    }
        //
    }

