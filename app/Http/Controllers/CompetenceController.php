<?php

namespace App\Http\Controllers;

use App\Competence;
use App\Employe;
use App\Http\Resources\CompetenceResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompetenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function view()
    {
        return view('layouts.gestion.competence');
    }

    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'id_emp' => 'required|numeric',
            'nom' => 'required|max:32',
            'niveau' => 'required|max:20',
            'certificat' => 'max:32',
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $competence=new Competence();
        $competence->nom = $request->input('nom');
        $competence->niveau = $request->input('niveau');
        $competence->certificat = $request->input('certificat');
        $competence->save();

        $id_employe = $request->input('id_emp');
        $employe = Employe::find($id_employe);
        $employe->competences()->save($competence);

        return new CompetenceResource($competence);
    }

    public function index($id)
    {
        $employe= Employe::find($id);
        $competences = $employe->competences;
        return new CompetenceResource($competences);
    }

    public function destroy($idc,$ide)
    {
        $competence = Competence::find($idc);
        Competence::destroy($idc);
        return new CompetenceResource($competence);
    }

    public function edit(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'id' => 'required|numeric',
            'nom' => 'required|max:32',
            'niveau' => 'required|max:20',
            'certificat' => 'max:32',
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $competence=Competence::find($request->input('id'));
        $competence->nom = $request->input('nom');
        $competence->niveau = $request->input('niveau');
        $competence->certificat = $request->input('certificat');
        $competence->save();

        return new CompetenceResource($competence);
    }
}
