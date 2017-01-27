<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Alsofronie\Uuid\Uuid32ModelTrait;
use App\Models\LBM_conversation_item;
use Auth;

class LBM_conversation extends Model
{
    use Uuid32ModelTrait;

    protected $table = "LBM_conversations";

    public function items()
    {
    	return $this->hasMany("App\Models\LBM_conversation_item", "conversation_id")->orderBy("created_at");
    }

    public function users()
    {
        return $this->belongsToMany("App\Models\User", "LBM_conversation_users", "conversation_id", "user_id");
    }

    public function last_user()
    {
        return $this->belongsTo("App\Models\User", "last_user_id");
    }

    public function addMessage($content, $user = false)
    {
    	if (!$user && Auth::user())
    	{
    		$user = Auth::user();
    	}
    	$item = new LBM_conversation_item;
    	$item->conversation_id = $this->id;
    	$item->content = $content;
    	$item->save();
    }

    static public function boot()
    {
    	LBM_conversation::bootUuid32ModelTrait();
        LBM_conversation::saving(function ($conversation) {
        	if (Auth::user())
        	{
	            if ($conversation->id)
	            {
	            	$conversation->updated_by = Auth::user()->id;
	            }
	            else
	            {
					$conversation->created_by = Auth::user()->id;
	            }
	        }
        });
    }
}
