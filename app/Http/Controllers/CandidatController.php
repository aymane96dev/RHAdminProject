<?php

namespace App\Http\Controllers;

use App\Candidat;
use App\Http\Resources\CandidatResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        $this->authorize('view',Candidat::class);
        return view('layouts.gestion.candidat');
    }

    public function store(Request $request)
    {
        $this->authorize('view',Candidat::class);
        $validator= Validator::make($request->all(),[
            'nom' => 'required|max:20',
            'prenom' => 'required|max:20',
            'num_tel'=>'required|max:20',
            'email'=>'required|max:32',
            'cv' =>'file',
            'diplome'=>'required|max:64'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $candidat = new Candidat();
        $candidat->nom = $request->input('nom'); 
        $candidat->prenom = $request->input('prenom');
        $candidat->num_tel = $request->input('num_tel');
        $candidat->email = $request->input('email');
        $file = $request->file('cv')->getClientOriginalName();
        $filename = rand(1,99).'_'.$file;
        $candidat->cv = $filename;
        $path = $request->cv->storeAs('cvs',$filename,'public');
        $candidat->diplome = $request->input('diplome');
        $candidat->save();

        return new CandidatResource($candidat);
    }

    public function index()
    {
        $this->authorize('view',Candidat::class);
        $candidats = Candidat::paginate(5);
        return new CandidatResource($candidats);
    }

    public function all()
    {
        $this->authorize('view',Candidat::class);
        $candidats = Candidat::all();
        return new CandidatResource($candidats);
    }

    public function destroy($id)
    {
        $this->authorize('view',Candidat::class);
        $candidat = Candidat::find($id);
        Candidat::destroy($id);
        return new CandidatResource($candidat);
    }

    public function edit(Request $request)
    {
        $this->authorize('view',Candidat::class);
        $validator= Validator::make($request->all(),[
            'id'=>'required|numeric',
            'nom' => 'required|max:20',
            'prenom' => 'required|max:20',
            'num_tel'=>'required|max:20',
            'email'=>'required|max:32',
            'cv' =>'required',
            'diplome'=>'required|max:64'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $candidat = Candidat::find($request->input('id'));
        $candidat->nom = $request->input('nom'); 
        $candidat->prenom = $request->input('prenom');
        $candidat->num_tel = $request->input('num_tel');
        $candidat->email = $request->input('email');
        if ($request->hasFile('cv')) {
            $file = $request->file('cv')->getClientOriginalName();
            $filename = rand(100,199).'_'.$file;
            $candidat->cv = $filename;
            $path = $request->cv->storeAs('cvs',$filename,'public');
        }
        $candidat->diplome = $request->input('diplome');
        $candidat->save();

        return new CandidatResource($candidat);
    }
}
