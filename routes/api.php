<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('groups/{group}/taxa', 'GroupTaxaController@index')
    ->name('api.groups.taxa.index');

Route::get('taxa/{taxon}/public-photos', 'TaxonPublicPhotosController@index')
    ->name('api.taxa.public-photos.index');

Route::middleware(['auth:api', 'verified'])->group(function () {
    Route::post('elevation', 'ElevationController');

    // Uploads
    Route::post('uploads/photos', 'PhotoUploadsController@store')
        ->name('api.photo-uploads.store');

    Route::delete('uploads/photos/{photo}', 'PhotoUploadsController@destroy')
        ->name('api.photo-uploads.destroy');

    // Taxa
    Route::get('taxa', 'TaxaController@index')
        ->withoutMiddleware('verified')
        ->name('api.taxa.index');

    Route::post('taxa', 'TaxaController@store')
        ->name('api.taxa.store');

    Route::get('taxa/{taxon}', 'TaxaController@show')
        ->withoutMiddleware('verified')
        ->name('api.taxa.show');

    Route::put('taxa/{taxon}', 'TaxaController@update')
        ->middleware('can:update,taxon')
        ->name('api.taxa.update');

    Route::delete('taxa/{taxon}', 'TaxaController@destroy')
        ->middleware('can:delete,taxon')
        ->name('api.taxa.destroy');

    // Synonyms
    Route::post('synonyms', 'SynonymsController@store')
        ->name('api.synonyms.create');

    Route::put('synonyms/{synonym}', 'SynonymsController@update')
        ->name('api.synonyms.update');

    Route::delete('synonyms/{synonym}', 'SynonymsController@destroy')
        ->name('api.synonyms.destroy');

    // Observers
    Route::post('observers', 'ObserversController@store')
        ->name('api.observers.create');

    Route::delete('observers/{observer}', 'ObserversController@destroy')
        ->name('api.observers.destroy');

    //Orders
    Route::post('orders', 'OrdersController@store')
        ->name('api.orders.create');

    Route::put('orders/{id}', 'OrdersController@update')
        ->name('api.orders.update');

    Route::get('orders/{name}', 'OrdersController@check')
        ->name('api.orders.check')->where('name', '[A-Za-z]+');

    //Families
    Route::post('families', 'FamiliesController@store')
        ->name('api.families.create');

    Route::put('families/{id}', 'FamiliesController@update')
        ->name('api.families.update');

    Route::get('families/{name}', 'FamiliesController@check')
        ->name('api.families.check')->where('name', '[A-Za-z]+');

    Route::get('observation-types', 'ObservationTypesController@index')
        ->withoutMiddleware('verified')
        ->name('api.observation-types.index');

    // Field observations
    Route::get('field-observations', 'FieldObservationsController@index')
        ->middleware('can:list,App\FieldObservation')
        ->name('api.field-observations.index');

    Route::post('field-observations', 'FieldObservationsController@store')
        ->name('api.field-observations.store');

    Route::get('field-observations/{fieldObservation}', 'FieldObservationsController@show')
        ->middleware('can:view,fieldObservation')
        ->name('api.field-observations.show');

    Route::put('field-observations/{fieldObservation}', 'FieldObservationsController@update')
        ->middleware('can:update,fieldObservation')
        ->name('api.field-observations.update');

    Route::delete('field-observations/{fieldObservation}', 'FieldObservationsController@destroy')
        ->middleware('can:delete,fieldObservation')
        ->name('api.field-observations.destroy');

    // Poaching observations
    Route::get('poaching-observations', 'PoachingObservationsController@index')
        ->middleware('can:list,App\PoachingObservation')
        ->name('api.poaching-observations.index');

    Route::post('poaching-observations', 'PoachingObservationsController@store')
        ->name('api.poaching-observations.store');

    Route::get('poaching-observations/{poachingObservation}', 'PoachingObservationsController@show')
        ->middleware('can:view,poachingObservation')
        ->name('api.poaching-observations.show');

    Route::put('poaching-observations/{poachingObservation}', 'PoachingObservationsController@update')
        ->middleware('can:update,poachingObservation')
        ->name('api.poaching-observations.update');

    Route::delete('poaching-observations/{poachingObservation}', 'PoachingObservationsController@destroy')
        ->middleware('can:delete,poachingObservation')
        ->name('api.poaching-observations.destroy');

    // Electrocution observations
    Route::get('electrocution-observations', 'ElectrocutionObservationsController@index')
        ->middleware('can:list,App\ElectrocutionObservation')
        ->name('api.electrocution-observations.index');

    Route::post('electrocution-observations', 'ElectrocutionObservationsController@store')
        ->name('api.electrocution-observations.store');

    Route::get('electrocution-observations/{electrocutionObservation}', 'ElectrocutionObservationsController@show')
        ->middleware('can:view,electrocutionObservation')
        ->name('api.electrocution-observations.show');

    Route::put('electrocution-observations/{electrocutionObservation}', 'ElectrocutionObservationsController@update')
        ->middleware('can:update,electrocutionObservation')
        ->name('api.electrocution-observations.update');

    Route::delete('electrocution-observations/{electrocutionObservation}', 'ElectrocutionObservationsController@destroy')
        ->middleware('can:delete,electrocutionObservation')
        ->name('api.electrocution-observations.destroy');

    // Field observation exports
    Route::post('field-observation-exports', 'FieldObservationExportsController@store')
        ->name('api.field-observation-exports.store');

    // Public field observations
    Route::get('public-field-observations', 'PublicFieldObservationsController@index')
        ->name('api.public-field-observations.index');

    // Public field observation exports
    Route::post('public-field-observation-exports', 'PublicFieldObservationExportsController@store')
        ->name('api.public-field-observation-exports.store');

    Route::post('cancelled-imports', 'CancelledImportsController@store')
        ->name('api.cancelled-imports.store');

    // Field observations import
    Route::post('field-observation-imports', 'FieldObservationImportsController@store')
        ->name('api.field-observation-imports.store');

    Route::get('field-observation-imports/{import}', 'FieldObservationImportsController@show')
        ->name('api.field-observation-imports.show');

    Route::get('field-observation-imports/{import}/errors', 'FieldObservationImportsController@errors')
        ->name('api.field-observation-imports.errors');

    // Approved field observations
    Route::post('approved-field-observations/batch', 'ApprovedFieldObservationsBatchController@store')
        ->name('api.approved-field-observations-batch.store');

    // Unidentifiable field observations
    Route::post('unidentifiable-field-observations/batch', 'UnidentifiableFieldObservationsBatchController@store')
        ->name('api.unidentifiable-field-observations-batch.store');

    // Unidentifiable field observations
    Route::post('pending-field-observations/batch', 'PendingFieldObservationsBatchController@store')
        ->name('api.pending-field-observations-batch.store');

    // Users
    Route::get('users', 'UsersController@index')
        ->middleware('can:list,App\User')
        ->name('api.users.index');

    Route::get('users/{user}', 'UsersController@show')
        ->middleware('can:view,user')
        ->name('api.users.show');

    Route::put('users/{user}', 'UsersController@update')
        ->middleware('can:update,user')
        ->name('api.users.update');

    Route::delete('users/{user}', 'UsersController@destroy')
        ->middleware('can:delete,user')
        ->name('api.users.destroy');

    // Taxa
    Route::get('view-groups', 'ViewGroupsController@index')
        ->withoutMiddleware('verified')
        ->name('api.view-groups.index');

    Route::post('view-groups', 'ViewGroupsController@store')
        ->middleware('can:create,App\ViewGroup')
        ->name('api.view-groups.store');

    Route::get('view-groups/{group}', 'ViewGroupsController@show')
        ->withoutMiddleware('verified')
        ->name('api.view-groups.show');

    Route::put('view-groups/{group}', 'ViewGroupsController@update')
        ->middleware('can:update,group')
        ->name('api.view-groups.update');

    Route::delete('view-groups/{group}', 'ViewGroupsController@destroy')
        ->middleware('can:delete,group')
        ->name('api.view-groups.destroy');

    // Taxa export

    Route::post('taxon-exports', 'TaxonExportsController@store')
        ->name('api.taxon-exports.store');

    Route::get('exports/{export}', 'ExportsController@show')
        ->name('api.exports.show');

    // Taxa imports
    Route::post('taxon-imports', 'TaxonImportsController@store')
        ->name('api.taxon-imports.store');

    Route::get('taxon-imports/{import}', 'TaxonImportsController@show')
        ->name('api.taxon-imports.show');

    Route::get('taxon-imports/{import}/errors', 'TaxonImportsController@errors')
        ->name('api.taxon-imports.errors');

    // Announcements
    Route::get('announcements', 'AnnouncementsController@index')
        ->withoutMiddleware('verified')
        ->name('api.announcements.index');

    Route::get('announcements/{announcement}', 'AnnouncementsController@show')
        ->withoutMiddleware('verified')
        ->name('api.announcements.show');

    Route::post('announcements', 'AnnouncementsController@store')
        ->middleware('can:create,App\Announcement')
        ->name('api.announcements.store');

    Route::put('announcements/{announcement}', 'AnnouncementsController@update')
        ->middleware('can:update,announcement')
        ->name('api.announcements.update');

    Route::delete('announcements/{announcement}', 'AnnouncementsController@destroy')
        ->middleware('can:delete,announcement')
        ->name('api.announcements.destroy');

    Route::post('read-announcements', 'ReadAnnouncementsController@store')
        ->withoutMiddleware('verified')
        ->name('api.read-announcements.store');

    // Publication
    Route::get('publications', 'PublicationsController@index')
        ->middleware('can:list,App\Publication')
        ->name('api.publications.index');

    Route::post('publications', 'PublicationsController@store')
        ->middleware('can:create,App\Publication')
        ->name('api.publications.store');

    Route::put('publications/{publication}', 'PublicationsController@update')
        ->middleware('can:update,publication')
        ->name('api.publications.update');

    Route::delete('publications/{publication}', 'PublicationsController@destroy')
        ->middleware('can:delete,publication')
        ->name('api.publications.destroy');

    Route::post('publication-attachments', 'PublicationAttachmentsController@store')
        ->middleware('can:create,App\PublicationAttachment')
        ->name('api.publication-attachments.store');

    Route::delete('publication-attachments/{publicationAttachment}', 'PublicationAttachmentsController@destroy')
        ->middleware('can:delete,publicationAttachment')
        ->name('api.publication-attachments.destroy');

    // Literature observations
    Route::get('literature-observations', 'LiteratureObservationsController@index')
        ->middleware('can:list,App\LiteratureObservation')
        ->name('api.literature-observations.index');

    Route::post('literature-observations', 'LiteratureObservationsController@store')
        ->middleware('can:create,App\LiteratureObservation')
        ->name('api.literature-observations.store');

    Route::get('literature-observations/{literatureObservation}', 'LiteratureObservationsController@show')
        ->middleware('can:view,literatureObservation')
        ->name('api.literature-observations.show');

    Route::put('literature-observations/{literatureObservation}', 'LiteratureObservationsController@update')
        ->middleware('can:update,literatureObservation')
        ->name('api.literature-observations.update');

    Route::delete('literature-observations/{literatureObservation}', 'LiteratureObservationsController@destroy')
        ->middleware('can:delete,literatureObservation')
        ->name('api.literature-observations.destroy');

    // Literature observation exports
    Route::post('literature-observation-exports', 'LiteratureObservationExportsController@store')
        ->name('api.literature-observation-exports.store');

    // Literature observations import
    Route::post('literature-observation-imports', 'LiteratureObservationImportsController@store')
        ->name('api.literature-observation-imports.store');

    Route::get('literature-observation-imports/{import}', 'LiteratureObservationImportsController@show')
        ->name('api.literature-observation-imports.show');

    Route::get('literature-observation-imports/{import}/errors', 'LiteratureObservationImportsController@errors')
        ->name('api.literature-observation-imports.errors');

    // Sources
    Route::post('sources', 'SourcesController@store')
        ->name('api.sources.create');

    Route::delete('sources/{source}', 'SourcesController@destroy')
        ->name('api.sources.destroy');

    // My
    Route::prefix('my')->namespace('My')->group(function () {
        Route::get('field-observations', 'FieldObservationsController@index')
            ->name('api.my.field-observations.index');

        Route::get('poaching-observations', 'PoachingObservationsController@index')
            ->name('api.my.poaching-observations.index');

        Route::get('electrocution-observations', 'ElectrocutionObservationsController@index')
            ->name('api.my.electrocution-observations.index');

        Route::post('field-observations/export', 'FieldObservationExportsController@store')
            ->name('api.my.field-observation-exports.store');

        Route::get('profile', 'ProfileController@show')
            ->withoutMiddleware('verified')
            ->name('api.my.profile.show');

        Route::post('read-notifications/batch', 'ReadNotificationsBatchController@store')
            ->withoutMiddleware('verified')
            ->name('api.my.read-notifications-batch.store');

        Route::get('unread-notifications', 'UnreadNotificationsController@index')
            ->withoutMiddleware('verified')
            ->name('api.my.unread-notifications.index');
    });

    Route::prefix('curator')->namespace('Curator')->group(function () {
        Route::get('pending-observations', 'PendingObservationsController@index')
            ->middleware('can:list,App\FieldObservation')
            ->name('api.curator.pending-observations.index');

        Route::post('pending-observations/export', 'PendingObservationExportsController@store')
            ->name('api.curator.pending-observation-exports.store');

        Route::get('approved-observations', 'ApprovedObservationsController@index')
            ->middleware('can:list,App\FieldObservation')
            ->name('api.curator.approved-observations.index');

        Route::post('approved-observations/export', 'ApprovedObservationExportsController@store')
            ->name('api.curator.approved-observation-exports.store');

        Route::get('unidentifiable-observations', 'UnidentifiableObservationsController@index')
            ->middleware('can:list,App\FieldObservation')
            ->name('api.curator.unidentifiable-observations.index');

        Route::post('unidentifiable-observations/export', 'UnidentifiableObservationExportsController@store')
            ->name('api.curator.unidentifiable-observation-exports.store');
    });

    Route::prefix('autocomplete')->namespace('Autocomplete')->group(function () {
        Route::get('users', 'UsersController@index')
            ->middleware('role:admin,curator')
            ->name('api.autocomplete.users.index');

        Route::get('publications', 'PublicationsController@index')
            ->middleware('role:admin,curator')
            ->name('api.autocomplete.publications.index');
    });
});
