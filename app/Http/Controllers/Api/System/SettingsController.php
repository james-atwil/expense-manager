<?php

namespace App\Http\Controllers\Api\System;

use App\Http\Controllers\Api\BaseController;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends BaseController
{
    public function list(Request $request) : array
    {
        return settings();
    }

    public function updateMultiple(Request $request) : array
    {
        $settings = $request->get('settings');

        foreach ($settings as $k => $value) {
            Setting::where('key', '=', $k)->update(['value' => $value]);
        }

        return settings();
    }
}
