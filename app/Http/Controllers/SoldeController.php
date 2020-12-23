<?php

namespace App\Http\Controllers;

use App\Employe;
use App\Http\Resources\SoldeResource;
use App\Solde;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SoldeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function view()
    {
        $this->authorize('view',Solde::class);
        return view('layouts.gestion.solde');
    }

    public function store(Request $request)
    {
        $this->authorize('view',Solde::class);
        $validator= Validator::make($request->all(),[
            'salaire' => 'required|numeric',
            'date_paiement' => 'required|date',
            'type_paiement'=>'required|max:32',
            'mois'=>'required|numeric',
            'annee'=>'required|numeric',
            'employeid'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $solde=new Solde();
        $solde->salaire = $request->input('salaire'); 
        $solde->date_paiement = $request->input('date_paiement');
        $solde->type_paiement = $request->input('type_paiement');
        $solde->mois = $request->input('mois');
        $solde->année = $request->input('annee');
        $solde->employe_id = $request->input('employeid');
        $solde->save();

        return new SoldeResource($solde);
    }

    public function edit(Request $request)
    {
        $this->authorize('view',Solde::class);
        $validator= Validator::make($request->all(),[
            'id'=>'required|numeric',
            'salaire' => 'required|numeric',
            'date_paiement' => 'required|date',
            'type_paiement'=>'required|max:32',
            'mois'=>'required|numeric',
            'annee'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $solde= Solde::find($request->input('id'));
        $solde->salaire = $request->input('salaire'); 
        $solde->date_paiement = $request->input('date_paiement');
        $solde->type_paiement = $request->input('type_paiement');
        $solde->mois = $request->input('mois');
        $solde->année = $request->input('annee');
        $solde->save();

        return new SoldeResource($solde);
    }

    public function index($id)
    {
        $this->authorize('view',Solde::class);
        $employe = Employe::find($id);
        $soldes = $employe->soldes;
        return new SoldeResource($soldes);
    }

    public function delete($id)
    {
        $this->authorize('view',Solde::class);
        $solde = Solde::find($id);
        Solde::destroy($id);
        return new SoldeResource($solde);
    }
}
