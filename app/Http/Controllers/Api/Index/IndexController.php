<?php

namespace App\Http\Controllers\Api\Index;

use App\Http\Controllers\Api\BlankController;
use App\Models\Expenses\Category;
use App\Models\Expenses\Expense;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class IndexController extends BlankController
{
    public function dashboard(): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = auth()->user();

        $data = [
            'chart01' => [
                'series' => [],
                'labels' => []
            ],
            'table01' => [
                'data' => [],
                'total' => ""
            ]
        ];

        $categories = Category::all();
        $total = 0;

        foreach ($categories as $category) {
            $sum = Expense::where('entry_by', '=', $currentUser->id)
                ->where('category_id', '=', $category->id)
                ->sum('amount');

            $data['chart01']['series'][] = (float) $sum;
            $data['chart01']['labels'][] = $category->name;

            $data['table01']['data'][] = [
                'name' => $category->name,
                'amount' => $sum
            ];

            $total += (float) $sum;
        }

        $data['table01']['total'] = number_format($total, 2);

        return response()->json($data);
    }
}
