<?php

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/user', 'UserController@view');

Route::get('/pointage', 'PointerController@view')->name('pointage');
Route::get('/historique', 'PointerController@historypause')->name('history');
Route::get('api/ptrsHistory/{id}', 'PointerController@ptrshistory');
Route::get('api/fullPtrsHistory/{id}', 'PointerController@fullptrshistory');
Route::get('api/pointers2day', 'PointerController@index');
Route::post('api/pointersfull', 'PointerController@full');
Route::post('api/PtrInfos', 'PointerController@getinfos');
Route::post('api/addPtr', 'PointerController@store');
Route::get('api/getEmployes', 'PointerController@getEmployes');
Route::delete('api/deletePtr/{id}', 'PointerController@destroy');
Route::put('api/editPtr', 'PointerController@edit');

Route::get('/competence', 'CompetenceController@view')->name('competence');
Route::post('api/addCptce', 'CompetenceController@store');
Route::get('api/competences/{id}', 'CompetenceController@index');
Route::delete('api/deleteCptce/{idc}/{ide}', 'CompetenceController@destroy');
Route::put('api/editCptce', 'CompetenceController@edit');

Route::get('/equipe', 'EquipeController@view')->name('equipe');
Route::post('api/addEquipe', 'EquipeController@store');
Route::get('api/equipes', 'EquipeController@index');
Route::get('api/getEmpsEquipe/{id}', 'EquipeController@getEmps');
Route::get('api/getDispEmps', 'EquipeController@getDispEmps');
Route::get('api/getIndispEmps/{id}', 'EquipeController@getIndispEmps');
Route::put('api/editEquipe', 'EquipeController@edit');
Route::delete('api/deleteEmp/{id}', 'EquipeController@destroy');

Route::get('/projet', 'ProjetController@view')->name('projet');
Route::post('api/addProjet', 'ProjetController@store');
Route::get('api/projets/{id}', 'ProjetController@index');
Route::put('api/editProjet', 'ProjetController@edit');
Route::delete('api/delProjet/{id}', 'ProjetController@destroy');

Route::get('/materiel', 'MaterielController@view')->name('materiel');
Route::get('api/materiels/{id}', 'MaterielController@index');
Route::post('api/addMateriel', 'MaterielController@store');
Route::put('api/editMateriel', 'MaterielController@edit');
Route::delete('api/delMateriel/{id}', 'MaterielController@destroy');

Route::get('/solde', 'SoldeController@view')->name('solde');
Route::post('api/addSolde', 'SoldeController@store');
Route::get('api/soldes/{id}', 'SoldeController@index');
Route::put('api/editSolde', 'SoldeController@edit');
Route::delete('api/deleteSolde/{id}', 'SoldeController@delete');

Route::get('/candidat', 'CandidatController@view')->name('candidat');
Route::post('api/addCandidat', 'CandidatController@store');
Route::get('api/candidats', 'CandidatController@index');
Route::get('api/fullcandidats', 'CandidatController@all');
Route::post('api/editCandidat', 'CandidatController@edit');
Route::delete('api/deleteCandidat/{id}', 'CandidatController@destroy');

Route::get('/entretien', 'EntretienController@view')->name('entretien');
Route::post('api/addEntretien', 'EntretienController@store');
Route::get('api/entretiens', 'EntretienController@index');
Route::get('api/fullentretiens', 'EntretienController@all');
Route::get('api/entretienCandidat/{id}', 'EntretienController@getcandidat');
Route::put('api/editEntretien', 'EntretienController@edit');
Route::delete('api/deleteEntretien/{id}', 'EntretienController@destroy');
Route::get('/calEntretien', 'EntretienController@getcalendrier')->name('calentretien');
Route::get('api/getentretien/{id}', 'EntretienController@getentretien');

Route::get('/contrat', 'ContratController@view')->name('contrat');
Route::post('api/addContrat', 'ContratController@store');
Route::get('api/contrat/{id}', 'ContratController@index');
Route::put('api/editContrat', 'ContratController@edit');
Route::delete('api/delContrat/{id}', 'ContratController@destroy');

Route::get('/conge', 'CongeController@view')->name('conge');
Route::get('calendrier', 'CongeController@getCalendrier')->name('calendrier');
Route::get('/countconges', 'CongeController@countconges')->name('countconges');
Route::post('api/addConge', 'CongeController@store');
Route::get('api/conges/{id}', 'CongeController@index');
Route::put('api/editConge','CongeController@edit');
Route::delete('api/deleteConge/{id}', 'CongeController@destroy');
Route::get('api/calcultotal/{id}', 'CongeController@calcultotal');
Route::get('api/checkconges/{id}', 'CongeController@checkconges');

Route::get('/demande', 'DemandeController@view')->name('demande');
Route::get('/validatedemande', 'DemandeController@validation')->name('valdemande');
Route::post('api/addDemande', 'DemandeController@store');
Route::get('api/demandes/{id}', 'DemandeController@index');
Route::post('api/editDemande', 'DemandeController@edit');
Route::delete('api/deleteDemande/{id}', 'DemandeController@destroy');
Route::post('api/valDemande', 'DemandeController@update');

Route::get('api/users', 'UserController@list');
Route::get('api/fullusers','UserController@full');
Route::post('api/user','UserController@store');
Route::put('api/user','UserController@edit');
Route::delete('api/user/{id}','UserController@destroy');

Route::get('/employe', 'EmployeController@view')->name('employe');
Route::get('api/employes','EmployeController@index');
Route::get('api/employesfull','EmployeController@full');
Route::post('api/employe','EmployeController@store');
Route::delete('api/employe/{id}','EmployeController@destroy');
Route::post('api/employe/edit','EmployeController@edit');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

