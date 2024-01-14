<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $settings = Settings::pluck('value','name');
        return view('admin.settings.edit', compact(['settings']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        foreach ($request->except('_token','_method') as $name => $value) {
            $setting = Settings::where('name',$name)->first();
            if ($setting) {
                $setting->value   = $value;
                $setting->save();
            } else {
                $setting          = new Settings();
                $setting->name    = $name;
                $setting->value   = $value;
                $setting->save();
            }
        }
        session()->flash('success', 'تم حفظ الإعدادات بنجاح');
        return back();
    }
}
