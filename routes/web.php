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

Route::get('/', 'WelcomeController@index');
Route::get('unit','WelcomeController@unit');
Route::get('brands','WelcomeController@brand');
Route::get('info','WelcomeController@info');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('login-dashboard', 'Auth\LoginController@login_dashboard');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('import-data','HomeController@import_data');

/* sosmed tv,publisher, radio dll*/
Route::group(['prefix'=>'sosmed','middleware'=>'auth'],function(){
    Route::group(['middleware'=>'access-log-sosmed'],function(){
        Route::get('change-password','HomeController@change_password');
        Route::get('highlight','HomeController@sosmed_rangking');
        Route::get('group','HomeController@sosmed_group');
        Route::get('businness-unit','HomeController@sosmed_unit');
        Route::get('sosial-media','HomeController@sosmed_media');
        Route::get('program','HomeController@sosmed_program');
        Route::get('program/{id}/summary','HomeController@sosmed_summary_program');
        Route::get('business-unit/{id}/summary','HomeController@sosmed_summary_bu');
        Route::get('group/{id}/summary','HomeController@sosmed_group_summary');
        Route::get('input-report-harian','HomeController@sosmed_input_report_harian');
        Route::get('add-new-report-harian/{id}','HomeController@add_new_report_harian');
        Route::get('insight','HomeController@sosmed_insight');
        Route::get('type-unit','HomeController@sosmed_type_unit');
        Route::get('crowdtangle','HomeController@sosmed_crowdtangle');

        /*dashboard */
        Route::get('dashboard-summary','HomeController@dashboard_summary');
        Route::get('dashboard-chart/{id}','HomeController@dashboard_chart');
        Route::get('live-socmed','HomeController@live_socmed');

        Route::get('daily-report','HomeController@sosmed_daily_report');
        Route::get('ranking-soc-med','HomeController@sosmed_ranking_soc_med');
        Route::get('input-report/{id}','HomeController@sosmed_input_report');
        Route::get('single-report','HomeController@sosmed_single_report');

        Route::get('role','HomeController@role');
        Route::get('role/{id}/permission','HomeController@permission');
        Route::get('user','HomeController@user');
        Route::get('user/{id}/role','HomeController@user_role');

        Route::get('log/login','HomeController@log_login');
        Route::get('log/activity','HomeController@log_activity');
        Route::get('log/access-log','HomeController@access_log');

        Route::get('connect/{provider}','Auth\SocialAccountController@redirectToProvider');
        Route::get('connect/{provider}/callback','Auth\SocialAccountController@handleProviderCallback');

        Route::get('login/{provider}','HomeController@connect_provider');

        Route::get('chart/{param}','HomeController@sosmed_chart');
        // Route::get('instagram','HomeController@sosmed_input_instagram');
        Route::get('twitter','HomeController@sosmed_input_twitter');
        Route::get('youtube/{id}','HomeController@youtube_follower');
        Route::get('facebook','HomeController@sosmed_input_facebook');

        Route::get('instagram', 'Sosmed\InstagramController@redirectToInstagramProvider');
        Route::get('instagram/callback', 'Sosmed\InstagramController@handleProviderInstagramCallback');

        Route::get('export-excel','HomeController@sosmed_export_excel');
        Route::get('jumlah-account','HomeController@sosmed_jumlah_account');

        Route::get('otomatisasi-cek-sosmed','Sosmed\OtomatisasiController@cek_sosmed');

        Route::group(['prefix'=>'summary'],function(){
            Route::get('target-vs-achievement','HomeController@target_vs_achivement');
            Route::get('official-account-all','HomeController@official_account_all');
            Route::get('overall','HomeController@overall');
            Route::get('official-and-program','HomeController@dashboard_official_and_program');
            Route::get('detail-official-program','HomeController@detail_official_program');
            Route::get('rangking','HomeController@dashboard_rangking');
        });
    });

    Route::group(['prefix'=>'data'],function(){
        Route::get('periode','HomeController@periode');
        Route::get('list-activity-user','User\UserController@list_activity_user');
        Route::get('recent-login-user','User\UserController@recent_login_user');
        Route::get('recent-access-log','User\UserController@recent_access_log');
        Route::post('change-password','User\UserController@change_password');
        Route::get('official-and-program-account-all-tv','HomeController@official_and_program');
        Route::resource('type-unit','Sosmed\TypeunitController');

        Route::resource('insight','Sosmed\InsightController');
        Route::delete('insight-detail/{id}','Sosmed\InsightController@delete_detail');
        Route::resource('crowdtangle','Sosmed\CrowdtangleController');

        Route::resource('users','User\UserController');
        Route::resource('roles','User\RoleController');
        Route::resource('permissions','User\PermissionController');
        Route::get('list-role-with-permission/{id}','User\RoleController@list_role_with_permission');
        Route::get('list-role-user','User\UserController@list_role');
        Route::post('save-role-user','User\UserController@save_role_user');
        Route::post('hapus-role-user','User\UserController@hapus_role_user');
        Route::get('list-user/{id}/handle-unit','User\UserController@user_handle_unit');
        Route::post('save-user-handle-unit','User\UserController@save_user_handle_unit');
        Route::delete('hapus-sosmed-hadle/{user}/{sosmed}','User\UserController@delete_user_handle_sosmed');
        Route::post('reset-password','User\UserController@reset_password');
    
        Route::resource('group-unit','Sosmed\GroupunitController');
        Route::get('list-official-program-by-group/{id}','Sosmed\GroupunitController@list_official_program_by_group');
        Route::get('list-group','Sosmed\GroupunitController@list_group');
        Route::resource('business-unit','Sosmed\BusinessunitController');
        Route::get('growth_unit_by_id/{id}','Sosmed\BusinessunitController@growth_unit');
        Route::get('growth_program_by_id/{id}','Sosmed\ProgramunitController@growth_program');
        Route::get('list-unit','Sosmed\BusinessunitController@list_unit');
        Route::resource('program-unit','Sosmed\ProgramunitController');
        Route::resource('sosmed','Sosmed\SosmedController');
        Route::get('list-sosmed','Sosmed\SosmedController@list_sosmed');
        Route::resource('unit-sosmed','Sosmed\UnitsosmedController');
        Route::resource('unit-sosmed-follower','Sosmed\UnitsosmedfollowerController');

        Route::get('target-sosmed-program/{id}','Sosmed\ProgramunitController@target');
        Route::get('alltarget-sosmed-program/{id}','Sosmed\ProgramunitController@all_target');
        Route::post('save-target-program','Sosmed\ProgramunitController@save_target_program');
        Route::get('list-target-by-unit-sosmed/{id}','Sosmed\ProgramunitController@list_target_by_unit_sosmed');
        Route::put('use-target-program/{id}','Sosmed\ProgramunitController@use_target_program');
        Route::get('list-program-by-unit/{id}','Sosmed\ProgramunitController@list_program_by_unit');
        Route::get('list-sosmed-by-program','Sosmed\ProgramunitController@list_sosmed_by_id');
        Route::get('list-sosmed-by-unit/{id}','Sosmed\ProgramunitController@list_sosmed_by_unit');
        Route::get('list-sosmed-by-program/{id}','Sosmed\ProgramunitController@list_sosmed_by_program');
        Route::post('save-daily-report','Sosmed\ProgramunitController@save_daily_report');
        Route::post('cek-save-daily-report','Sosmed\ProgramunitController@cek_daily_report');

        Route::get('daily-report','Sosmed\ProgramunitController@daily_report');
        Route::get('daily-report/{id}','Sosmed\ProgramunitController@daily_report_by_id');
        Route::put('daily-report/{id}','Sosmed\ProgramunitController@daily_report_update');
        Route::delete('daily-report/{id}','Sosmed\ProgramunitController@daily_report_destroy');
        Route::post('import-daily-report','Sosmed\ProgramunitController@daily_report_import');
        Route::get('sample-daily-report','Sosmed\ProgramunitController@daily_report_sample');
        Route::get('list-official-and-program/{id}','Sosmed\ProgramunitController@list_official_and_program');
        Route::post('save-single-report','Sosmed\ProgramunitController@save_single_report');

        Route::get('backup-excel','Sosmed\ProgramunitController@import');

        Route::get('export-excel','Sosmed\ReportController@export_excel');
        Route::get('live-socmed-by-id/{id}','Sosmed\UnitsosmedController@live_socmed_by_id');
        Route::put('aktif-non-aktif-program/{id}','Sosmed\UnitsosmedController@aktif_non_aktif_program');
        Route::get('link-broken','Sosmed\ProgramunitController@link_broken');
        Route::post('save-link-broken','Sosmed\ProgramunitController@save_link_broken');
        Route::get('remote-data-program','Sosmed\ProgramunitController@remote_data_program');

        Route::group(['prefix'=>'report'],function(){
            Route::get('target-vs-achievement','Sosmed\ReportController@target_vs_achievement');
            Route::get('official-account-all-tv','Sosmed\ReportController@official_account_all_tv');
            Route::get('overall-tv','Sosmed\ReportController@overall_tv');
            Route::get('sosmed-official-and-program','Sosmed\ReportController@sosmed_official_and_program');
            Route::get('official-and-program','Sosmed\ReportController@official_and_program');

            Route::get('rank-of-official-account-all-group','Sosmed\ReportController@rank_of_official_account_all_group');
            Route::get('rank-of-official-account-all-tv','Sosmed\ReportController@rank_of_official_account_all_tv');
            Route::get('rank-growth-from-yesterday-official-account-all-tv','Sosmed\ReportController@rank_growth_from_yesterday_all_tv');
            Route::get('rank-growth-from-yesterday-official-group','Sosmed\ReportController@rank_growth_from_yesterday_group');
            Route::get('rank-overall-account-all-tv-by-total-followers','Sosmed\ReportController@rank_overall_account_all_tv_by_total_followers');
            Route::get('rank-of-overall-all-group-by-followers','Sosmed\ReportController@rank_of_overall_all_group_by_follower');
            Route::get('rank-of-official-account-among-4tv','Sosmed\ReportController@rank_of_official_account_among_4tv');

            Route::get('summary-program-by-id/{id}','Sosmed\ReportController@summary_program_by_id');

            Route::get('pdf-rank-for-sosical-media-all-tv','Sosmed\ReportController@pdf_rank_for_social_media_all_tv');
            Route::get('pdf-sosmed-daily-report','Sosmed\ReportController@pdf_sosmed_daily_report');
            Route::get('pdf-sosmed-daily-report-by-group','Sosmed\ReportController@pdf_sosmed_daily_report_by_group');

            /* highlight */
            Route::get('highlight-of-official-account-all-tv','Sosmed\ReportController@highlight_of_official_account_all_tv');
            Route::get('highlight-group-official-account-by-total-followers','Sosmed\ReportController@highlight_group_official_account_by_total_followers');
            Route::get('highlight-group-overall-account','Sosmed\ReportController@highlight_group_overall_account');
            Route::get('highlight-program-account-all-tv','Sosmed\ReportController@higlight_program_account_all_tv');
            Route::get('highlight-unit-overall-account','Sosmed\ReportController@highlight_unit_overall_account');
            Route::get('highlight-target-achivement','Sosmed\ReportController@highlight_target_achivement');
            Route::get('all-program-growth','Sosmed\ReportController@all_program_growth');
            Route::post('sosmed-highlight','Sosmed\ReportController@sosmed_highlight');

            Route::get('jumlah-account','Sosmed\ReportController@jumlah_account');
            Route::get('youtube-tv-and-program','Sosmed\ReportController@youtube_tv_and_program');
            Route::get('nama-akun-official-dan-program','Sosmed\ReportController@nama_akun_official_dan_program');
        });

        Route::group(['prefix'=>'chart'],function(){
            Route::get('chart-by-type-unit','Sosmed\ReportController@chart_by_type_unit');
            Route::get('daily-chart/{id}/program','Sosmed\ReportController@daily_chart_program');
            Route::get('all-tier','Sosmed\ReportController@all_tier');
            Route::get('official-tv','Sosmed\ReportController@chart_official_tv');
            Route::get('chart-by-tier','Sosmed\ReportController@chart_by_tier');
            Route::get('official-by-tier','Sosmed\ReportController@official_by_tier');
            Route::get('program-by-tier','Sosmed\ReportController@program_by_tier');
            Route::post('program-by-tier','Sosmed\ReportController@post_program_by_tier');
            Route::get('top-official-twitter-today','Sosmed\ReportController@top_official_twitter_today');
            Route::get('top-program-twitter-today','Sosmed\ReportController@top_program_twitter_today');
            Route::get('type-unit-by-group','Sosmed\ReportController@type_unit_by_group');
        });
    });

    /*export excel */
    Route::group(['prefix'=>'export'],function(){
        Route::group(['prefix'=>'excel'],function(){
            Route::get('group-unit','Sosmed\GroupunitController@export_excel');
            Route::get('business-unit','Sosmed\BusinessunitController@export_excel');
            Route::get('program-unit','Sosmed\ProgramunitController@export_excel');
        });
    });
});
/* end sosmed tv, publisher, radio dll */

