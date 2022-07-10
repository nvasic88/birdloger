<?php

use App\Http\Controllers\AboutPagesController;
use App\Http\Controllers\Admin\AnnouncementsController as AdminAnnouncementsController;
use App\Http\Controllers\Admin\ElectrocutionObservationsController as AdminElectrocutionObservationsController;
use App\Http\Controllers\Admin\FieldObservationsController as AdminFieldObservationsController;
use App\Http\Controllers\Admin\LiteratureObservationsController;
use App\Http\Controllers\Admin\LiteratureObservationsImportController;
use App\Http\Controllers\Admin\PoachingObservationsController as AdminPoachingObservationsController;
use App\Http\Controllers\Admin\PublicationsController;
use App\Http\Controllers\Admin\TaxaController as AdminTaxaController;
use App\Http\Controllers\Admin\TaxaImportController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\ViewGroupsController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Contributor\DashboardController;
use App\Http\Controllers\Contributor\ElectrocutionObservationsController;
use App\Http\Controllers\Contributor\ElectrocutionObservationsImportController;
use App\Http\Controllers\Contributor\FieldObservationsController;
use App\Http\Controllers\Contributor\FieldObservationsImportController;
use App\Http\Controllers\Contributor\PoachingObservationsController;
use App\Http\Controllers\Contributor\PoachingObservationsImportController;
use App\Http\Controllers\Contributor\PublicFieldObservationsController;
use App\Http\Controllers\Contributor\PublicLiteratureObservationsController;
use App\Http\Controllers\Curator\ApprovedObservationsController;
use App\Http\Controllers\Curator\PendingObservationsController;
use App\Http\Controllers\Curator\UnidentifiableObservationsController;
use App\Http\Controllers\ExportDownloadController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\GroupSpeciesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Preferences\AccountPreferencesController;
use App\Http\Controllers\Preferences\GeneralPreferencesController;
use App\Http\Controllers\Preferences\LicensePreferencesController;
use App\Http\Controllers\Preferences\NotificationsPreferencesController;
use App\Http\Controllers\TaxaController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');

Route::get('exports/{export}/download', ExportDownloadController::class)
    ->middleware(['auth', 'verified'])
    ->name('export-download');

