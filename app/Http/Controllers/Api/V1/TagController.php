<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class TagController extends Controller{
    use ApiResponseTrait;

    //###### function to retreive all tags
    public function index(){
        $tags = TagResource::collection(Tag::all());
        
        return $this->success(['tags' => $tags], 'Tags retreived successfully');
    }

    //###### function to store a new tag
    public function store(StoreTagRequest $request){
        $tag = Tag::create(['name' => $request->name]);
        return $this->success(['tag' => new TagResource($tag)], 'Tag Created Successfully');
    }

    //###### function to update a tag
    public function update(UpdateTagRequest $request, Tag $tag){
        $tag->update($request->validated());
        return $this->success(['tag' => new TagResource($tag)], 'Tag Upadted Successfully');
    }

    //###### function to delete a tag
    public function destroy(Tag $tag){
        $tag->delete();
        return $this->success([], 'Tag Deleted Successfully');
    }
}