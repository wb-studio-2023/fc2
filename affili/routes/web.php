<?php

use Illuminate\Support\Facades\Route;
use App\Services\SetContentsToArticlesService;
/* --------------------------
 ユーザー画面
--------------------------*/

Route::get('/', [\App\Http\Controllers\Front\IndexController::class, 'index'])->name('front.index.list');

Route::get('article/list', [\App\Http\Controllers\Front\ArticleController::class, 'getList'])->name('front.article.list');
Route::post('article/list', [\App\Http\Controllers\Front\ArticleController::class, 'getList'])->name('front.article.search');
Route::get('article/{article_id}', [\App\Http\Controllers\Front\ArticleController::class, 'articleDetail'])->name('front.article.detail');

// Route::get('actress/list', [\App\Http\Controllers\Front\ActressController::class, 'getList'])->name('front.actress.list');
// Route::post('actress/list', [\App\Http\Controllers\Front\ActressController::class, 'getList'])->name('front.actress.search');
// Route::get('actress/{actress_id}', [\App\Http\Controllers\Front\ActressController::class, 'getArticleList'])->name('front.actress.article.list');

// Route::get('category/list', [\App\Http\Controllers\Front\CategoryController::class, 'getList'])->name('front.category.list');
// Route::post('category/list', [\App\Http\Controllers\Front\CategoryController::class, 'getList'])->name('front.category.search');
// Route::get('category/{category_id}', [\App\Http\Controllers\Front\CategoryController::class, 'getArticleList'])->name('front.category.article.list');

Route::get('tag/list', [\App\Http\Controllers\Front\TagController::class, 'getList'])->name('front.tag.list');
Route::post('tag/list', [\App\Http\Controllers\Front\TagController::class, 'getList'])->name('front.tag.search');
Route::get('tag/{tag_id}', [\App\Http\Controllers\Front\TagController::class, 'getArticleList'])->name('front.tag.article.list');

