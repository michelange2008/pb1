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
Route::get('/', ['uses' => 'AccueilController@index', 'as' => 'front']);

Route::get('/visiteur', ['uses' => 'VisiteurController@index', 'as' => 'visiteur.index']);

Route::post('/visiteur/envoi', ['uses' => 'VisiteurController@envoi', 'as' => 'visiteur.envoi']);

Route::get('/visiteur/patience', ['uses' => 'VisiteurController@afficheNonValide', 'as' => 'visiteur.nonvalide']);

Route::get('/presentation', ['uses' => 'VisiteurController@presentation', 'as' => 'visiteur.presentation']);

Route::group(['middleware' => ['auth', 'isValid']], function () {

  // Gestion des utilisateurs

    Route::get('/utilisateur/tousSauf/{id}', ['uses' => 'UserController@tousSauf', 'as' => 'tousSauf']);

    Route::get('/utilisateur/changeSaisieUser/{ancien_user_id}/{nouveau_user_id}', ['uses' => 'UserController@changeSaisieUser', 'as' => 'changeSaisieUser']);

    Route::resource('/utilisateur', 'UserController');

    Route::get('/administration', ['uses' => 'AdminController@index', 'as' => 'admin.index']);

    Route::get('/administration/valide/{id}', ['uses' => 'UserController@valideUser', 'as' => 'admin.valide']);

  // Routes principales

    Route::get('/accueil', ['uses' => 'AccueilController@accueil', 'as' => 'accueil']);

    Route::get('/description', ['uses' => 'AccueilController@description', 'as' => 'description']);

    Route::get('/instructions', ['uses' => 'AccueilController@instructions', 'as' => 'instructions']);

    Route::get('/credits', ['uses' => 'AccueilController@credits', 'as' => 'credits']);

    Route::get('/contact', ['uses' => 'AccueilController@contact', 'as' => 'contact']);

    Route::get('/mentions_legales', ['uses' => 'AccueilController@mentions_legales', 'as' => 'mentions_legales']);

    Route::get('/aide', ['uses' => 'AccueilController@aide', 'as' => 'aide']);

    Route::get('/aide/video', ['uses' => 'AccueilController@video', 'as' => 'aide.video']);

  // Saisies

    Route::get('/saisie/nouvelle/{elevage}/{espece_id}', ['uses' => 'SaisieController@nouvelle', 'as' => 'saisie.nouvelle']);

    Route::get('/saisie', ['uses' => 'SaisieController@accueil', 'as' => 'saisie.accueil']);

    Route::get('/saisie/type/{type}', ['uses' => 'SaisieController@saisie', 'as' => 'saisie.type']);

    Route::post('/saisie/enregistre', ['uses' => 'SaisieController@enregistre', 'as' => 'saisie.enregistre'])->middleware('nullToZero');

    Route::get('/saisie/modifier/{saisie}', ['uses' => 'SaisieController@modifier', 'as' => 'saisie.modifier']);

    Route::get('/saisie/{theme_id}', ['uses' => 'SaisieController@alertes', 'as' => 'saisie.alertes']);

    Route::get('/saisie/resultats', ['uses' => 'SaisieController@enregistre', 'as' => 'saisie.resultats']);

    Route::post('/saisie/origines/store', ['uses' => 'SaisieController@storeOrigines', 'as' => 'saisie.origines.store']);

  // Lecture des saisies

    Route::get('/lecture/detail/{saisie_id}', ['uses' => 'LectureController@detail', 'as' => 'lecture.detail']);

    Route::get('/lecture/supprimer/{saisie_id}', ['uses' => 'LectureController@supprimer', 'as' => 'lecture.supprimer']);

    Route::get('/lecture/observations/{alerte_id}', ['uses' => 'LectureController@observations', 'as' => 'lecture.observations']);

    Route::get('/lecture/origines/{saisie_id}', ['uses' => 'LectureController@originesListe', 'as' => 'lecture.originesListe']);

    Route::get('/lecture/pdf/{saisie_id}', ['uses' => 'PdfController@index', 'as' => 'pdf']);

  // Gestion des notes

    Route::resource('/notes', 'NoteController');
});

Auth::routes();
