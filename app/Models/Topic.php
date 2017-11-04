<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'user_id', 'category_id', 'reply_count', 'view_count', 'last_reply_user_id', 'order', 'excerpt', 'slug'];

    public function category()
    {
      return $this->belongsTo(Category::class,'category_id');
    }

    public function user()
    {
      return $this->belongsTo(User::class,'user_id');
    }

    public function scopeWithOrder($query,$order)
    {
      switch ($order) {
        case 'recent':
          $query = $this->recent();
          break;

        default:
          $query = $this->recentReplied();
          break;
      }
      return $query->with('user','category');
    }

    public function scopeRecentReplied($query)
    {
      return $this->orderBy('updated_at','desc');
    }
    public function scopeRecent($query)
    {
      return $query->orderBy('created_at','desc');
    }

}
