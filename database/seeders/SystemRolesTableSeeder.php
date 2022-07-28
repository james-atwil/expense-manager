<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('system_roles')->delete();
        
        \DB::table('system_roles')->insert(array (
            0 => 
            array (
                'id' => 1002,
                'slug' => 'admin',
                'name' => 'Administrator',
                'description' => 'The administrator manages the system in some extent, except for very technical issues.',
                'notes' => NULL,
                'created_at' => '2020-04-04 00:00:00',
                'updated_at' => '2021-12-18 14:51:47',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 1003,
                'slug' => 'user',
                'name' => 'User',
                'description' => 'Regular user.',
                'notes' => NULL,
                'created_at' => '2020-04-04 00:00:00',
                'updated_at' => '2022-07-26 21:45:44',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}