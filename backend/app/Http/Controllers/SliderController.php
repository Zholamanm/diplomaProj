<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        return Slider::orderBy('id', 'DESC')->paginate(20);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cover_image' => 'required|file|mimes:jpg,png,jpeg,gif|max:2048',
            'start_date' => 'date',
            'end_date' => 'date',
            'enabled' => 'nullable'
        ]);

        $slider = Slider::create([
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'enabled' => $validated['enabled'],
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('sliders', 'public');
            $slider->cover_image = $path;
            $slider->save();
        }

        return ['success' => true];
    }

    public function enable($id)
    {
        $slider = Slider::find($id);
        $slider->enabled = $slider->enabled === 1 ? 0 : 1;
        $slider->save();

        return ['success' => true];
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cover_image' => 'required|file|mimes:jpg,png,jpeg,gif|max:2048',
            'start_date' => 'date',
            'end_date' => 'date',
            'enabled' => 'nullable'
        ]);

        $slider = Slider::findOrFail($id);
        $slider->start_date = $validated['start_date'];
        $slider->end_date = $validated['end_date'];
        $slider->enabled = $validated['enabled'];

        if ($request->hasFile('cover_image')) {
            if ($slider->cover_image && Storage::disk('public')->exists($slider->cover_image)) {
                Storage::disk('public')->delete($slider->cover_image);
            }

            $path = $request->file('cover_image')->store('sliders', 'public');
            $slider->cover_image = $path;
        }

        $slider->save();

        return ['success' => true];
    }

    public function view($id)
    {
        return Slider::where('id', $id)->first();
    }

    public function destroy($id)
    {
        Slider::find($id)->delete();
        return ['success' => true];
    }
}
