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

use Illuminate\Support\Facades\Auth;

Auth::routes();
//Placer les routes get avant les routes ressources

//GUEST//
//GUEST//
//GUEST//
//GUEST//
//GUEST//
//GUEST//


//PAGE ACCUEIL
Route::get('/', 'MedecinController@index')->name('accueil');

//FORMULAIRE DE CONTACT EMAIL - COMPTE UTILISATEUR
Route::get('/contact_page', 'ContactformController@contact_page')->name('contact_page');
Route::post('/contact_form_send', 'ContactformController@contact_form_send')->name('contact_form_send');

// SEARCHBAR_BAR ACCUEIL_LISTE_PUBLIC
Route::post('/autocomplete', 'SearchBarWelcomePageController@autocomplete_search')->name('autocomplete_search');

//LISTE MEDECINS PUBLIQUE
Route::get('/liste_medecins', 'MedecinController@liste_medecins')->name('liste_medecins');
Route::get('/back_to_liste_medecins/{city}/{speciality}', 'MedecinController@back_to_liste_medecins')->name('back_to_liste_medecins');

//LIRE LES REVIEWS SUR UN MEDECIN
Route::get('/read_reviews_medecin/{medecin_id}/{city}', 'CompteController@read_reviews_medecin')->name('read_reviews_medecin');

// USER
// USER
// USER
// USER
// USER
// USER
// USER

Route::get('/accueil_compte', 'CompteController@accueil_compte')->name('accueil_compte');
Route::delete('/compte_destroy/{id}', 'CompteController@destroy')->name('compte_destroy');
Route::get('/create_medecin', 'CompteController@create_medecin')->name('create_medecin');

//FORMULAIRE : CREER UN MEDECIN - CREER LA REVIEW DU MEDECIN
Route::post('/add_medecin', 'CompteController@add_medecin')->name('add_medecin');

Route::post('/review_medecin_store', 'CompteController@review_medecin_store')->name('review_medecin_store');
Route::get('/form_review_medecin', 'CompteController@form_review_medecin')->name('review_medecin');

//ECRIRE UNE REVIEW SUR UN MEDECIN
Route::get('/give_review_medecin_form/{medecin_id}', 'CompteController@give_review_medecin_form')->name('give_review_medecin_form')->middleware('auth');

Route::post('/send_review_form_medecin', 'CompteController@send_review_form_medecin')->name('send_review_form_medecin')->middleware('auth');

// PASSWORD COMPTE CHANGE, CHANGE NAME USER
Route::post('change_password', 'ChangepasswordController@change_password')->name('change_password');
Route::patch('change_name_user/{id}', 'ChangepasswordController@change_name')->name('change_name_user');


Route::get('/bac_a_sable', 'MedecinController@bac_a_sable')->name('bac_a_sable');


//COMPTE
//FORMULAIRE ADRESSE AUTOCOMPLETE
Route::get('/compte/get-address/{q}', 'CompteController@onchange_get_address')->name('get-address');

// ADMIN
// ADMIN
// ADMIN
// ADMIN
// ADMIN
// ADMIN
// ADMIN

Route::get('/admin', 'AdminController@page_connection')->name('page_connection');
Route::get('/admin_dashboard', 'AdminController@admin_dashboard')->name('admin_dashboard');
Route::get('/gestionnaire', 'AdminController@gestionnaire')->name('gestionnaire');
Route::get('/admin_logout', 'AdminController@admin_logout')->name('admin_logout');

/* Cette fausse route permet juste d'envoyer le mot de passe et le nom au middleware pour vérifier la connexion*/
Route::post('/verify_admin_connection', 'AdminController@verify_admin_connection')->name('verify_admin_connection');

//GESTIONNAIRE -- AFFICHER TOUS LES MEDECINS

Route::get('/gestionnaire_medecins_validated', 'AdminController@gestionnaire_medecins_validated')->name('gestionnaire_medecins_validated');

Route::get('/gestionnaire_medecins_refused', 'AdminController@gestionnaire_medecins_refused')->name('gestionnaire_medecins_refused');

Route::get('/gestionnaire_medecins_waiting', 'AdminController@gestionnaire_medecins_waiting')->name('gestionnaire_medecins_waiting');

//GESTIONNAIRE -- AFFICHER TOUTES LES REVIEWS

Route::get('/gestionnaire_reviews_validated', 'AdminController@gestionnaire_reviews_validated')->name('gestionnaire_reviews_validated');

