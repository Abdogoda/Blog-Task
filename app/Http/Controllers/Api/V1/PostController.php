<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\ApiResponseTrait;
use App\Traits\ImageControlTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller{
    use ApiResponseTrait, ImageControlTrait;


    //###### function to retreive all auth user's posts
    public function index(){
        $posts = Post::with('tags')
            ->where('user_id', Auth::id()) // get only the posts related to the user
            ->orderBy('is_pinned', 'desc') // get the pinned posts first
            ->get();
            
        $posts = PostResource::collection($posts);
        
        return $this->success(['posts' => $posts], 'Posts retreived successfully');
    }


    //###### function to retreive all auth user's posts
    public function show(Post $post){
        //###### check if the authenticated user is the one who created this post
        Gate::authorize('update', $post);
        
        return $this->success(['post' => new PostResource($post->load("tags"))], 'Post retreived successfully');
    }


    //###### function to store a new post
    public function store(StorePostRequest $request){
        $data = $request->validated();
        $data['user_id'] =  Auth::id();

        //###### upload the image of the post
        if($request->hasFile('cover_image')){
            $file = $request->file("cover_image");
            $data['cover_image'] = $this->uploadImage($file, 'uploaded/posts');
        }

        //###### create the new post
        $post = Post::create($data);
        
        //###### attach tags to the new post
        $post->tags()->attach($data['tags']);
        
        return $this->success(['post' => new PostResource($post)], 'Post Created Successfully');
    }


    //###### function to update a post
    public function update(UpdatePostRequest $request, Post $post){
        //###### check if the authenticated user is the one who created this post
        Gate::authorize('update', $post);
        
        $data = $request->validated();

        //###### delete the old image and upload the new one
        if($request->hasFile('cover_image')){
            $this->deleteImage('uploaded/posts/'.$post->cover_image);
            
            $file = $request->file("cover_image");
            $data['cover_image'] = $this->uploadImage($file, 'uploaded/posts');
        }
        
        //###### update the post
        $post->update($data);

        //###### sync tags to the updated post if the request has tags
        if($request->has('tags')) $post->tags()->sync($data['tags']);

        return $this->success(['post' => new postResource($post)], 'Post Upadted Successfully');
    }


    //###### function to delete a post
    public function destroy(Post $post){
        //###### check if the authenticated user is the one who created this post
        Gate::authorize('delete', $post);

        //###### Softly delete the post
        $post->delete();
        return $this->success([], 'Post Deleted Successfully');
    }


    //###### function to retreive all auth user's deleted posts
    public function deleted(){
        $posts = Post::onlyTrashed()
            ->where('user_id', Auth::id()) // get only the posts related to the user
            ->get();
        $posts = PostResource::collection($posts);
        
        return $this->success(['posts' => $posts], 'Deleted Posts retreived successfully');
    }


    //###### function to restore a post
    public function restore(string $id){
        $post = post::onlyTrashed()->find($id);
        if(!$post){
            return $this->error('Post Not Found!', 404);
        }
        
        //###### check if the authenticated user is the one who created this post
        Gate::authorize('restore', $post);

        $post->restore();
        return $this->success(['post' => new postResource($post)], 'Post Restored Successfully');
    }
}