Route::prefix(LaravelLocalization::setLocale())->middleware([
    'localeCookieRedirect', 'localizationRedirect', 'localeViewPath', 'localizationPreferenceUpdate',
])->group(function () {
    Route::auth(['verify' => false, 'confirm' => false]);
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('taxa/{taxon}', [TaxaController::class,'show'])->name('taxa.show');
    Route::get('groups', [GroupsController::class,'index'])->name('groups.index');
    Route::get('groups/{group}/species/{species}', [GroupSpeciesController::class,'show'])->name('groups.species.show');
    Route::get('groups/{group}/species', [GroupSpeciesController::class,'index'])->name('groups.species.index');

    // About pages
    Route::view('pages/about/about-project', 'pages.about.about-project')->name('pages.about.about-project');
    Route::view('pages/about/project-team', 'pages.about.project-team')->name('pages.about.project-team');
    Route::view('pages/about/organisations', 'pages.about.organisations')->name('pages.about.organisations');
    Route::get('pages/about/local-community', 'AboutPagesController@localCommunity')->name('pages.about.local-community');
    Route::view('pages/about/biodiversity-data', 'pages.about.biodiversity-data')->name('pages.about.biodiversity-data');
    Route::view('pages/about/development-supporters', 'pages.about.development-supporters')->name('pages.about.development-supporters');
    Route::get('pages/about/stats', [AboutPagesController::class,'stats'])->name('pages.about.stats');

    // Legal
    Route::view('pages/privacy-policy', 'pages.privacy-policy')->name('pages.privacy-policy');

    // Licenses
    Route::view('licenses/partially-open-license', 'licenses.partially-open-license')->name('licenses.partially-open-license');
    Route::view('licenses/closed-license', 'licenses.closed-license')->name('licenses.closed-license');
    Route::view('licenses', 'licenses.index')->name('licenses.index');

    Route::get('announcements', [AnnouncementsController::class,'index'])->name('announcements.index');
    Route::get('announcements/{announcement}', [AnnouncementsController::class,'show'])->name('announcements.show');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::redirect('/preferences', '/preferences/general')->name('preferences.index');

        Route::prefix('preferences')->namespace('Preferences')->name('preferences.')->group(function () {
            Route::get('general', [GeneralPreferencesController::class,'index'])->name('general');
            Route::patch('general', [GeneralPreferencesController::class,'update']);

            Route::get('account', [AccountPreferencesController::class,'index'])->name('account');
            Route::patch('account/password', [AccountPreferencesController::class,'changePassword'])->name('account.password');
            Route::delete('account', [AccountPreferencesController::class,'destroy'])->name('account.delete');

            Route::get('license', [LicensePreferencesController::class,'index'])->name('license');
            Route::patch('license', [LicensePreferencesController::class,'update']);

            Route::get('notifications', [NotificationsPreferencesController::class,'index'])->name('notifications');
            Route::patch('notifications', [NotificationsPreferencesController::class,'update']);
        });

        Route::prefix('contributor')->namespace('Contributor')->name('contributor.')->group(function () {
            Route::get('/', [DashboardController::class,'index'])
                ->name('index');

            Route::get('field-observations', [FieldObservationsController::class,'index'])
                ->name('field-observations.index');

            Route::get('field-observations/new', [FieldObservationsController::class,'create'])
                ->name('field-observations.create');

            Route::get('field-observations/import', [FieldObservationsImportController::class,'index'])
                ->name('field-observations-import.index');

            Route::view('field-observations/import/guide', 'contributor.field-observations-import.guide')
                ->name('field-observations-import.guide');

            Route::get('field-observations/{fieldObservation}', [FieldObservationsController::class,'show'])
                ->middleware('can:view,fieldObservation')
                ->name('field-observations.show');

            Route::get('field-observations/{fieldObservation}/edit', [FieldObservationsController::class,'edit'])
                ->middleware('can:update,fieldObservation')
                ->name('field-observations.edit');

            Route::get('poaching-observations', [PoachingObservationsController::class,'index'])
                ->name('poaching-observations.index');

            Route::get('poaching-observations/new', [PoachingObservationsController::class,'create'])
                ->name('poaching-observations.create');

            Route::get('poaching-observations/import', [PoachingObservationsImportController::class,'index'])
                ->name('poaching-observations-import.index');

            Route::view('poaching-observations/import/guide', 'contributor.poaching-observations-import.guide')
                ->name('poaching-observations-import.guide');

            Route::get('poaching-observations/{poachingObservation}', [PoachingObservationsController::class,'show'])
                ->middleware('can:view,poachingObservation')
                ->name('poaching-observations.show');

            Route::get('poaching-observations/{poachingObservation}/edit', [PoachingObservationsController::class,'edit'])
                ->middleware('can:update,poachingObservation')
                ->name('poaching-observations.edit');

            Route::get('electrocution-observations', [ElectrocutionObservationsController::class,'index'])
                ->name('electrocution-observations.index');

            Route::get('electrocution-observations/new', [ElectrocutionObservationsController::class,'create'])
                ->name('electrocution-observations.create');

            Route::get('electrocution-observations/import', [ElectrocutionObservationsImportController::class,'index'])
                ->name('electrocution-observations-import.index');

            Route::view('electrocution-observations/import/guide', 'contributor.electrocution-observations-import.guide')
                ->name('electrocution-observations-import.guide');

            Route::get('electrocution-observations/{electrocutionObservation}', [ElectrocutionObservationsController::class,'show'])
                ->middleware('can:view,electrocutionObservation')
                ->name('electrocution-observations.show');

            Route::get('electrocution-observations/{electrocutionObservation}/edit', [ElectrocutionObservationsController::class,'edit'])
                ->middleware('can:update,electrocutionObservation')
                ->name('electrocution-observations.edit');

            Route::get('public-field-observations', [PublicFieldObservationsController::class,'index'])
                ->name('public-field-observations.index');

            Route::get('public-field-observations/{fieldObservation}', [PublicFieldObservationsController::class,'show'])
                ->name('public-field-observations.show');

            Route::get('public-literature-observations', [PublicLiteratureObservationsController::class,'index'])
                ->name('public-literature-observations.index');

            Route::get('public-literature-observations/{literatureObservation}', [PublicLiteratureObservationsController::class,'show'])
                ->name('public-literature-observations.show');
        });

        Route::prefix('curator')->namespace('Curator')->name('curator.')->group(function () {
            Route::get('pending-observations', [PendingObservationsController::class,'index'])
                ->middleware('role:curator,admin')
                ->middleware('can:list,App\FieldObservation,App\PoachingObservation')
                ->name('pending-observations.index');

            Route::get('pending-observations/{fieldObservation}/edit', [PendingObservationsController::class,'edit'])
                ->middleware('role:curator,admin')
                ->name('pending-observations.edit');

            Route::get('pending-observations/{fieldObservation}', [PendingObservationsController::class,'show'])
                ->middleware('role:curator,admin')
                ->name('pending-observations.show');

            Route::get('approved-observations', [ApprovedObservationsController::class,'index'])
                ->middleware('role:curator,admin')
                ->middleware('can:list,App\FieldObservation')
                ->name('approved-observations.index');

            Route::get('approved-observations/{approvedObservation}/edit', [ApprovedObservationsController::class,'edit'])
                ->middleware('role:curator,admin')
                ->name('approved-observations.edit');

            Route::get('approved-observations/{fieldObservation}', [ApprovedObservationsController::class,'show'])
                ->middleware('role:curator,admin')
                ->name('approved-observations.show');

            Route::get('unidentifiable-observations', [UnidentifiableObservationsController::class,'index'])
                ->middleware('role:curator,admin')
                ->middleware('can:list,App\FieldObservation')
                ->name('unidentifiable-observations.index');

            Route::get('unidentifiable-observations/{unidentifiableObservation}/edit', [UnidentifiableObservationsController::class,'edit'])
                ->middleware('role:curator,admin')
                ->name('unidentifiable-observations.edit');

            Route::get('unidentifiable-observations/{fieldObservation}', [UnidentifiableObservationsController::class,'show'])
                ->middleware('role:curator,admin')
                ->name('unidentifiable-observations.show');
        });

        Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
            Route::get('field-observations', [AdminFieldObservationsController::class,'index'])
                ->middleware('role:admin')
                ->name('field-observations.index');

            Route::get('field-observations/{fieldObservation}/edit', [AdminFieldObservationsController::class,'edit'])
                ->middleware('role:admin')
                ->name('field-observations.edit');

            Route::get('field-observations/{fieldObservation}', [AdminFieldObservationsController::class,'show'])
                ->middleware('role:admin')
                ->name('field-observations.show');

            Route::get('poaching-observations', [AdminPoachingObservationsController::class,'index'])
                ->middleware('role:admin')
                ->name('poaching-observations.index');

            Route::get('poaching-observations/{poachingObservation}/edit', [AdminPoachingObservationsController::class,'edit'])
                ->middleware('role:admin')
                ->name('poaching-observations.edit');

            Route::get('poaching-observations/{poachingObservation}', [AdminPoachingObservationsController::class,'show'])
                ->middleware('role:admin')
                ->name('poaching-observations.show');

            Route::get('electrocution-observations', [AdminElectrocutionObservationsController::class,'index'])
                ->middleware('role:admin')
                ->name('electrocution-observations.index');

            Route::get('electrocution-observations/{electrocutionObservation}/edit', [AdminElectrocutionObservationsController::class,'edit'])
                ->middleware('role:admin')
                ->name('electrocution-observations.edit');

            Route::get('electrocution-observations/{electrocutionObservation}', [AdminElectrocutionObservationsController::class,'show'])
                ->middleware('role:admin')
                ->name('electrocution-observations.show');

            Route::get('taxa', [AdminTaxaController::class,'index'])
                ->middleware('role:admin,curator')
                ->name('taxa.index');

            Route::get('taxa/{taxon}/edit', [AdminTaxaController::class,'edit'])
                ->middleware('can:update,taxon')
                ->name('taxa.edit');

            Route::get('taxa/new', [AdminTaxaController::class,'create'])
                ->middleware('role:admin,curator')
                ->name('taxa.create');

            Route::get('taxa/import', [TaxaImportController::class,'index'])
                ->name('taxa-import.index');

            Route::view('taxa/import/guide', 'admin.taxon-import.guide')
                ->name('taxa-import.guide');

            Route::get('users', [UsersController::class,'index'])
                ->middleware('can:list,App\User')
                ->name('users.index');

            Route::get('users/{user}/edit', [UsersController::class,'edit'])
                ->middleware('can:update,user')
                ->name('users.edit');

            Route::put('users/{user}', [UsersController::class,'update'])
                ->middleware('can:update,user')
                ->name('users.update');

            Route::get('view-groups', [ViewGroupsController::class,'index'])
                ->middleware('role:admin')
                ->name('view-groups.index');

            Route::get('view-groups/new', [ViewGroupsController::class,'create'])
                ->middleware('can:create,App\ViewGroup')
                ->name('view-groups.create');

            Route::get('view-groups/{group}/edit', [ViewGroupsController::class,'edit'])
                ->middleware('can:update,group')
                ->name('view-groups.edit');

            Route::get('announcements', [AdminAnnouncementsController::class,'index'])
                ->middleware('can:list,App\Announcement')
                ->name('announcements.index');

            Route::get('announcements/new', [AdminAnnouncementsController::class,'create'])
                ->middleware('can:create,App\Announcement')
                ->name('announcements.create');

            Route::get('announcements/{announcement}/edit', [AdminAnnouncementsController::class,'edit'])
                ->middleware('can:update,announcement')
                ->name('announcements.edit');

            Route::get('literature-observations/import', [LiteratureObservationsImportController::class,'index'])
                ->name('literature-observations-import.index');

            Route::get('literature-observations', [LiteratureObservationsController::class,'index'])
                ->name('literature-observations.index');

            Route::get('literature-observations/new', [LiteratureObservationsController::class,'create'])
                ->name('literature-observations.create');

            Route::get('literature-observations/{literatureObservation}/edit', [LiteratureObservationsController::class,'edit'])
                ->name('literature-observations.edit');

            Route::get('literature-observations/{literatureObservation}', [LiteratureObservationsController::class,'show'])
                ->name('literature-observations.show');

            Route::get('publications', [PublicationsController::class,'index'])
                ->middleware('can:list,App\Publication')
                ->name('publications.index');

            Route::get('publications/new', [PublicationsController::class,'create'])
                ->middleware('can:create,App\Publication')
                ->name('publications.create');

            Route::get('publications/{publication}/edit', [PublicationsController::class,'edit'])
                ->middleware('can:update,publication')
                ->name('publications.edit');
        });
    });
});
