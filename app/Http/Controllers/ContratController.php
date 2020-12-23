<?php

namespace App\Http\Controllers;

use App\Contrat;
use App\Employe;
use App\Http\Resources\ContratResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContratController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function view()
    {
        $this->authorize('view',Contrat::class);
        return view('layouts.gestion.contrat');
    }

    public function index($id)
    {
        $this->authorize('view',Contrat::class);
        $contrat = DB::table('contrats')->join('employes','employes.contrat_id','=','contrats.id')
        ->where('employes.id','=',$id)->whereNull('contrats.deleted_at')->select('contrats.*')->get();
        return new ContratResource($contrat);
    }

    public function store(Request $request)
    {
        $this->authorize('view',Contrat::class);
        $validator= Validator::make($request->all(),[
            'date_signature' => 'required|date',
            'type' => 'required|max:64',
            'salaire'=>'required|numeric',
            'employeid'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors;
        }

        $contrat=new Contrat();
        $contrat->date_signature = $request->input('date_signature'); 
        $contrat->type = $request->input('type');
        $contrat->duree = $request->input('duree');
        $contrat->salaire = $request->input('salaire');
        $contrat->employe_id = $request->input('employeid');
        $contrat->save();

        $last_contrat = DB::table('contrats')->whereNull('deleted_at')->latest()->first();
        $employe = Employe::find($request->input('employeid'));
        $employe->contrat_id = $last_contrat->id;
        $employe->save();

        return new ContratResource($contrat);
    }

    public function edit(Request $request)
    {
        $this->authorize('view',Contrat::class);
        $validator= Validator::make($request->all(),[
            'id'=>'required|numeric',
            'date_signature' => 'required|date',
            'type' => 'required|max:64',
            'salaire'=>'required|numeric',
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors;
        }

        $contrat= Contrat::find($request->input('id'));
        $contrat->date_signature = $request->input('date_signature'); 
        $contrat->type = $request->input('type');
        $contrat->duree = $request->input('duree');
        $contrat->salaire = $request->input('salaire');
        $contrat->save();

        return new ContratResource($contrat);
    }

    public function destroy($id)
    {
        $this->authorize('view',Contrat::class);
        $contrat= Contrat::find($id);
        Contrat::destroy($id);
        return new ContratResource($contrat);
    }
    
}
