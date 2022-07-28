<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExpensesCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('expenses_categories')->delete();
        
        \DB::table('expenses_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slug' => NULL,
                'name' => 'Travel',
                'description' => NULL,
                'created_at' => '2022-07-27 20:43:05',
                'updated_at' => '2022-07-28 08:04:48',
            ),
            1 => 
            array (
                'id' => 2,
                'slug' => NULL,
                'name' => 'Entertainment',
                'description' => 'Having fun.',
                'created_at' => '2022-07-27 20:43:29',
                'updated_at' => '2022-07-28 08:08:51',
            ),
            2 => 
            array (
                'id' => 4,
                'slug' => NULL,
                'name' => 'Repair',
                'description' => 'Needed to make some physical fixes.',
                'created_at' => '2022-07-27 20:56:00',
                'updated_at' => '2022-07-27 20:56:00',
            ),
        ));
        
        
    }
}