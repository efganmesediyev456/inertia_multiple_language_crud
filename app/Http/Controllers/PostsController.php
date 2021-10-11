<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->except(["index"]);
    }

    public function index()
    {

        $datas=Post::orderBy('id', 'DESC')->select(["id","image","title->".app()->getLocale()." as tit","content->".app()->getLocale()." as cont"])->paginate(10);

        
        
        return Inertia::render('Posts/Index', [
            "posts" => $datas
        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store(Request $request)
    {

        $post = new Post();

        $translations = $request->input('title');

        $post->setTranslations('title', $translations);

        $translations = $request->input('content');

        $post->setTranslations('content', $translations);

        if($request->file('image')) {
            $post->image = $this->upload($request);
        }

        $post->save();

        $request->session()->flash('success', 'Post created successfully!');

        return redirect()->route('post.index');
    }

    public function edit($id)
    {
        return Inertia::render('Posts/Edit', [
            'post' => Post::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        // $this->getValidate($request, $id);

        $post = Post::find($id);

        

        $post->title = $request->input('title');
        $post->content = $request->input('content');

        if($request->file('image')) {
            $post->image = $this->upload($request);
        }

        $post->save();

        $request->session()->flash('success', 'Post updated successfully!');

        return redirect()->route('post.index');
    }

    public function destroy(Request $request, $id)
    {
        Post::find($id)->delete();

        $request->session()->flash('success', 'Post deleted successfully!');

        return redirect()->route('post.index');
    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    private function getValidate(Request $request, $id = null): void
    {
        $data = [
            'title' => 'required',
            'content' => 'required'
        ];

        $this->validate($request, $data);
    }

    private function upload($request)
    {
        $image = $request->file('image');

        $imageName = md5(uniqid()) . "." . $image->getClientOriginalExtension();

        $image->move(public_path('uploads'), $imageName);

        return $imageName;
    }
}