<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Query\JoinClause;

class Category extends Model
{
    use HasFactory;

    const TABLE_ABBREVIATED_NAME = 'ca.';

    public function getList($arrayRequest)
    {
        $columnList = [
            'ca.id',
            'ca.name',
            'ca.recommend',
            DB::raw('COUNT(ar.id) as articlesCount'),
            'ca.status',
            'ca.delete_flg',
            'ca.created_at',
            'ca.updated_at',
        ];

        $query = DB::table('categories as ca');

        $query->select($columnList);

        $query->leftJoin('articles as ar', function ($join) {
            $join->on('ca.id', 'ar.category')
                ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
                ->where('ar.status', config('const.ARTICLE.STATUS.RELEASED'));
        });

        $query->where('ca.delete_flg', config('const.DELETE_FLG_OFF'));

        //keyword検索
        if (isset($arrayRequest['keyword'])) {
            $keyWord = '%' . addcslashes($arrayRequest['keyword'], '%_\\') . '%';
            $query
                ->where(function ($query) use ($keyWord) {
                    $query
                    ->orwhere('ca.name', 'like', $keyWord);
                });
        }

        $query->groupBy('ca.id');

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
        $query = DB::table('categories');
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
            'ca.id',
            'ca.name',
            'ca.recommend',
            'ca.delete_flg',
            'ca.created_at',
            'ca.updated_at',
        ];

        $query = DB::table('categories as ca');

        $query->select($columnList);

        $query->where('ca.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('ca.id', $request->category_id);
            
        $retData = $query->first();

        return $retData;
    }

    public function updateData($inputData)
    {

        $query = DB::table('categories');
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
            $query = DB::table('categories');
            $query->whereIn('id', $deleteIds);
            $query->update($value);
        }
    }

    public function getListForArticle()
    {
        $columnList = [
            'ca.id',
            'ca.name',
        ];

        $query = DB::table('categories as ca');

        $query->select($columnList);
        $query->where('ca.delete_flg', config('const.DELETE_FLG_OFF'));
        $query->orderBy('ca.updated_at', 'DESC');

        $retList = $query->get();

        return $retList;
    }

    public function getFrontDisplayList($count, $arrayRequest = null)
    {
        $columnList = [
            'ca.id',
            'ca.name',
        ];

        $query = DB::table('categories as ca');
        $query->select($columnList)
            ->where('ca.delete_flg', config('const.DELETE_FLG_OFF'));

        //keyword検索
        if (isset($arrayRequest['keyword'])) {
            $keyWord = '%' . addcslashes($arrayRequest['keyword'], '%_\\') . '%';
            $query->where('ca.name', 'like', $keyWord);
        }

        $query->orderBy('ca.updated_at', 'DESC');
        $retList = $query->get();

        return $retList;
    }
}
