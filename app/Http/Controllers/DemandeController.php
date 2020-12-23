<?php

namespace App\Http\Controllers;

use App\Conge;
use App\Demande_conge;
use Illuminate\Http\Request;
use App\Employe;
use App\Http\Resources\DemandeResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DemandeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function view()
    {
        return view('layouts.gestion.demande');
    }

    public function validation()
    {
        $this->authorize('view',Demande_conge::class);
        return view('layouts.gestion.validationConge');
    }

    public function index($id)
    {
        $employe= Employe::find($id); 
        $demandes = $employe->demandes_conge;
        return new DemandeResource($demandes);
    }

    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'lettre_ecrit' =>'file',
            'commentaire'=>'max:64',
            'conge_id'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $demande=new Demande_conge();
        $demande->date_debut = $request->input('date_debut'); 
        $demande->date_fin = $request->input('date_fin');
        $demande->lettre_ecrit = $request->input('lettre_ecrit');
        $file = $request->file('lettre_ecrit')->getClientOriginalName();
        $nbr = DB::table('demande_conges')->count()+1;
        $filename = $nbr.'_'.$file;
        $demande->lettre_ecrit = $filename;
        $path = $request->lettre_ecrit->storeAs('demandes',$filename,'public');
        $demande->commentaire = $request->input('commentaire');
        $demande->etat_validation = $request->input('etat_validation');
        $demande->conge_id = $request->input('conge_id');
        $demande->employe_id = $request->input('employe_id');
        $demande->save();

        return new DemandeResource($demande);
    }

    public function edit(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'id'=>'required|numeric',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'lettre_ecrit' =>'file',
            'commentaire'=>'max:64',
            'conge_id'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $demande= Demande_conge::find($request->input('id'));
        $demande->date_debut = $request->input('date_debut'); 
        $demande->date_fin = $request->input('date_fin');
        $demande->lettre_ecrit = $request->input('lettre_ecrit');
        $file = $request->file('lettre_ecrit')->getClientOriginalName();
        $nbr = DB::table('demande_conges')->count()+1;
        $filename = $nbr.'_'.$file;
        $demande->lettre_ecrit = $filename;
        $path = $request->lettre_ecrit->storeAs('demandes',$filename,'public');
        $demande->commentaire = $request->input('commentaire');
        $demande->etat_validation = $request->input('etat_validation');
        $demande->conge_id = $request->input('conge_id');
        $demande->employe_id = $request->input('employe_id');
        $demande->save();

        return new DemandeResource($demande);
    }

    public function destroy($id)
    {
        $demande= Demande_conge::find($id);
        Demande_conge::destroy($id);
        return new DemandeResource($demande);
    }

    public function update(Request $request)
    {
        $this->authorize('view',Demande_conge::class);
        $demande = Demande_conge::find($request->input('id'));
        $demande->etat_validation = $request->input('etat');
        $date_debut = date_create($demande->date_debut);
        $date_fin = date_create($demande->date_fin);
        $diff = date_diff($date_debut,$date_fin);
        if($request->input('etat') === 'Validée'){
            $conge = Conge::find($request->input('conge_id'));
            $conge->nbr_jrs_acquis = $diff->format('%a');
            $conge->solde = $request->input('solde');
            $conge->save();
        }else{
            $conge = Conge::find($request->input('conge_id'));
            $conge->nbr_jrs_acquis = null;
            $conge->solde = null;
            $conge->save();
        }
        $demande->save();
        return new DemandeResource($demande);
    }
}
