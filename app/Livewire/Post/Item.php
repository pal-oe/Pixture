<?php

namespace App\Livewire\Post;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use App\Notifications\NewCommentNotification;
use App\Notifications\PostLikedNotification;

class Item extends Component
{
    public Post $post;
    
    public $body;

    function togglePostLike(){
        abort_unless(boolean: auth()->check(), code: 401);

        auth()->user()->toggleLike($this->post);

        #send notifcation is post is liked 

        if ($this->post->isLikedBy(auth()->user())) {
           $this->post->user->notify(new PostLikedNotification(auth()->user(),$this->post));
        }
    }


    function toggleFavorite(){
        abort_unless(boolean: auth()->check(), code: 401);

        auth()->user()->toggleFavorite($this->post);
    }

    function toggleCommentLike( Comment $comment){
        abort_unless(boolean: auth()->check(), code: 401);

        auth()->user()->toggleLike($comment);
    
      
    }


   
    
    
    function addComment() {
        
        $this->validate(['body'=>'required']);

        #create comment 
        $comment=Comment::create([
            'body'=>$this->body,
            'commentable_id'=>$this->post->id,
            'commentable_type'=>Post::class,
            'user_id'=>auth()->id(),

        ]);

        $this->reset('body');
         #notify user 

        $this->post->user->notify(new NewCommentNotification(auth()->user(),$comment));

        
    }


    public function render()
    {
        return view('livewire.post.item');
    }
}    
