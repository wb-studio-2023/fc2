<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Query\JoinClause;

class Article extends Model
{
    use HasFactory;

    const TABLE_ABBREVIATED_NAME = 'ar.';

    public function getList($arrayRequest, $convertRequest)
    {
        $columnList = [
            'ar.id',
            'ar.title',
            'ar.watch',
            'ar.like',
            'ar.status',
            'ar.delete_flg',
            'ar.release_at',
            'ar.created_at',
            'ar.updated_at',
        ];

        $query = DB::table('articles as ar');

        $query->select($columnList);
        $query->where('ar.delete_flg', config('const.DELETE_FLG_OFF'));
        
        //keyword検索
        if (isset($arrayRequest['keyword']) && $arrayRequest['keyword'] != '') {
            $keyWord = '%' . addcslashes($arrayRequest['keyword'], '%_\\') . '%';
            $query
                ->where(function ($query) use ($keyWord) {
                    $query
                    ->orwhere('ar.title', 'like', $keyWord)
                    ->orwhere('ar.headline', 'like', $keyWord)
                    ->orwhere('ar.main', 'like', $keyWord);
                });
        }

        //status検索
        if (isset($convertRequest['status']) && !(count($convertRequest['status']) == count(config('const.ARTICLE.STATUS')))) {
            //1つ選択
            if (count($convertRequest['status']) == 1) {
                if ($convertRequest['status'][0] == config('const.ARTICLE.STATUS.RELEASED.SEARCH_NUMBER')) {
                    $query
                        ->where('ar.status', config('const.ARTICLE.STATUS.RELEASED.NUMBER'))
                        ->where('ar.release_at', '<', DB::raw('NOW()'));
                } else if ($convertRequest['status'][0] == config('const.ARTICLE.STATUS.PREPARATION.SEARCH_NUMBER')) {
                    $query->where('ar.status', config('const.ARTICLE.STATUS.PREPARATION.NUMBER'));
                } else if ($convertRequest['status'][0] == config('const.ARTICLE.STATUS.WAITING.SEARCH_NUMBER')){
                    $query
                        ->where('ar.status', config('const.ARTICLE.STATUS.RELEASED.NUMBER'))
                        ->where('ar.release_at', '>', DB::raw('NOW()'));
                }                
            //2つ選択
            } else if (count($convertRequest['status']) == 2) {
                if (!in_array( config('const.ARTICLE.STATUS.RELEASED.SEARCH_NUMBER'), $convertRequest['status'])) {
                    $query->where('status', config('const.ARTICLE.STATUS.PREPARATION.NUMBER'))
                        ->orWhere(function ($query) {
                            $query->where('status', config('const.ARTICLE.STATUS.WAITING.NUMBER'))
                                ->where('release_at', '>', DB::raw('NOW()'));
                        });
                } elseif (!in_array( config('const.ARTICLE.STATUS.PREPARATION.SEARCH_NUMBER'), $convertRequest['status'])) {
                    $query->where('status', config('const.ARTICLE.STATUS.RELEASED.NUMBER'));
                } else if (!in_array( config('const.ARTICLE.STATUS.WAITING.SEARCH_NUMBER'), $convertRequest['status'])) {
                    $query->where('status', config('const.ARTICLE.STATUS.PREPARATION.NUMBER'))
                        ->orWhere(function ($query) {
                            $query->where('status', config('const.ARTICLE.STATUS.RELEASED.NUMBER'))
                                ->where('release_at', '<', DB::raw('NOW()'));
                        });
                }                
            }
        }

        //sort
        $sortType = config('const.SORT_TYPE.d');
        $sortKind = 'updated_at';
        if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] != NULL ) {
            $sortType = config('const.SORT_TYPE.' . $arrayRequest['st']);
            $sortKind = self::TABLE_ABBREVIATED_NAME . $arrayRequest['sk'];
        }
        $query->orderBy($sortKind, $sortType);

        $retList = $query->paginate(config('const.ADMIN.LIST_PER_PAGE'));

        return $retList;
    }

    public function insertData($inputData)
    {
        $query = DB::table('articles');

        $value = [
            'site_id' => $inputData['site_id'],
            'movie_id' => $inputData['movie_id'],
            'actress_id' => $inputData['actress'],
            'title' => $inputData['title'],
            'headline' => $inputData['headline'],
            'eyecatch' => $inputData['eyecatch'],
            'main' => $inputData['main'],
            'category' => $inputData['category'],
            'tag' => $inputData['tag'],
            'type' => 0,
            'status' => $inputData['status'],
            'delete_flg' => config('const.DELETE_FLG_OFF'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        return $query->insertGetId($value);
    }

    public function getDataById($request)
    {
        $columnList = [
            'ar.id',
            'ar.site_id',
            'ar.movie_id',
            'ar.title',
            'ar.headline',
            'ar.eyecatch',
            'ar.main',
            'ar.actress_id',
            'ar.category',
            'ar.tag',
            'ar.type',
            'ar.status',
            'ar.delete_flg',
            'ar.created_at',
            'ar.updated_at',
        ];

        $query = DB::table('articles as ar');

        $query->select($columnList);

        $query->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('ar.id', $request->article_id);
            
        $retData = $query->first();

        return $retData;
    }

    public function updateData($inputData)
    {

        $query = DB::table('articles');
        $value = [
            'site_id' => $inputData['site_id'],
            'movie_id' => $inputData['movie_id'],
            'actress_id' => $inputData['actress'],
            'title' => $inputData['title'],
            'headline' => $inputData['headline'],
            'eyecatch' => $inputData['eyecatch'],
            'main' => $inputData['main'],
            'category' => $inputData['category'],
            'tag' => $inputData['tag'],
            'type' => 0,
            'status' => $inputData['status'],
            'updated_at' => now(),
        ];

        $query->where('id', $inputData['id']);
        $query->update($value);
    }

    public function deleteData($deleteIds)
    {
        $value = [
            'delete_flg' => config('const.DELETE_FLG_ON'),
            'updated_at' => now(),
        ];

        if (isset($deleteIds)) {
            $query = DB::table('articles');
            $query->whereIn('id', $deleteIds);
            $query->update($value);
        }
    }

    public function getListByRequest($request, $contentsCount)
    {
        $columnList = [
            'ar.id',
            'ar.title',
            'ar.eyecatch',
            'ar.created_at',
            'ar.updated_at',
        ];

        $query = DB::table('articles as ar');

        $query->select($columnList);
        $query->where('ar.delete_flg', config('const.DELETE_FLG_OFF'));
        
        // 女優
        if (isset($request->actress_id)) {
            $query->whereRaw("FIND_IN_SET('". $request->actress_id . "', ar.actress_id) > 0");
        }
        
        // カテゴリー
        if (isset($request->category_id)) {
            $query->where( $request->category_id , 'ar.category_id');
        }
        
        // タグ
        if (isset($request->tag_id)) {
            $query->whereRaw("FIND_IN_SET('". $request->tag_id . "', ar.tag) > 0");
        }

        // 記事
        if (isset($request->keyword) && $request->keyword != '') {
            $keyWord = '%' . addcslashes($request->keyword, '%_\\') . '%';
            $query
                ->where(function ($query) use ($keyWord) {
                    $query
                    ->orwhere('ar.title', 'like', $keyWord)
                    ->orwhere('ar.headline', 'like', $keyWord)
                    ->orwhere('ar.main', 'like', $keyWord);
                }
            );
        }

        $query->orderBy('ar.created_at');

        $retList = $query->paginate($contentsCount);

        return $retList;
    }

    public function getSlideArticleList($contentsCount)
    {
        $top100Articles = DB::table('articles')
            ->orderBy('order', 'desc')
            ->limit(100)
            ->get();

        $randomArticles = collect($top100Articles)->shuffle()->take(6);

        return $randomArticles;
    }

    public function getLatestArticleList($contentsCount)
    {
        $columnList = [
            'ar.id',
            'ar.title',
            'ar.eyecatch',
            'ar.created_at',
            'ar.updated_at',
        ];

        $query = DB::table('articles as ar');

        $query->select($columnList);
        $query->where('ar.delete_flg', config('const.DELETE_FLG_OFF'));
        
        $query->orderBy('ar.order', 'DESC');

        $retList = $query->paginate($contentsCount);

        return $retList;
    }

    public function getRecommendArticleList($contentsCount)
    {
        $columnList = [
            'ar.id',
            'ar.title',
            'ar.eyecatch',
            'ar.created_at',
            'ar.updated_at',
        ];

        $query = DB::table('articles as ar');

        $query->select($columnList);
        $query->where('ar.delete_flg', config('const.DELETE_FLG_OFF'));
        
        $query->orderBy('ar.updated_at', 'DESC');

        $retList = $query->paginate($contentsCount);

        return $retList;
    }

    public function scrapingBulkInsert($value)
    {
        DB::table('articles')->upsert(
            $value,
            ['site_id', 'movie_id'],
            ['actress_id', 'title', 'headline', 'eyecatch', 'main', 'category', 'tag', 'type', 'status', 'delete_flg', 'created_at', 'updated_at']
         );
    }

    public function getMaxOrderArticles()
    {
        // ar.orderの最大値を取得するSQLクエリを準備
        $maxOrder = DB::table('articles as ar')
                    ->selectRaw('MAX(ar.order) as max_order')
                    ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
                    ->first();

        // 最大値を取得できなかった場合はデフォルト値として0を返す
        $maxCount = $maxOrder ? $maxOrder->max_order : 0;

        return $maxCount;
    }

    public function getMaxOrderArticleId()
    {
        $maxOrderData = DB::table('articles as ar')
                    ->selectRaw('movie_id')
                    ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
                    ->orderBy('ar.order', 'DESC')
                    ->first();

        // 最大値を取得できなかった場合はデフォルト値として0を返す
        $maxOrderMovieId = $maxOrderData ? $maxOrderData->movie_id : 0;

        return $maxOrderMovieId;
    }

    public function getNullOrderArticles($batchSize)
    {
        $columnList = [
            'ar.id',
            'ar.order',
        ];
    
        $query = DB::table('articles as ar');
    
        $query->select($columnList)
            ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('ar.site_id', config('const.SITE.FC2'))
            ->whereNull('ar.order')
            ->orderBy('id', 'desc')
            ->limit($batchSize);
    
        $retList = $query->get();
    
        return $retList;
    }

    public function updateOrderToArticles($value)
    {
        DB::table('articles')->upsert(
            $value, 
            ['id'], 
            ['order', 'updated_at']
        );
    }

    public function updateByScraping($articleValue)
    {

        $query = DB::table('articles');
        $value = [
            'tag' => $articleValue['tag'],
            'status' => config('const.ARTICLE.STATUS.RELEASED.NUMBER'),
            'updated_at' => now(),
        ];

        $query->where('movie_id', (string)$articleValue['movie_id']);
        $query->update($value);
    }

    public function getArticleListDivideTen($number)
    {
        $columnList = [
            'ar.id as article_id',
            'ar.site_id',
            'ar.movie_id',
        ];
    
        $query = DB::table('articles as ar');
    
        $query->select($columnList)
            ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('ar.status', config('const.ARTICLE.STATUS.PREPARATION.NUMBER'))
            // ->whereRaw('ar.id % 10 = ' . $number)
            ->orderBy('ar.order', 'desc')
            ->limit(10);
    
        $retList = $query->get();
    
        return $retList;
    }

    public function getDataByIdForFront($request)
    {
        $articleData = DB::table('articles as ar')
            ->select([
                'ar.id',
                'ar.title',
                'ar.eyecatch',
                'ar.movie_id',
                'ar.tag',
                'ar.type',
                'ar.status',
                'ar.delete_flg',
                'ar.created_at',
                'ar.updated_at',
            ])
            ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('ar.id', $request->article_id)
            ->first();
    
        $imageData = DB::table('articles as ar')
            ->leftJoin('article_images AS ai', 'ar.id', '=', 'ai.article_id')
            ->select([
                'ai.id as image_id',
                'ai.path',
            ])
            ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('ar.id', $request->article_id)
            ->get();
    
        $tagData = DB::table('articles as ar')
            ->leftJoin('tags AS ta', function ($join) {
                $join->on(DB::raw('FIND_IN_SET(ta.id, ar.tag)'), '>', DB::raw('0'));
            })
            ->select([
                'ta.id',
                'ta.name',
            ])
            ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('ar.id', $request->article_id)
            ->get();
    
        $mergedData = [
            'id' => $articleData->id,
            'title' => $articleData->title,
            'eyecatch' => $articleData->eyecatch,
            'movieId' => $articleData->movie_id,
            'type' => $articleData->type,
            'tag' => $articleData->tag,
            'status' => $articleData->status,
            'delete_flg' => $articleData->delete_flg,
            'created_at' => $articleData->created_at,
            'updated_at' => $articleData->updated_at,
            'image' => $imageData->toArray(),
            'tags' => $tagData->toArray(),
        ];
    
        return $mergedData;
    }

    public function getRelativeArticleListByIdForFront($articleData)
    {
        $articleTags = explode(',', $articleData['tag']); // 検索条件のタグを配列に分割

        $columnList = [
            'ar.id',
            'ar.title',
            'ar.eyecatch',
            'ar.created_at',
            'ar.updated_at',
        ];

        $relatedArticleList = DB::table('articles as ar')
            ->select($columnList)
            ->where('ar.delete_flg', 0) // 削除されていない記事を選択
            ->where('ar.id', '!=', $articleData['id']) // 自身の記事以外
            ->where(function ($query) use ($articleTags) {
                foreach ($articleTags as $tag) {
                    $query->orWhere('ar.tag', 'like', '%' . $tag . '%');
                }
            })
            ->orderByDesc('ar.order')
            ->limit(20)
            ->get();

        return $relatedArticleList;
    }
}
