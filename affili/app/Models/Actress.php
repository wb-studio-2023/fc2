<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Query\JoinClause;

class Actress extends Model
{
    use HasFactory;

    const TABLE_ABBREVIATED_NAME = 'ac.';

    public function getList($arrayRequest)
    {
        $columnList = [
            'ac.id',
            'ac.name',
            DB::raw('COUNT(ar.id) as articlesCount'),
            'ac.status',
            'ac.delete_flg',
            'ac.created_at',
            'ac.updated_at',
        ];

        $query = DB::table('actresses as ac');

        $query->select($columnList);

        $query->leftJoin('articles as ar', function ($join) {
            $join->on(DB::raw('FIND_IN_SET(ac.id, ar.actress_id)'), '>', DB::raw('0'))
                ->where('ar.delete_flg', config('const.DELETE_FLG_OFF'))
                ->where('ar.status', config('const.ARTICLE.STATUS.RELEASED'));
        });

        $query->where('ac.delete_flg', config('const.DELETE_FLG_OFF'));

        //keyword検索
        if (isset($arrayRequest['keyword'])) {
            $keyWord = '%' . addcslashes($arrayRequest['keyword'], '%_\\') . '%';
            $query
                ->where(function ($query) use ($keyWord) {
                    $query
                    ->orwhere('ac.name', 'like', $keyWord);
                });
        }

        $query->groupBy('ac.id');

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
        $query = DB::table('actresses');

        $actressType = null;
        if (isset($inputData['actress_type'])) {
            $actressType = join(',', $inputData['actress_type']);
        }

        $value = [
            'name' => $inputData['name'],
            'name_kana' => $inputData['name_kana'],
            'eyecatch' => $inputData['eyecatch'],
            'size' => $inputData['size'],
            'type' => $actressType,
            'introduction' => $inputData['introduction'],
            'delete_flg' => config('const.DELETE_FLG_OFF'),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $query->insert($value);
    }

    public function getDataById($request)
    {
        $columnList = [
            'ac.id',
            'ac.name',
            'ac.name_kana',
            'ac.size',
            'ac.type',
            'ac.introduction',
            'ac.eyecatch',
            'ac.delete_flg',
            'ac.created_at',
            'ac.updated_at',
        ];

        $query = DB::table('actresses as ac');

        $query->select($columnList);

        $query->where('ac.delete_flg', config('const.DELETE_FLG_OFF'))
            ->where('ac.id', $request->actress_id);
            
        $retData = $query->first();

        return $retData;
    }

    public function updateData($inputData)
    {

        $actressType = null;
        if (isset($inputData['actress_type'])) {
            $actressType = join(',', $inputData['actress_type']);
        }

        $query = DB::table('actresses');

        $value = [
            'name' => $inputData['name'],
            'name_kana' => $inputData['name_kana'],
            'eyecatch' => $inputData['eyecatch'],
            'size' => $inputData['size'],
            'type' => $actressType,
            'introduction' => $inputData['introduction'],
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
            $query = DB::table('actresses');
            $query->whereIn('id', $deleteIds);
            $query->update($value);
        }
    }

    public function getListForArticle()
    {
        $columnList = [
            'ac.id',
            'ac.name',
        ];

        $query = DB::table('actresses as ac');

        $query->select($columnList);
        $query->where('ac.delete_flg', config('const.DELETE_FLG_OFF'));
        $query->orderBy('ac.updated_at', 'DESC');

        $retList = $query->get();

        return $retList;
    }

    public function getFrontDisplayList($contentsCount, $arrayRequest = null)
    {
        $columnList = [
            'ac.id',
            'ac.name_kana',
            'ac.name',
            'ac.eyecatch',
            'ac.size',
            'ac.delete_flg',
            'ac.created_at',
            'ac.updated_at',
        ];

        $query = DB::table('actresses as ac');
        $query->select($columnList)
            ->where('ac.delete_flg', config('const.DELETE_FLG_OFF'));

        //keyword検索
        if (isset($arrayRequest['keyword'])) {
            $keyWord = '%' . addcslashes($arrayRequest['keyword'], '%_\\') . '%';
            $query->where('ac.name', 'like', $keyWord);
        }

        $query->orderBy('ac.updated_at', 'DESC');
        $retList = $query->paginate($contentsCount);

        return $retList;
    }
}