/*sosmed brand */
Route::group(['prefix'=>'brand','middleware'=>'auth'],function(){
    Route::group(['middleware' => ['permission:home-brand']], function () {
        Route::get('/','Brand\MainbrandController@index');
        Route::get('sector','Brand\MainbrandController@sector');
        Route::get('category','Brand\MainbrandController@category');
        Route::get('brand','Brand\MainbrandController@brand');
        Route::get('produk','Brand\MainbrandController@produk');
        Route::get('advertiser','Brand\MainbrandController@advertiser');
        Route::get('brand-unit','Brand\MainbrandController@brand_unit');
        Route::get('brand-unit/{id}/summary','Brand\MainbrandController@summary_brand_unit');
        Route::get('unit-sosmed','Brand\MainbrandController@unit_sosmed');
        Route::get('unit-sosmed-create','Brand\MainbrandController@unit_sosmed_create');
        Route::get('live-socmed','Brand\MainbrandController@live_socmed');
        Route::get('input-report/{id}','Brand\MainbrandController@sosmed_input_report');
        Route::get('add-new-report-daily/{id}','Brand\MainbrandController@add_new_report_daily');
        Route::get('agency','Brand\MainbrandController@agency');
        Route::get('agencypintu','Brand\MainbrandController@agency_pintu');
        Route::get('agency/{id}/summary','Brand\MainbrandController@summary_agency');
        Route::get('agency-pintu/{id}/summary','Brand\MainbrandController@summary_agency_pintu');
    });    
    

    Route::group(['prefix'=>'data'],function(){
        Route::resource('sector','Brand\SectorController');
        ROute::resource('category','Brand\CategoryController');
        Route::resource('brand','Brand\BrandController');
        Route::resource('produk','Brand\ProdukController');
        Route::resource('brand-unit','Brand\BrandunitController');
        Route::resource('brand-sosmed','Brand\BrandsosmedController');
        Route::resource('advertiser','Brand\AdvertiserController');
        Route::resource('agency','Brand\AgencyController');
        Route::resource('agency-pintu','Brand\AgencypintuController');
        Route::get('list-brand','Brand\BrandController@list_brand');
        Route::post('add-brand-sosmed','Brand\BrandunitController@save_brand_sosmed');
        Route::get('{id}/show-list-brand','Brand\BrandunitController@show_list_brand');
        Route::get('unit-sosmed-by-brand/{id}','Brand\BrandunitController@unit_sosmed_by_brand');
        Route::get('unit-sosmed-by-agency/{id}','Brand\BrandunitController@unit_sosmed_by_agency');
        Route::get('unit-sosmed-by-agency-pintu/{id}','Brand\BrandunitController@unit_sosmed_by_agency_pintu');
        Route::delete('hapus-related-brand/{id}','Brand\BrandunitController@hapus_related_brand');
        Route::get('list-brand-by-sector','Brand\BrandunitController@list_brand_by_sector');

        Route::get('daily-report','Brand\BrandunitController@daily_report');
        Route::get('list-advertiser','Brand\MainbrandController@list_advertiser');
        Route::get('list-brand-by-advertiser','Brand\AdvertiserController@list_brand_by_advertiser');
        Route::get('list-unit-sosmed-by-advertiser/{id}','Brand\BrandunitController@list_unit_sosmed_by_advertiser');
        Route::post('cek-save-daily-report','Brand\BrandunitController@cek_save_daily_report');
        Route::post('save-daily-report','Brand\BrandunitController@save_daily_report');

        Route::get('list-available-category','Brand\BrandunitController@list_available_category');
        Route::get('list-available-sector','Brand\BrandunitController@list_available_sector');
        Route::get('remote-data-advertiser','Brand\MainbrandController@remote_data_advertiser');
        Route::get('remote-data-brand','Brand\MainbrandController@remote_data_brand');
        Route::get('remote-data-produk','Brand\MainbrandController@remote_data_produk');

        Route::group(['prefix'=>'chart'],function(){
            Route::get('daily-by-advertiser','Brand\ChartBrandController@daily_by_advertiser');
            Route::get('daily-by-category','Brand\ChartBrandController@daily_by_category');
            Route::get('daily-by-sector','Brand\ChartBrandController@daily_by_sector');
        });
    });
});
/* end sosmed brand*/

