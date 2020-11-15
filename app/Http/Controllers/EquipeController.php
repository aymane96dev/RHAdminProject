<?php

namespace App\Http\Controllers;

use App\Employe;
use App\Equipe;
use App\Http\Resources\EquipeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EquipeController extends Controller
{
    public function view(){
        return view('layouts.gestion.equipe');
    }

    public function index(){
        $equipes = Equipe::all();
        return new EquipeResource($equipes);
    }

    public function getEmps($id){
        $equipe = Equipe::find($id);
        $employes = $equipe->employes;
        return new EquipeResource($employes);
    }

    public function getDispEmps(){
        $employes = DB::table('employes')->where('equipe_id','=',null)->where('deleted_at','=',null)->get('*');
        return new EquipeResource($employes);
    }

    public function getIndispEmps($id){
        $employes = DB::table('employes')->where('equipe_id','=',$id)->where('deleted_at','=',null)->get('*');
        return new EquipeResource($employes);
    }

    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            'nom' => 'required|max:32',
            'mission' => 'required|max:64',
            'emps'=>'required'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $equipe=new Equipe();
        $equipe->nom = $request->input('nom'); 
        $equipe->mission = $request->input('mission');
        $equipe->save();

        $employes = $request->input('emps');
        foreach($employes as $emp)
        {
            $e = Employe::find($emp);
            if($e->equipe_id==null){
            $e->equipe_id = $equipe->id;
            $e->save();
            }
        }

        return new EquipeResource($equipe);
    }

    public function edit(Request $request){
        $validator= Validator::make($request->all(),[
            'id' => 'required|numeric',
            'nom' => 'required|max:32',
            'mission' => 'required|max:64',
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $equipe=Equipe::find($request->input('id'));
        $equipe->nom = $request->input('nom'); 
        $equipe->mission = $request->input('mission');
        $equipe->save();

        $addedemps = $request->input('addedEmps');
        $deletedemps = $request->input('deletedEmps');

        foreach($addedemps as $emp)
        {
            $e = Employe::find($emp);
            $e->equipe_id = $equipe->id;
            $e->save();
        }
        foreach($deletedemps as $emp)
        {
            $e = Employe::find($emp);
            $e->equipe_id = null;
            $e->save();
        }

        return new EquipeResource($equipe);
    }

    public function destroy($id)
    {
        $equipe=Equipe::find($id);
        Equipe::destroy($id);
        $emps = DB::table('employes')->where('equipe_id','=',$id)->where('deleted_at','=',null)->get('*');
        foreach($emps as $emp){
            $emp = Employe::find($emp->id);
            $emp->equipe_id = null;
            $emp->save();
        }
        return new EquipeResource($equipe);
    }
}
