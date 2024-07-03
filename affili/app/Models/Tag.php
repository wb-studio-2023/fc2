<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Query\JoinClause;

class Tag extends Model
{
    use HasFactory;

    const TABLE_ABBREVIATED_NAME = 'ta.';

    public function getList($arrayRequest)
    {
        $columnList = [
            'ta.id',
            'ta.name',
            'ta.recommend',
            DB::raw('COUNT(ar.id) as articlesCount'),
            'ta.status',
            'ta.delete_flg',
            'ta.created_at',
            'ta.updated_at',
        ];

        $query = DB::table('tags as ta');

        $query->select($columnList);

        $query->leftJoin('articles as ar', function ($join) {
            $join->on(DB::raw('FIND_IN_SET(ta.id, ar.type)'), '>', DB::raw('0'))
                ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
                ->where('ar.status', config('const.ARTICLE.STATUS.RELEASED'));
        });

        $query->where('ta.delete_flg', config('const.DELETE_FLG_OFF'));

        //keyword検索
        if (isset($arrayRequest['keyword'])) {
            $keyWord = '%' . addcslashes($arrayRequest['keyword'], '%_\\') . '%';
            $query
                ->where(function ($query) use ($keyWord) {
                    $query
                    ->orwhere('ta.name', 'like', $keyWord);
                });
        }

        $query->groupBy('ta.id');

        //sort
        $sortType = config('const.SORT_TYPE.d');
        $sortKind = 'updated_at';
        if ( isset($arrayRequest['sk']) && $arrayRequest['sk'] != NULL ) {
            $sortType = config('const.SORT_TYPE.' . $arrayRequest['st']);
            $sortKind = self::TABLE_ABBREVIATED_NAME . $arrayRequest['sk'];
            //joinして引っ張ったcolumn
            if ($arrayRequest['sk'] == 'articlesCount') {
                $sortKind = $arrayRequest['sk'];
            }
        }
        $query->orderBy($sortKind, $sortType);

        $retList = $query->paginate(config('const.ADMIN.LIST_PER_PAGE'));

        return $retList;
    }

    public function insertData($inputData)
    {
        $query = DB::table('tags');
        $value = [
            'name' => $inputData['name'],
            'status' => 0,
            'delete_flg' => config('const.DELETE_FLG_OFF'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $query->insert($value);
    }

    public function getDataById($request)
    {
        $columnList = [
            'ta.id',
            'ta.name',
            'ta.recommend',
            'ta.delete_flg',
            'ta.created_at',
            'ta.updated_at',
        ];

        $query = DB::table('tags as ta');

        $query->select($columnList);

        $query->where('ta.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('ta.id', $request->tag_id);
            
        $retData = $query->first();

        return $retData;
    }

    public function updateData($inputData)
    {

        $query = DB::table('tags');
        $value = [
            'name' => $inputData['name'],
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
            $query = DB::table('tags');
            $query->whereIn('id', $deleteIds);
            $query->update($value);
        }
    }

    public function getListForArticle()
    {
        $columnList = [
            'ta.id',
            'ta.name',
        ];

        $query = DB::table('tags as ta');

        $query->select($columnList);
        $query->where('ta.delete_flg', config('const.DELETE_FLG_OFF'));
        $query->orderBy('ta.updated_at', 'DESC');

        $retList = $query->get();

        return $retList;
    }

    public function getFrontDisplayList($count, $arrayRequest = null)
    {
        $columnList = [
            'ta.id',
            'ta.name',
        ];

        $query = DB::table('tags as ta');
        $query->select($columnList)
            ->where('ta.delete_flg', config('const.DELETE_FLG_OFF'));

        //keyword検索
        if (isset($arrayRequest['keyword'])) {
            $keyWord = '%' . addcslashes($arrayRequest['keyword'], '%_\\') . '%';
            $query->where('ta.name', 'like', $keyWord);
        }

        $query->orderBy('ta.updated_at', 'DESC');

        if (is_null($count)) {
            $retList = $query->get();
        } else {
            $retList = $query->paginate($count);
        }

        return $retList;
    }

    public function updateByScraping($value)
    {
        DB::transaction(function () use ($value) {
            DB::table('tags')->upsert(
                $value, 
                ['name'], 
                ['name', 'updated_at']
            );
        });

        return DB::table('tags')
            ->whereIn('name', array_column($value, 'name'))
            ->pluck('id');
    }
}