Route::group(['prefix'=>'cmv','middleware'=>'auth'],function(){
    Route::get('/','Dashboard\CmvController@index');
    Route::get('sector','Dashboard\CmvController@sector');
    Route::get('category','Dashboard\CmvController@category');
    Route::get('brand','Dashboard\CmvController@brand');
    Route::get('demography','Dashboard\CmvController@demography');
    Route::get('demography/{id}/sub','Dashboard\CmvController@sub_demography');
    Route::get('variabel','Dashboard\CmvController@variabel');
    Route::get('target-audience','Dashboard\CmvController@target_audience');

    Route::group(['prefix'=>'chart'],function(){
        Route::get('brand','Dashboard\CmvController@chart_brand');
        Route::get('competitive-map','Dashboard\CmvController@chart_competitive_map');
        Route::get('by-target-audience','Dashboard\CmvController@chart_by_target_audience');
    });

    Route::group(['prefix'=>'data'],function(){
        Route::get('filter-demography-by-brand','Dashboard\Cmv\ReportController@filter_demography');
        Route::get('filter-demography-by-ta','Dashboard\Cmv\ReportController@filter_demography_by_ta');
        Route::get('top-brand-by-category','Dashboard\Cmv\ReportController@top_brand_by_category');
        Route::post('list-competitive-map','Dashboard\Cmv\ReportController@competitive_map');
        Route::get('compare-product','Dashboard\Cmv\ReportController@compare_product');
        Route::get('compare-with','Dashboard\Cmv\ReportController@compare_with');

        Route::resource('sector','Dashboard\Cmv\SectorController');
        Route::post('import-sector','Dashboard\Cmv\SectorController@import');
        Route::get('sample-sector','Dashboard\Cmv\SectorController@sample');
        Route::get('export-sector','Dashboard\Cmv\SectorController@export');
        Route::get('list-sector','Dashboard\Cmv\SectorController@list_sector');
        Route::get('list-quartal','Dashboard\Cmv\ReportController@list_quartal');

        Route::resource('category','Dashboard\Cmv\CategoryController');
        Route::post('import-category','Dashboard\Cmv\CategoryController@import');
        Route::get('sample-category','Dashboard\Cmv\CategoryController@sample');
        Route::get('export-category','Dashboard\Cmv\CategoryController@export');
        Route::get('list-category','Dashboard\Cmv\CategoryController@list_category');
        Route::get('list-category-by-id/{id}','Dashboard\Cmv\CategoryController@list_category_by_id');

        Route::resource('brand','Dashboard\Cmv\BrandController');
        Route::post('filter-brand','Dashboard\Cmv\BrandController@filter_brand');
        Route::post('import-brand','Dashboard\Cmv\BrandController@import');
        Route::get('sample-brand','Dashboard\Cmv\BrandController@sample');
        Route::get('export-brand','Dashboard\Cmv\BrandController@export');
        Route::get('list-brand','Dashboard\Cmv\BrandController@list_brand');

        Route::resource('target-audience','Dashboard\Cmv\TargetaudienceController');
        Route::get('list-ta','Dashboard\Cmv\TargetaudienceController@list_ta');

        Route::resource('demography','Dashboard\Cmv\DemographyController');
        Route::post('import-demography','Dashboard\Cmv\DemographyController@import');
        Route::get('sample-demography','Dashboard\Cmv\DemographyController@sample');
        Route::get('export-demography','Dashboard\Cmv\DemographyController@export');

        Route::resource('sub-demography','Dashboard\Cmv\SubdemographyController');
        Route::post('import-sub-demography','Dashboard\Cmv\SubdemographyController@import');
        Route::get('sample-sub-demography','Dashboard\Cmv\SubdemographyController@sample');
        Route::get('export-sub-demography','Dashboard\Cmv\SubdemographyController@export');
        Route::get('list-sub-demo','Dashboard\Cmv\SubdemographyController@list_sub_demo');

        Route::resource('variabel','Dashboard\Cmv\VariabelController');
        Route::post('filter-variabel','Dashboard\Cmv\VariabelController@filter_variabel');
        Route::post('import-variabel','Dashboard\Cmv\VariabelController@import');
        Route::get('sample-variabel','Dashboard\Cmv\VariabelController@sample');
        Route::get('export-variabel','Dashboard\Cmv\VariabelController@export');
        Route::post('rollback-variabel','Dashboard\Cmv\VariabelController@rollback_excel');

        Route::get('search','Dashboard\Cmv\VariabelController@search');

        Route::group(['prefix'=>'chart'],function(){
            Route::get('all-data','Dashboard\Cmv\ReportController@chart_all_data');
            Route::get('all-brand','Dashboard\Cmv\ReportController@all_brand');
            Route::get('all-data-ta','Dashboard\Cmv\ReportController@all_data_by_ta');
            Route::get('day-part','Dashboard\Cmv\ReportController@day_part');
        });
    });
});


Route::group(['prefix'=>'automation'],function(){
    Route::get('official','Sosmed\AutomationController@official');
    Route::get('program','Sosmed\AutomationController@program');
    Route::get('official-sosmed','Sosmed\OtomatisasiController@official_sosmed');
});

Route::get('tes-follower','WelcomeController@tes_follower');

Route::get('tes-facebook','HomeController@tes_follower');
Route::get('tes-youtube','HomeController@tes_youtube');

Route::get('tes-facebook','WelcomeController@tes_facebook');
Route::get('clear-cache','WelcomeController@clear_cache');

Route::get('cek-instagram','Sosmed\InstagramController@cek_instagram');
Route::get('tes-instagram','Sosmed\InstagramController@tes_instagram');
Route::get('get-account','Sosmed\InstagramController@get_account');
Route::get('cek-bahasa','Sosmed\InstagramController@cek_bahasa');
Route::get('daftar-akun','Sosmed\InstagramController@daftar_akun');
Route::post('daftar-akun','Sosmed\InstagramController@simpan_daftar_akun');