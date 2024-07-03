<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ArticleImage extends Model
{
    use HasFactory;

    
    public function insertByScraping($value)
    {
        DB::transaction(function () use ($value) {
            DB::table('article_images')->upsert(
                $value, 
                ['path', 'article_id'], 
                ['path', 'article_id', 'site_id', 'movie_id', 'created_at', 'updated_at']
            );
        });
    }
}
