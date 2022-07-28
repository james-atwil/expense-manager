<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SystemSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('system_settings')->delete();
        
        \DB::table('system_settings')->insert(array (
            0 => 
            array (
                'key' => 'admin.ipp',
                'value' => '20',
                'datatype' => 'int',
                'created_at' => '2020-04-04 00:00:00',
                'updated_at' => '2021-12-19 23:11:41',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'key' => 'admin.meta.description',
                'value' => NULL,
                'datatype' => 'string',
                'created_at' => '2020-04-04 00:00:00',
                'updated_at' => '2021-12-19 23:11:41',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'key' => 'admin.meta.name',
                'value' => 'Expense Manager',
                'datatype' => 'string',
                'created_at' => '2020-04-04 00:00:00',
                'updated_at' => '2021-12-19 23:11:41',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'key' => 'admin.meta.separator',
                'value' => ':',
                'datatype' => 'string',
                'created_at' => '2020-04-04 00:00:00',
                'updated_at' => '2021-12-19 23:11:41',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'key' => 'admin.meta.title',
                'value' => 'Expense Manager',
                'datatype' => 'string',
                'created_at' => '2020-04-04 00:00:00',
                'updated_at' => '2021-12-19 23:11:41',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}