Route::get('/gestionnaire_reviews_refused', 'AdminController@gestionnaire_reviews_refused')->name('gestionnaire_reviews_refused');

Route::get('/gestionnaire_reviews_waiting', 'AdminController@gestionnaire_reviews_waiting')->name('gestionnaire_reviews_waiting');


//GESTIONNAIRE - ADD MEDECINS

Route::get('/add_medecin_form', 'AdminController@add_medecin_form')->name('add_medecin_form');
Route::post('/send_medecin_form', 'AdminController@send_medecin_form')->name('send_medecin_form');

Route::get('/search_bar_admin_page', 'SearchBarAdminController@search_bar_admin_page')->name('search_bar_admin_page');

//GESTIONNAIRE - SEARCH MEDECINS IN BDD
//AJAX
Route::post('/search_city_admin_input', 'SearchBarAdminController@search_city_admin_input')->name('search_city_admin_input');
Route::post('/search_name_admin_input', 'SearchBarAdminController@search_name_admin_input')->name('search_name_admin_input');

//PAGE OF RESULTS - SEARCHBAR ADMIN 1 - 2
Route::get('/find_medecin_admin_1', 'SearchBarAdminController@find_medecin_admin_1')->name('find_medecin_admin_1');
Route::get('/find_medecin_admin_2', 'SearchBarAdminController@find_medecin_admin_2')->name('find_medecin_admin_2');

//FORM - UPDATE - MEDECIN
Route::post('/form_medecin_admin/{id}', 'SearchBarAdminController@form_medecin_admin')->name('form_medecin_admin');
Route::patch('/update_medecin_admin/{id}', 'SearchBarAdminController@update_medecin_admin')->name('update_medecin_admin');


//NEW VALIDATION - MEDECIN REVIEW WAITING TO REFUSE OR VALIDATE
// MEDECIN

Route::patch('/medecin_waiting_to_validate/{medecin_id}', 'AdminController@medecin_waiting_to_validate')->name('medecin_waiting_to_validate');
Route::patch('/medecin_waiting_to_refuse/{medecin_id}', 'AdminController@medecin_waiting_to_refuse')->name('medecin_waiting_to_refuse');

// REVIEW
Route::patch('/review_waiting_to_validate/{review_id}/{medecin_id}/{user_id}', 'AdminController@review_waiting_to_validate')->name('review_waiting_to_validate');
//----------------------------------------------------CHECK

Route::patch('/review_waiting_to_refuse/{review_id}/{user_id}', 'AdminController@review_waiting_to_refuse')->name('review_waiting_to_refuse');
//----------------------------------------------------CHECK

//VALIDATION - MEDECIN REVIEW VALIDATE TO REFUSE OR WAITING
// MEDECIN

Route::patch('/medecin_validate_to_waiting/{medecin_id}', 'AdminController@medecin_validate_to_waiting')->name('medecin_validate_to_waiting');
Route::patch('/medecin_validate_to_refuse/{medecin_id}', 'AdminController@medecin_validate_to_refuse')->name('medecin_validate_to_refuse');

// REVIEW
Route::patch('/review_validate_to_waiting/{review_id}/{medecin_id}/{user_id}', 'AdminController@review_validate_to_waiting')->name('review_validate_to_waiting');
//----------------------------------------------------CHECK

Route::patch('/review_validate_to_refuse/{review_id}/{medecin_id}/{user_id}', 'AdminController@review_validate_to_refuse')->name('review_validate_to_refuse');
//----------------------------------------------------CHECK

//VALIDATION - MEDECIN REVIEW REFUSE TO VALIDATE OR WAITING
// MEDECIN

Route::patch('/medecin_refuse_to_validate/{medecin_id}', 'AdminController@medecin_refuse_to_validate')->name('medecin_refuse_to_validate');
Route::patch('/medecin_refuse_to_waiting/{medecin_id}', 'AdminController@medecin_refuse_to_waiting')->name('medecin_refuse_to_waiting');

// REVIEW
Route::patch('/review_refuse_to_validate/{review_id}/{medecin_id}/{user_id}', 'AdminController@review_refuse_to_validate')->name('review_refuse_to_validate');
//----------------------------------------------------CHECK

Route::patch('/review_refuse_to_waiting/{review_id}/{user_id}', 'AdminController@review_refuse_to_waiting')->name('review_refuse_to_waiting');
//----------------------------------------------------CHECK
