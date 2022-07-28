<?php

use App\Models\Role;
use App\Models\Setting;

/**
 * @param  string  $key
 *
 * @return array|string|Role|null
 */
function settings(string $key = '') : array|string|Role|null
{
    try {
        $value = function ($setting) {
            switch ($setting->datatype) {
                case 'string':
                default:
                    return $setting->value;

                case 'int':
                    return (int) $setting->value;

                case 'double':
                    return (double) $setting->value;

                case 'float':
                    return (float) $setting->value;

                case 'boolean':
                    return (bool) $setting->value;

                case 'csv':
                    return str_getcsv($setting->value);

                case 'Role':
                    if (empty($setting->value)) {
                        $role       = new Role();
                        $role->id   = null;
                        $role->slug = null;
                        $role->name = null;
                    } else {
                        $role = Role::find($setting->value);
                        $role?->makeHidden(['description']);

                    }

                    return $role;
            }
        };

        if (!empty($key)) {
            $setting = Setting::findOrFail($key);
            return $value($setting);

        } else {
            $settings = Setting::all();

            $array = [];
            foreach ($settings as $setting) {
                $array[$setting->key] = $value($setting);
            }

            return $array;
        }
    } catch (Exception $e) {
        return null;
    }
}

function ts() : string
{
    $setting = Setting::find('admin.meta.separator');

    if ($setting) {
        return ' ' . $setting->value . ' ';
    } else {
        return ' - ';
    }
}
