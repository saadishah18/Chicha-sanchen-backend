<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return redirect('login');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');
//
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
//Route::get('/', function () {
//    return view('welcome');
//});
Route::middleware(['auth'])->prefix('admin')->group(function () {
//Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
//    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/profile/edit', [\App\Http\Controllers\Admin\AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/profile/reset-password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'resetPassword'])->name('admin.profile.reset_password');

    Route::prefix('users')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/datatable', [\App\Http\Controllers\Admin\UserController::class, 'datatable'])->name('admin.users.datatable');
        Route::post('/', [\App\Http\Controllers\Admin\AdminUsersController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}/edit', [\App\Http\Controllers\Admin\AdminUsersController::class, 'edit'])->name('admin.users.edit');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminUsersController::class, 'create'])->name('admin.users.create');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/{id}/toggle-approve', [\App\Http\Controllers\Admin\AdminUsersController::class, 'toggleApprove'])->name('admin.users.toggle_approve');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminUsersController::class, 'update'])->name('admin.users.update');
    });
    Route::prefix('categories')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/datatable', [\App\Http\Controllers\Admin\CategoryController::class, 'datatable'])->name('admin.categories.datatable');
        Route::post('/', [\App\Http\Controllers\Admin\AdminCategoriesController::class, 'store'])->name('admin.categories.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminCategoriesController::class, 'create'])->name('admin.categories.create');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdminCategoriesController::class, 'edit'])->name('admin.categories.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminCategoriesController::class, 'update'])->name('admin.categories.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminCategoriesController::class, 'delete'])->name('admin.categories.delete');
    });
    Route::prefix('tags')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminTagsController::class, 'index'])->name('admin.tags.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminTagsController::class, 'store'])->name('admin.tags.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminTagsController::class, 'create'])->name('admin.tags.create');
        Route::get('/datatable', [\App\Http\Controllers\Admin\AdminTagsController::class, 'datatable'])->name('admin.tags.datatable');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdminTagsController::class, 'edit'])->name('admin.tags.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminTagsController::class, 'update'])->name('admin.tags.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminTagsController::class, 'delete'])->name('admin.tags.delete');
    });
    Route::prefix('comments')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminCommentsController::class, 'index'])->name('admin.comments.index');
        Route::get('/datatable/{type?}', [\App\Http\Controllers\Admin\AdminCommentsController::class, 'datatable'])->name('admin.comments.datatable');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdminCommentsController::class, 'edit'])->name('admin.comments.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminCommentsController::class, 'update'])->name('admin.comments.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminCommentsController::class, 'delete'])->name('admin.comments.delete');
        Route::post('/{id}/toggle-approve', [\App\Http\Controllers\Admin\AdminCommentsController::class, 'toggleApprove'])->name('admin.comments.toggle_approve');
        Route::post('/{id}/toggle-featured', [\App\Http\Controllers\Admin\AdminCommentsController::class, 'toggleFeatured'])->name('admin.comments.toggle_featured');
        Route::post('/{id}/toggle-abusive', [\App\Http\Controllers\Admin\AdminCommentsController::class, 'toggleAbusive'])->name('admin.comments.toggle_abusive');
    });
    Route::prefix('posts/analytics')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminPostViewsController::class, 'analytics'])->name('admin.posts.analytics.index');
        Route::get('/summary', [\App\Http\Controllers\Admin\AdminPostViewsController::class, 'summary'])->name('admin.posts.analytics.summary');
        Route::get('/rankings', [\App\Http\Controllers\Admin\AdminPostViewsController::class, 'rankings'])->name('admin.posts.analytics.rankings');
        Route::get('/categories', [\App\Http\Controllers\Admin\AdminPostViewsController::class, 'categories'])->name('admin.posts.analytics.categories');
        Route::get('/featured-marketing', [\App\Http\Controllers\Admin\AdminPostViewsController::class, 'featuredMarketing'])->name('admin.posts.analytics.featured_marketing');
        Route::get('/datatable', [\App\Http\Controllers\Admin\AdminPostViewsController::class, 'datatable'])->name('admin.posts.analytics.datatable');
        Route::get('/categories-datatable', [\App\Http\Controllers\Admin\AdminPostViewsController::class, 'categoriesDatatable'])->name('admin.posts.analytics.categories_datatable');
    });
    Route::prefix('/posts')->group(function () {
        Route::post('/{newsTypeId}', [\App\Http\Controllers\Admin\AdminPostsController::class, 'store'])->name('admin.posts.store');
        Route::get('/type/{newsTypeId}', [\App\Http\Controllers\Admin\AdminPostsController::class, 'index'])->name('admin.posts.index');
        Route::get('/create/{newsTypeId}', [\App\Http\Controllers\Admin\AdminPostsController::class, 'create'])->name('admin.posts.create');
        Route::get('/datatable/{id}/{type?}', [\App\Http\Controllers\Admin\AdminPostsController::class, 'datatable'])->name('admin.posts.datatable');
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminPostsController::class, 'edit'])->name('admin.posts.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminPostsController::class, 'update'])->name('admin.posts.update');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminPostsController::class, 'toggleAction'])->name('admin.posts.toggle_action');
        Route::post('/{id}/send-notification', [\App\Http\Controllers\Admin\AdminPostsController::class, 'sendNotification'])->name('admin.posts.send_notification');
    });
    Route::prefix('post-rankings')->group(function () {
        Route::post('/set-order', [\App\Http\Controllers\Admin\AdminPostRankingController::class, 'setOrder'])->name('admin.post_rankings.set_order');
        Route::get('/type/{newsTypeId}', [\App\Http\Controllers\Admin\AdminPostRankingController::class, 'index'])->name('admin.post_rankings.index');
        Route::get('/datatable/{newsTypeId}/{order?}', [\App\Http\Controllers\Admin\AdminPostRankingController::class, 'datatable'])->name('admin.post_rankings.datatable');
    });
    Route::prefix('/real-estates')->group(function () {
        Route::get('/create', [\App\Http\Controllers\Admin\AdminRealEstateController::class, 'create'])->name('admin.real_estates.create');
        Route::get('/datatable/{newsTypeId?}', [\App\Http\Controllers\Admin\AdminRealEstateController::class, 'datatable'])->name('admin.real_estates.datatable');
        Route::get('/messages', [\App\Http\Controllers\Admin\AdminRealEstateController::class, 'messagesDatatable'])->name('admin.real_estates.messages');
        Route::get('/{newsTypeId?}', [\App\Http\Controllers\Admin\AdminRealEstateController::class, 'index'])->name('admin.real_estates.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminRealEstateController::class, 'store'])->name('admin.real_estates.store');
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminRealEstateController::class, 'edit'])->name('admin.real_estates.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminRealEstateController::class, 'update'])->name('admin.real_estates.update');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminRealEstateController::class, 'toggleAction'])->name('admin.real_estates.toggle_action');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminRealEstateController::class, 'delete'])->name('admin.real_estates.delete');
    });

    Route::prefix('/obituaries')->group(function () {
        Route::post('/', [\App\Http\Controllers\Admin\AdminObituaryController::class, 'store'])->name('admin.obituaries.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminObituaryController::class, 'create'])->name('admin.obituaries.create');
        Route::get('/{newsTypeId?}', [\App\Http\Controllers\Admin\AdminObituaryController::class, 'index'])->name('admin.obituaries.index');
        Route::get('/datatable/{newsTypeId?}', [\App\Http\Controllers\Admin\AdminObituaryController::class, 'datatable'])->name('admin.obituaries.datatable');
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminObituaryController::class, 'edit'])->name('admin.obituaries.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminObituaryController::class, 'update'])->name('admin.obituaries.update');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminObituaryController::class, 'toggleAction'])->name('admin.obituaries.toggle_action');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminObituaryController::class, 'delete'])->name('admin.obituaries.delete');
    });

    Route::prefix('/legal-notices')->group(function () {
        Route::post('/', [\App\Http\Controllers\Admin\AdminLegalNoticeController::class, 'store'])->name('admin.legal_notices.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminLegalNoticeController::class, 'create'])->name('admin.legal_notices.create');
        Route::get('/{newsTypeId?}', [\App\Http\Controllers\Admin\AdminLegalNoticeController::class, 'index'])->name('admin.legal_notices.index');
        Route::get('/datatable/{newsTypeId?}', [\App\Http\Controllers\Admin\AdminLegalNoticeController::class, 'datatable'])->name('admin.legal_notices.datatable');
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminLegalNoticeController::class, 'edit'])->name('admin.legal_notices.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminLegalNoticeController::class, 'update'])->name('admin.legal_notices.update');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminLegalNoticeController::class, 'toggleAction'])->name('admin.legal_notices.toggle_action');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminLegalNoticeController::class, 'delete'])->name('admin.legal_notices.delete');
    });

    Route::prefix('/pages')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminPagesController::class, 'index'])->name('admin.pages.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminPagesController::class, 'store'])->name('admin.pages.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminPagesController::class, 'create'])->name('admin.pages.create');
        Route::get('/datatable', [\App\Http\Controllers\Admin\AdminPagesController::class, 'datatable'])->name('admin.pages.datatable');
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminPagesController::class, 'edit'])->name('admin.pages.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminPagesController::class, 'update'])->name('admin.pages.update');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminPagesController::class, 'toggleAction'])->name('admin.pages.toggle_action');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminPagesController::class, 'delete'])->name('admin.pages.delete');
    });

    Route::prefix('/roles')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminRolesController::class, 'index'])->name('admin.roles.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminRolesController::class, 'store'])->name('admin.roles.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminRolesController::class, 'create'])->name('admin.roles.create');
        Route::get('/datatable', [\App\Http\Controllers\Admin\AdminRolesController::class, 'datatable'])->name('admin.roles.datatable');
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminRolesController::class, 'edit'])->name('admin.roles.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminRolesController::class, 'update'])->name('admin.roles.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminRolesController::class, 'delete'])->name('admin.roles.delete');
    });

    Route::prefix('images')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminImagesUploadController::class, 'index'])->name('admin.images.index');
        Route::post('/upload', [\App\Http\Controllers\Admin\AdminImagesUploadController::class, 'upload'])->name('admin.images.upload');
        Route::post('/delete/{galleryId?}', [\App\Http\Controllers\Admin\AdminImagesUploadController::class, 'delete'])->name('admin.images.delete');
    });
    Route::prefix('galleries')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminGalleriesController::class, 'index'])->name('admin.galleries.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminGalleriesController::class, 'store'])->name('admin.galleries.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminGalleriesController::class, 'create'])->name('admin.galleries.create');
        Route::get('/datatable', [\App\Http\Controllers\Admin\AdminGalleriesController::class, 'datatable'])->name('admin.galleries.datatable');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdminGalleriesController::class, 'edit'])->name('admin.galleries.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminGalleriesController::class, 'update'])->name('admin.galleries.update');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminGalleriesController::class, 'toggleAction'])->name('admin.galleries.toggle_action');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminGalleriesController::class, 'delete'])->name('admin.galleries.delete');
    });
    Route::prefix('membership-plans')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminMembershipPlanController::class, 'index'])->name('admin.membership_plans.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminMembershipPlanController::class, 'update'])->name('admin.membership_plans.update');
    });
    Route::prefix('settings')->group(function () {
        Route::post('/', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'update'])->name('admin.settings.update');
        Route::get('/general', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'general'])->name('admin.settings.general');
        Route::get('/facebook-ads', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'facebookAds'])->name('admin.settings.facebook_ads');
        Route::get('/abusive-words', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'abusiveWords'])->name('admin.settings.abusive_words');
        Route::get('/featured-marketing', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'featuredMarketing'])->name('admin.settings.featured_marketing');
        Route::put('/featured-marketing', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'updateFeaturedMarketing'])->name('admin.settings.update_featured_marketing');
    });

    Route::prefix('manage-pueblo')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminPuebloController::class, 'index'])->name('admin.manage_pueblo.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminPuebloController::class, 'store'])->name('admin.manage_pueblo.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminPuebloController::class, 'create'])->name('admin.manage_pueblo.create');
        Route::get('/datatable/{newsTypeId}', [\App\Http\Controllers\Admin\AdminPuebloController::class, 'datatable'])->name('admin.manage_pueblo.datatable');
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminPuebloController::class, 'edit'])->name('admin.manage_pueblo.edit');
        Route::patch('/update/{id}', [\App\Http\Controllers\Admin\AdminPuebloController::class, 'update'])->name('admin.manage_pueblo.update');
        Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\AdminPuebloController::class, 'delete'])->name('admin.manage_pueblo.delete');
    });

    Route::prefix('manage-plaza')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminPlazaController::class, 'index'])->name('admin.manage_plaza.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminPlazaController::class, 'store'])->name('admin.manage_plaza.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminPlazaController::class, 'create'])->name('admin.manage_plaza.create');
        Route::get('/datatable/{newsTypeId}', [\App\Http\Controllers\Admin\AdminPlazaController::class, 'datatable'])->name('admin.manage_plaza.datatable');
        Route::get('/edit/{id}', [\App\Http\Controllers\Admin\AdminPlazaController::class, 'edit'])->name('admin.manage_plaza.edit');
        Route::patch('/update/{id}', [\App\Http\Controllers\Admin\AdminPlazaController::class, 'update'])->name('admin.manage_plaza.update');
        Route::delete('/delete/{id}', [\App\Http\Controllers\Admin\AdminPlazaController::class, 'delete'])->name('admin.manage_plaza.delete');
    });

    Route::prefix('videos')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminVideosController::class, 'index'])->name('admin.videos.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminVideosController::class, 'store'])->name('admin.videos.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminVideosController::class, 'create'])->name('admin.videos.create');
        Route::get('/datatable/{type?}', [\App\Http\Controllers\Admin\AdminVideosController::class, 'datatable'])->name('admin.videos.datatable');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdminVideosController::class, 'edit'])->name('admin.videos.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminVideosController::class, 'update'])->name('admin.videos.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminVideosController::class, 'delete'])->name('admin.videos.delete');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminVideosController::class, 'toggleAction'])->name('admin.videos.toggle_action');
    });

    Route::prefix('vi-videos')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminViVideosController::class, 'index'])->name('admin.vi_videos.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminViVideosController::class, 'store'])->name('admin.vi_videos.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminViVideosController::class, 'create'])->name('admin.vi_videos.create');
        Route::get('/datatable/{type?}', [\App\Http\Controllers\Admin\AdminViVideosController::class, 'datatable'])->name('admin.vi_videos.datatable');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdminViVideosController::class, 'edit'])->name('admin.vi_videos.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminViVideosController::class, 'update'])->name('admin.vi_videos.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminViVideosController::class, 'delete'])->name('admin.vi_videos.delete');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminViVideosController::class, 'toggleAction'])->name('admin.vi_videos.toggle_action');
    });

    Route::prefix('massive-videos')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminMassiveVideosController::class, 'index'])->name('admin.massive_videos.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminMassiveVideosController::class, 'store'])->name('admin.massive_videos.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminMassiveVideosController::class, 'create'])->name('admin.massive_videos.create');
        Route::get('/datatable', [\App\Http\Controllers\Admin\AdminMassiveVideosController::class, 'datatable'])->name('admin.massive_videos.datatable');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminMassiveVideosController::class, 'delete'])->name('admin.massive_videos.delete');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminMassiveVideosController::class, 'toggleAction'])->name('admin.massive_videos.toggle_action');
    });

    Route::prefix('advertisement')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminAdController::class, 'index'])->name('admin.ads.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminAdController::class, 'store'])->name('admin.ads.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminAdController::class, 'create'])->name('admin.ads.create');
        Route::post('/get-locations', [\App\Http\Controllers\Admin\AdminAdController::class, 'getLocations'])->name('admin.ads.get_locations');
        Route::get('/datatable/{type?}', [\App\Http\Controllers\Admin\AdminAdController::class, 'datatable'])->name('admin.ads.datatable');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdminAdController::class, 'edit'])->name('admin.ads.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminAdController::class, 'update'])->name('admin.ads.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminAdController::class, 'delete'])->name('admin.ads.delete');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminAdController::class, 'toggleAction'])->name('admin.ads.toggle_action');
        Route::post('download-pdf',[\App\Http\Controllers\Admin\AdminAdController::class, 'downloadPdf'])->name('download-ad-pdf');
        Route::post('download-csv',[\App\Http\Controllers\Admin\AdminAdController::class, 'downloadCsv'])->name('download-ad-csv');
    });

    Route::prefix('questions')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminQuestionController::class, 'index'])->name('admin.questions.index');
        Route::post('/', [\App\Http\Controllers\Admin\AdminQuestionController::class, 'store'])->name('admin.questions.store');
        Route::get('/create', [\App\Http\Controllers\Admin\AdminQuestionController::class, 'create'])->name('admin.questions.create');
        Route::get('/datatable', [\App\Http\Controllers\Admin\AdminQuestionController::class, 'datatable'])->name('admin.questions.datatable');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdminQuestionController::class, 'edit'])->name('admin.questions.edit');
        Route::patch('/{id}/update', [\App\Http\Controllers\Admin\AdminQuestionController::class, 'update'])->name('admin.questions.update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdminQuestionController::class, 'delete'])->name('admin.questions.delete');
        Route::post('/{id}/toggle', [\App\Http\Controllers\Admin\AdminQuestionController::class, 'toggleAction'])->name('admin.questions.toggle_action');
    });

    Route::prefix('survey')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminSurveyController::class, 'index'])->name('admin.survey.index');
        Route::get('/datatable', [\App\Http\Controllers\Admin\AdminSurveyController::class, 'datatable'])->name('admin.survey.datatable');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdminSurveyController::class, 'show'])->name('admin.survey.show');
        Route::get('/{id}/datatable', [\App\Http\Controllers\Admin\AdminSurveyController::class, 'detailsDatatable'])->name('admin.survey.details.datatable');
    });
    Route::prefix('homepage-customization')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminHomepageCustomizationController::class, 'index'])->name('admin.homepage.customization');
        Route::post('/set-order', [\App\Http\Controllers\Admin\AdminHomepageCustomizationController::class, 'setOrder'])->name('admin.homepage.customization.set_order');
    });
    Route::prefix('topnav-customization')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AdminTopnavCustomizationController::class, 'index'])->name('admin.topnav.sorting');
        Route::post('/set-order', [\App\Http\Controllers\Admin\AdminTopnavCustomizationController::class, 'setOrder'])->name('admin.topnav.sorting.set_order');
    });




});
