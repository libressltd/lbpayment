<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;
use Auth;

class LBM_conversation_item extends Model
{
    use Uuid32ModelTrait;

    protected $table = "LBM_conversation_items";

    public function conversation()
    {
        return $this->belongsTo("App\Models\LBM_conversation", "conversation_id");
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "created_by");
    }

    static public function boot()
    {
    	LBM_conversation_item::bootUuid32ModelTrait();
        LBM_conversation_item::saving(function ($item) {
        	if (Auth::user())
        	{
	            if ($item->id)
	            {
	            	$item->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$item->created_by = Auth::user()->id;
                    $conversation = $item->conversation;
                    $conversation->last_user_id = $item->created_by;
                    $conversation->last_content = $item->content;
                    $conversation->save();
	            }
                $item->conversation->users()->syncWithoutDetaching([Auth::user()->id]);
	        }
        });
    }
}
