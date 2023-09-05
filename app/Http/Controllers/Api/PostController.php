<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostCreateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();
        if (count($post) > 0) {
            return PostResource::collection($post);
        } else {
            return response()->json([
                'message' => 'no post yet',
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $image_new_name = "";
        if ($request->has('image')) {
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('upload', $image_new_name);
        }

        $post = Post::create(['title' => $request->title, 'sub_title' => $request->sub_title, 'price' => $request->price, 'description' => $request->description, 'image' => $image_new_name, 'user_id' => Auth::user()->id]);



        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return PostResource::make(Post::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCreateRequest $request, string $id)
    {
        $post = Post::find($id);
        if ($request->has('image')) {
            File:
            unlink('upload/' . $post->image);
            $image = $request->image;
            $image_new_name = time() . $image->getClientOriginalName();
            $image->move('upload', $image_new_name);
            $post->image = $image_new_name;
            $post->save();
        }
        $post->title = $request->title;
        $post->sub_title = $request->sub_title;
        $post->price = $request->price;
        $post->description = $request->description;
        $post->save();

        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrfail($id);
        $post->delete();
        return 'deleted';
    }
}
