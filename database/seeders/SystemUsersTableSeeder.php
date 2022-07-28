<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('system_users')->delete();
        
        \DB::table('system_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin@test.com',
                'email' => 'admin@test.com',
                'password' => '$2y$10$a6P8otBqvWnmAvp8BTqiJ.XI4xll5fruTeqqcGlMyXL0OdE8Hs70C',
                'name_display' => 'James Atwil',
                'role_id' => 1002,
                'is_active' => 1,
                'remember_token' => 'BNXuFIPmh46GsLBkGJIJDjxVvg9xk2vIOnkRuLSKn71SDB5V6b8wdK9TOEa4',
                'notes' => NULL,
                'created_at' => '2021-12-27 20:07:32',
                'updated_at' => '2022-07-28 11:17:23',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 57,
                'name' => 'joe@test.com',
                'email' => 'joe@test.com',
                'password' => '$2y$10$25sJvlfKTVB/y8rpc9OYtuTk/XcVsQ3e/TM7WOdWH6A1DJkpnysdu',
                'name_display' => 'Johnny Pecados',
                'role_id' => 1003,
                'is_active' => 1,
                'remember_token' => 'hnnQIPbT8OnK79RWlwjpkesyFEubdytplGbNfgVyAvI8kfkwpK5Eho6yj9Fb',
                'notes' => NULL,
                'created_at' => '2021-12-27 20:07:32',
                'updated_at' => '2021-12-27 20:08:19',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}