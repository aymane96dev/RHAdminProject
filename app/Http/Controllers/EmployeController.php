<?php

namespace App\Http\Controllers;

use App\Employe;
use App\Http\Resources\EmployeResource;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeController extends Controller
{
 
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        $nbr = Employe::withTrashed()
                ->where('deleted_at', null)
                ->count();
        
        $deleted_ones = Employe::onlyTrashed()
                ->count();

        return view('layouts.gestion.employe',['nbr' => $nbr,'deleted_ones' => $deleted_ones]);
    }

    public function index()
    {
        return EmployeResource::collection(Employe::paginate(5));
    }

    public function full()
    {
        return EmployeResource::collection(Employe::all());
    }


    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'nom' => 'required|max:20',
            'prenom' => 'required|max:20',
            'date_naissance' => 'required|date',
            'num_tele' => 'required|max:20',
            'email' => 'required|max:32',
            'cin' => 'required|max:32',
            'date_integration' => 'required|date',
            'statut' => 'required|max:20',
            'photo' => 'required',
        ]);

       if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $employe=new Employe();
        $employe->nom = $request->input('nom');
        $employe->prenom = $request->input('prenom');
        $employe->date_naissance= $request->input('date_naissance');
        $employe->num_tele = $request->input('num_tele');
        $employe->email = $request->input('email');
        $employe->cin = $request->input('cin');
        $employe->date_integration = $request->input('date_integration');
        $employe->statut = $request->input('statut');
        $file = $request->file('photo')->getClientOriginalName();
        $nbr = DB::table('employes')->count()+1;
        $photoname = $nbr.'_'.$file;
        $employe->photo = $photoname;
        $path = $request->photo->storeAs('images',$photoname,'public');
        $employe->save();

        return new EmployeResource($employe);

    }

    public function destroy($id){

        $emp = Employe::find($id);
        Employe::destroy($id);

        return new EmployeResource($emp);
    }

    public function edit(Request $request){

        $validator= Validator::make($request->all(),[
            'id'=> 'required|numeric',
            'nom' => 'required|max:20',
            'prenom' => 'required|max:20',
            'date_naissance' => 'required|date',
            'num_tele' => 'required|max:20',
            'email' => 'required|max:32',
            'cin' => 'required|max:32',
            'date_integration' => 'required|date',
            'statut' => 'required|max:20',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $errors; 
        }
        $employe = Employe::find($request->input('id'));
        $employe->nom = $request->input('nom');
        $employe->prenom = $request->input('prenom');
        $employe->date_naissance= $request->input('date_naissance');
        $employe->num_tele = $request->input('num_tele');
        $employe->email = $request->input('email');
        $employe->cin = $request->input('cin');
        $employe->date_integration = $request->input('date_integration');
        $employe->statut = $request->input('statut');
        if ($request->hasFile('photo')){
            $file = $request->file('photo')->getClientOriginalName();
            $nbr = DB::table('employes')->count()+1;
            $photoname = $nbr.'_'.$file;
            $employe->photo = $photoname;
            $path = $request->photo->storeAs('images',$photoname,'public');
        }
        $employe->save();

        return new EmployeResource($employe);
    }
}
