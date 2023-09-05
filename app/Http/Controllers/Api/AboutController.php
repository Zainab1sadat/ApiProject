<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutRequest;
use App\Http\Resources\AboutResource;
use App\Models\About;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::all();
        if (count($about) > 0) {
            return AboutResource::collection($about);
        } else {
            return response()->json([
                'message' => 'No about yet'
            ]);
        }
    }

    public function store(AboutRequest $request)
    {
        $about = About::create([
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'description' => $request->description
        ]);

        return AboutResource::make($about);
    }

    public function update(AboutRequest $request, string $id)
    {

        $about = About::find($id);
        $about->title = $request->title;
        $about->sub_title = $request->sub_title;
        $about->description = $request->description;
        $about->save();
        return AboutResource::make($about);
    }

    public function destroy(string $id)
    {
        $about = About::findOrfail($id);
        $about->delete();
        return 'deleted';
    }
}
