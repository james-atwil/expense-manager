<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ExpensesExpensesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('expenses_expenses')->delete();
        
        \DB::table('expenses_expenses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 4,
                'name' => 'House Repair',
                'amount' => '1000.00',
                'entry_at' => '2022-07-28',
                'entry_by' => 1,
                'created_at' => '2022-07-28 07:52:05',
                'updated_at' => '2022-07-28 07:52:05',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'category_id' => 1,
                'name' => 'Travel Expense 100',
                'amount' => '2000.00',
                'entry_at' => '2022-07-26',
                'entry_by' => 1,
                'created_at' => '2022-07-28 08:08:28',
                'updated_at' => '2022-07-28 08:10:59',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'category_id' => 4,
                'name' => 'Office Repair',
                'amount' => '4000.00',
                'entry_at' => '2022-07-20',
                'entry_by' => 1,
                'created_at' => '2022-07-28 08:11:54',
                'updated_at' => '2022-07-28 08:12:39',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'category_id' => 2,
                'name' => 'Test',
                'amount' => '2000.00',
                'entry_at' => '2022-07-28',
                'entry_by' => 1,
                'created_at' => '2022-07-28 08:12:58',
                'updated_at' => '2022-07-28 08:12:58',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 6,
                'category_id' => 4,
                'name' => 'Office Repair One',
                'amount' => '2000.00',
                'entry_at' => '2022-07-19',
                'entry_by' => 57,
                'created_at' => '2022-07-28 08:46:21',
                'updated_at' => '2022-07-28 08:46:21',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 7,
                'category_id' => 1,
                'name' => 'Travel to Someland',
                'amount' => '5000.00',
                'entry_at' => '2022-07-26',
                'entry_by' => 57,
                'created_at' => '2022-07-28 08:46:36',
                'updated_at' => '2022-07-28 08:46:36',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 8,
                'category_id' => 2,
                'name' => 'Test',
                'amount' => '5000.00',
                'entry_at' => '2022-07-12',
                'entry_by' => 57,
                'created_at' => '2022-07-28 08:47:18',
                'updated_at' => '2022-07-28 08:47:18',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}