<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($query = $request->query('q')) {
            // Replace separators on comma
            $query = str_replace(' ', ',', $query);

            // Get tags matched entities
            $posts = Post::whereRaw('jsonb_exists_any(tags, string_to_array(?,\',\'))', [$query]);
        } else {
            $posts = new Post();
        }

        return view('post.index',
            ['posts' => $posts->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(15)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\StorePostRequest $request
     */
    public function store(Requests\StorePostRequest $request)
    {
        // Create a new entity
        $post = new Post();

        // Purify post body, rm script tags
        $post->body = clean($request->input('body'));

        // Fill tags
        $post->tags = $request->input('tags');

        // Save image
        if ($file = $request->file('image')) {
            $post->saveImage($file);
        }

        // Add author
        if ($user = Auth::user()) {
            $post->user_id = $user->id;
        }

        // Fill non handled attributes
        $post->fill($request->only(['title', 'tags', 'created_at']));

        // Save post
        $post->save();

        return response()->json([
            'status' => 'success',
            'text' => trans('post.create.process.success')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('post.show', ['post' => Post::with('user')->find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
