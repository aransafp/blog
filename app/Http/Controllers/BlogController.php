<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function index()
    {
        $blogs = Blog::all();
        return $blogs;
    }

    public function findById($id)
    {
        try {
            $blogs = Blog::findOrFail($id);

            return response()->json($blogs, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'blog not found'], 404);
        }
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
            'author' => 'required'
        ]);

        $blog = Blog::create($request->all());
        return response()->json($blog, 201);
    }

    public function update($id, Request $request)
    {
        $blog = Blog::findOrFail($id);

        $blog->update($request->all());

        return response()->json(["message" => $blog], 201);
    }

    public function delete($id)
    {
        try {
            $blog = Blog::findOrFail($id);
        } catch (\Throwable $th) {
            return response()->json(['message' => "blog doesn't exist"], 404);
        }

        $blog->delete();
        return response()->json(['message' => 'delete successfully'], 200);
    }
}
