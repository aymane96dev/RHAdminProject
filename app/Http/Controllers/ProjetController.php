<?php

namespace App\Http\Controllers;

use App\Equipe;
use App\Http\Resources\ProjetResource;
use App\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function view()
    {
        $this->authorize('view',Projet::class);
        return view('layouts.gestion.projet');
    }

    public function store(Request $request)
    {
        $this->authorize('view',Projet::class);
        $validator= Validator::make($request->all(),[
            'description' => 'required|max:128',
            'date_creation' => 'required|date',
            'date_livraison'=>'required|date',
            'etat'=>'required|max:32',
            'equipe_id'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $projet=new Projet();
        $projet->description = $request->input('description'); 
        $projet->date_creation = $request->input('date_creation');
        $projet->date_livraison = $request->input('date_livraison');
        $projet->etat = $request->input('etat');
        $projet->save();

        $equipe= Equipe::find($request->input('equipe_id'));
        $equipe->projets()->save($projet);

        return new ProjetResource($projet);
    }

    public function edit(Request $request)
    {
        $this->authorize('view',Projet::class);
        $validator= Validator::make($request->all(),[
            'id'=>'required|numeric',
            'description' => 'required|max:128',
            'date_creation' => 'required|date',
            'date_livraison'=>'required|date',
            'etat'=>'required|max:32',
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $projet=Projet::find($request->input('id'));
        $projet->description = $request->input('description'); 
        $projet->date_creation = $request->input('date_creation');
        $projet->date_livraison = $request->input('date_livraison');
        $projet->etat = $request->input('etat');
        $projet->save();

        return new ProjetResource($projet);
    }

    public function index($id)
    {
        $this->authorize('view',Projet::class);
        $equipe = Equipe::find($id);
        $projets = $equipe->projets;
        return new ProjetResource($projets);
    }

    public function destroy($id)
    {
        $this->authorize('view',Projet::class);
        $projet = Projet::find($id);
        Projet::destroy($id);
        return new ProjetResource($projet);
    }
}
