<?php

namespace App\Http\Controllers;

use App\Employe;
use App\Http\Resources\MaterielResource;
use App\Materiel;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterielController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function view()
    {
        $this->authorize('view',Materiel::class);
        return view('layouts.gestion.materiel');
    }

    public function index($id)
    {
        $this->authorize('view',Materiel::class);
        $employe = Employe::find($id);
        $materiels = $employe->materiels;
        return new MaterielResource($materiels);
    }

    public function store(Request $request)
    {
        $this->authorize('view',Materiel::class);
        $validator= Validator::make($request->all(),[
            'libelle' => 'required|max:32',
            'matricule' => 'required|max:64',
            'date_achat'=>'required|date',
            'serie'=>'required|max:64',
            'type'=>'required|max:32',
            'employeid'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors;
        }

        $materiel=new Materiel();
        $materiel->libelle = $request->input('libelle'); 
        $materiel->matricule = $request->input('matricule');
        $materiel->date_achat = $request->input('date_achat');
        $materiel->serie = $request->input('serie');
        $materiel->type = $request->input('type');
        $materiel->employe_id = $request->input('employeid');
        $materiel->save();

        return new MaterielResource($materiel);
    }

    public function edit(Request $request)
    {
        $this->authorize('view',Materiel::class);
        $validator= Validator::make($request->all(),[
            'id'=>'required|numeric',
            'libelle' => 'required|max:32',
            'matricule' => 'required|max:64',
            'date_achat'=>'required|date',
            'serie'=>'required|max:64',
            'type'=>'required|max:32'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors;
        }

        $materiel=Materiel::find($request->input('id'));
        $materiel->libelle = $request->input('libelle'); 
        $materiel->matricule = $request->input('matricule');
        $materiel->date_achat = $request->input('date_achat');
        $materiel->serie = $request->input('serie');
        $materiel->type = $request->input('type');
        $materiel->save();

        return new MaterielResource($materiel);
    }

    public function destroy($id)
    {
        $this->authorize('view',Materiel::class);
        $materiel = Materiel::find($id);
        Materiel::destroy($id);
        return new MaterielResource($materiel);
    }
}
