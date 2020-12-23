<?php

namespace App\Http\Controllers;

use App\Conge;
use App\Demande_conge;
use App\Employe;
use App\Http\Resources\CongeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CongeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function view()
    {
        return view('layouts.gestion.conge');
    }

    public function getCalendrier(){
        return view('layouts.gestion.calendrier');
    }

    public function countconges()
    {
        $this->authorize('view',Conge::class);
        return view('layouts.gestion.countconges');
    }

    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'type' => 'required|max:32',
            'id_emp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $conge=new Conge();
        $conge->type = $request->input('type'); 
        $conge->employe_id = $request->input('id_emp');
        $conge->save();

        return new CongeResource($conge);
    }

    public function index($id)
    {
        $employe= Employe::find($id); 
        $conges = $employe->conges;
        return new CongeResource($conges);
    }

    public function calcultotal($id)
    {
        $this->authorize('view',Conge::class);
        $nbrjrs = DB::table('conges')->where('employe_id','=',$id)->whereNull('deleted_at')->sum('nbr_jrs_acquis');
        $soldes = DB::table('conges')->where('employe_id','=',$id)->whereNull('deleted_at')->sum('solde');
        $nbr_conges = DB::table('conges')->where('employe_id','=',$id)->where('nbr_jrs_acquis','<>',null)
        ->where('solde','<>',null)->whereNull('deleted_at')->count();
        $total = ['nbrjrs'=>$nbrjrs,'soldes'=>$soldes,'nbrconges'=>$nbr_conges];
        return new CongeResource($total);
    }

    public function checkconges($id)
    {
        $this->authorize('view',Conge::class);
        $conges=DB::table('demande_conges')
        ->join('conges', 'demande_conges.conge_id', '=', 'conges.id')
        ->select('conges.*','demande_conges.etat_validation')
        ->where('demande_conges.etat_validation','=','Validée')
        ->where('conges.employe_id','=',$id)
        ->whereNull('conges.deleted_at')
        ->distinct()
        ->get('conges.*');

        return new CongeResource($conges);
    }

    public function edit(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'id'=>'required|numeric',
            'type' => 'required|max:32',
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $conge= Conge::find($request->input('id'));
        $conge->type = $request->input('type'); 
        $conge->save();

        return new CongeResource($conge); 
    }

    public function destroy($id)
    {
        $conge= Conge::find($id);
        Conge::destroy($id);
        return new CongeResource($conge);
    }

}