/* --------------------------
 管理画面
--------------------------*/
Route::get('administrator/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('administrator.showLoginForm');
Route::post('administrator/login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('administrator.login');
Route::get('administrator/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('administrator.logout');

Route::prefix('administrator')->middleware('auth:administrator')->group(function(){
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AuthController::class, 'dashboard'])->name('administrator.dashboard');

    //記事管理
    Route::group(['prefix' => 'article'], function () {
        Route::get('list', [\App\Http\Controllers\Admin\ArticleController::class, 'getList'])->name('administrator.article.list');
        Route::post('list', [\App\Http\Controllers\Admin\ArticleController::class, 'getList'])->name('administrator.article.search');
        Route::get('/regist/form', [\App\Http\Controllers\Admin\ArticleController::class, 'registShowForm'])->name('administrator.article.regist.showForm');
        Route::post('/regist/confirm', [\App\Http\Controllers\Admin\ArticleController::class, 'registConfirm'])->name('administrator.article.regist.confirm');
        Route::post('/regist/execution', [\App\Http\Controllers\Admin\ArticleController::class, 'registExecution'])->name('administrator.article.regist.execution');
        Route::get('/edit/{article_id}', [\App\Http\Controllers\Admin\ArticleController::class, 'editShowForm'])->name('administrator.article.edit.showForm');
        Route::post('/edit/confirm', [\App\Http\Controllers\Admin\ArticleController::class, 'editConfirm'])->name('administrator.article.edit.confirm');
        Route::post('/edit/execution', [\App\Http\Controllers\Admin\ArticleController::class, 'editExecution'])->name('administrator.article.edit.execution');
        Route::post('delete', [\App\Http\Controllers\Admin\ArticleController::class, 'deleteExecution'])->name('administrator.article.delete.execution');

    });

    //女優管理
    Route::group(['prefix' => 'actress'], function () {
        Route::get('list', [\App\Http\Controllers\Admin\ActressController::class, 'getList'])->name('administrator.actress.list');
        Route::post('list', [\App\Http\Controllers\Admin\ActressController::class, 'getList'])->name('administrator.actress.search');
        Route::get('/regist/form', [\App\Http\Controllers\Admin\ActressController::class, 'registShowForm'])->name('administrator.actress.regist.showForm');
        Route::post('/regist/confirm', [\App\Http\Controllers\Admin\ActressController::class, 'registConfirm'])->name('administrator.actress.regist.confirm');
        Route::post('/regist/execution', [\App\Http\Controllers\Admin\ActressController::class, 'registExecution'])->name('administrator.actress.regist.execution');
        Route::get('/edit/{actress_id}', [\App\Http\Controllers\Admin\ActressController::class, 'editShowForm'])->name('administrator.actress.edit.showForm');
        Route::post('/edit/confirm', [\App\Http\Controllers\Admin\ActressController::class, 'editConfirm'])->name('administrator.actress.edit.confirm');
        Route::post('/edit/execution', [\App\Http\Controllers\Admin\ActressController::class, 'editExecution'])->name('administrator.actress.edit.execution');
        Route::post('delete', [\App\Http\Controllers\Admin\ActressController::class, 'deleteExecution'])->name('administrator.actress.delete.execution');

    });

    //女優タイプ管理
    Route::group(['prefix' => 'actress_type'], function () {
        Route::get('list', [\App\Http\Controllers\Admin\ActressTypeController::class, 'getList'])->name('administrator.actress_type.list');
        Route::post('list', [\App\Http\Controllers\Admin\ActressTypeController::class, 'getList'])->name('administrator.actress_type.search');
        Route::get('/regist/form', [\App\Http\Controllers\Admin\ActressTypeController::class, 'registShowForm'])->name('administrator.actress_type.regist.showForm');
        Route::post('/regist/confirm', [\App\Http\Controllers\Admin\ActressTypeController::class, 'registConfirm'])->name('administrator.actress_type.regist.confirm');
        Route::post('/regist/execution', [\App\Http\Controllers\Admin\ActressTypeController::class, 'registExecution'])->name('administrator.actress_type.regist.execution');
        Route::get('/edit/{actress_type_id}', [\App\Http\Controllers\Admin\ActressTypeController::class, 'editShowForm'])->name('administrator.actress_type.edit.showForm');
        Route::post('/edit/confirm', [\App\Http\Controllers\Admin\ActressTypeController::class, 'editConfirm'])->name('administrator.actress_type.edit.confirm');
        Route::post('/edit/execution', [\App\Http\Controllers\Admin\ActressTypeController::class, 'editExecution'])->name('administrator.actress_type.edit.execution');
        Route::post('delete', [\App\Http\Controllers\Admin\ActressTypeController::class, 'deleteExecution'])->name('administrator.actress_type.delete.execution');

    });

    //カテゴリー管理
    Route::group(['prefix' => 'category'], function () {
        Route::get('list', [\App\Http\Controllers\Admin\CategoryController::class, 'getList'])->name('administrator.category.list');
        Route::post('list', [\App\Http\Controllers\Admin\CategoryController::class, 'getList'])->name('administrator.category.search');
        Route::get('/regist/form', [\App\Http\Controllers\Admin\CategoryController::class, 'registShowForm'])->name('administrator.category.regist.showForm');
        Route::post('/regist/confirm', [\App\Http\Controllers\Admin\CategoryController::class, 'registConfirm'])->name('administrator.category.regist.confirm');
        Route::post('/regist/execution', [\App\Http\Controllers\Admin\CategoryController::class, 'registExecution'])->name('administrator.category.regist.execution');
        Route::get('/edit/{category_id}', [\App\Http\Controllers\Admin\CategoryController::class, 'editShowForm'])->name('administrator.category.edit.showForm');
        Route::post('/edit/confirm', [\App\Http\Controllers\Admin\CategoryController::class, 'editConfirm'])->name('administrator.category.edit.confirm');
        Route::post('/edit/execution', [\App\Http\Controllers\Admin\CategoryController::class, 'editExecution'])->name('administrator.category.edit.execution');
        Route::post('delete', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteExecution'])->name('administrator.category.delete.execution');

    });

    //タグ管理
    Route::group(['prefix' => 'tag'], function () {
        Route::get('list', [\App\Http\Controllers\Admin\TagController::class, 'getList'])->name('administrator.tag.list');
        Route::post('list', [\App\Http\Controllers\Admin\TagController::class, 'getList'])->name('administrator.tag.search');
        Route::get('/regist/form', [\App\Http\Controllers\Admin\TagController::class, 'registShowForm'])->name('administrator.tag.regist.showForm');
        Route::post('/regist/confirm', [\App\Http\Controllers\Admin\TagController::class, 'registConfirm'])->name('administrator.tag.regist.confirm');
        Route::post('/regist/execution', [\App\Http\Controllers\Admin\TagController::class, 'registExecution'])->name('administrator.tag.regist.execution');
        Route::get('/edit/{tag_id}', [\App\Http\Controllers\Admin\TagController::class, 'editShowForm'])->name('administrator.tag.edit.showForm');
        Route::post('/edit/confirm', [\App\Http\Controllers\Admin\TagController::class, 'editConfirm'])->name('administrator.tag.edit.confirm');
        Route::post('/edit/execution', [\App\Http\Controllers\Admin\TagController::class, 'editExecution'])->name('administrator.tag.edit.execution');
        Route::post('delete', [\App\Http\Controllers\Admin\TagController::class, 'deleteExecution'])->name('administrator.tag.delete.execution');

    });

    //カテゴリー管理
    Route::group(['prefix' => 'platform'], function () {
        Route::get('list', [\App\Http\Controllers\Admin\PlatformController::class, 'getList'])->name('administrator.platform.list');
        Route::post('list', [\App\Http\Controllers\Admin\PlatformController::class, 'getList'])->name('administrator.platform.search');
        Route::get('/regist/form', [\App\Http\Controllers\Admin\PlatformController::class, 'registShowForm'])->name('administrator.platform.regist.showForm');
        Route::post('/regist/confirm', [\App\Http\Controllers\Admin\PlatformController::class, 'registConfirm'])->name('administrator.platform.regist.confirm');
        Route::post('/regist/execution', [\App\Http\Controllers\Admin\PlatformController::class, 'registExecution'])->name('administrator.platform.regist.execution');
        Route::get('/edit/{platform_id}', [\App\Http\Controllers\Admin\PlatformController::class, 'editShowForm'])->name('administrator.platform.edit.showForm');
        Route::post('/edit/confirm', [\App\Http\Controllers\Admin\PlatformController::class, 'editConfirm'])->name('administrator.platform.edit.confirm');
        Route::post('/edit/execution', [\App\Http\Controllers\Admin\PlatformController::class, 'editExecution'])->name('administrator.platform.edit.execution');
        Route::post('delete', [\App\Http\Controllers\Admin\PlatformController::class, 'deleteExecution'])->name('administrator.platform.delete.execution');

    });

    //タグ管理
    Route::group(['prefix' => 'site'], function () {
        Route::get('list', [\App\Http\Controllers\Admin\SiteController::class, 'getList'])->name('administrator.site.list');
        Route::post('list', [\App\Http\Controllers\Admin\SiteController::class, 'getList'])->name('administrator.site.search');
        Route::get('/regist/form', [\App\Http\Controllers\Admin\SiteController::class, 'registShowForm'])->name('administrator.site.regist.showForm');
        Route::post('/regist/confirm', [\App\Http\Controllers\Admin\SiteController::class, 'registConfirm'])->name('administrator.site.regist.confirm');
        Route::post('/regist/execution', [\App\Http\Controllers\Admin\SiteController::class, 'registExecution'])->name('administrator.site.regist.execution');
        Route::get('/edit/{site_id}', [\App\Http\Controllers\Admin\SiteController::class, 'editShowForm'])->name('administrator.site.edit.showForm');
        Route::post('/edit/confirm', [\App\Http\Controllers\Admin\SiteController::class, 'editConfirm'])->name('administrator.site.edit.confirm');
        Route::post('/edit/execution', [\App\Http\Controllers\Admin\SiteController::class, 'editExecution'])->name('administrator.site.edit.execution');
        Route::post('delete', [\App\Http\Controllers\Admin\SiteController::class, 'deleteExecution'])->name('administrator.site.delete.execution');

    });
});

// イメージが貼り付けられた際の処理
Route::post('/tinymce/upload', [\App\Http\Controllers\Admin\TinymceController::class, 'upload'])->name('tinymce.image');

/* --------------------------
 スクレイピング
--------------------------*/

Route::get('/scrape/fc2/setContents/{num}', function ($num) {
    $setContentsToArticles = new SetContentsToArticlesService();
    $setContentsToArticles->process($num);
});
