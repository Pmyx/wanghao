<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//上传图片路由
Route::resource('photos', 'PhotoController')->only('store');

//后台路由
Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::get('login', 'LoginController@showLoginForm')->name('admin.login');    //加载登录页面
    Route::post('login', 'LoginController@login');                               //登录
    Route::post('logout', 'LoginController@logout')->name('admin.logout'); //退出
    Route::middleware('auth.admin:admin')->name('admin.')->group(function () {
        Route::get('/', 'DashboardController@index');       //加载登录首页

        //新闻资源路由
        Route::prefix('notice')->group(function () {
            Route::patch('/change_sort/{id}', 'NoticeController@change_sort');    //改变排序
            Route::patch('/change_attr/{id}', 'NoticeController@change_attr');    //改变排序
        });
        Route::resource('notice', 'NoticeController')->except('show','create'); // 酷站列表

        Route::resource('notice_nodes', 'NoticeNodeController'); // 酷站分类
        Route::prefix('notice_nodes')->group(function () {
            Route::patch('/change_sort/{id}', 'NoticeNodeController@change_sort');    //改变排序
            Route::post('del_all', 'NoticeNodeController@del_all');     //多选删除
        });

        //酷站资源路由
        Route::prefix('site')->group(function () {
            Route::patch('/change_sort/{id}', 'SiteController@change_sort');    //改变排序
            Route::patch('/change_attr/{id}', 'SiteController@change_attr');    //改变排序
        });
        Route::resource('site', 'SiteController')->except('show','create'); // 酷站列表

        Route::resource('site_nodes', 'SiteNodeController'); // 酷站分类
        Route::prefix('site_nodes')->group(function () {
            Route::patch('/change_sort/{id}', 'SiteNodeController@change_sort');    //改变排序
            Route::post('del_all', 'SiteNodeController@del_all');     //多选删除
        });

        //广告资源路由
        Route::prefix('advert')->group(function () {
            Route::patch('/change_sort/{id}', 'AdvertController@change_sort');    //改变排序
            Route::patch('/change_attr/{id}', 'AdvertController@change_attr');    //改变排序
        });
        Route::resource('advert', 'AdvertController')->except('show','create'); // 酷站列表

        Route::resource('advert_nodes', 'AdvertNodeController'); // 酷站分类
        Route::prefix('advert_nodes')->group(function () {
            Route::patch('/change_sort/{id}', 'AdvertNodeController@change_sort');    //改变排序
            Route::post('del_all', 'AdvertNodeController@del_all');     //多选删除
        });





    });
});








/****
 * 企业登录路由
 */
Route::prefix('company')->namespace('Company')->group(function () {
    Route::get('login', 'LoginController@showLoginForm')->name('company.login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('company.logout');
    Route::middleware('auth.company:company')->name('company.')->group(function () {
        Route::get('/', 'CompanyController@index');
    });
});