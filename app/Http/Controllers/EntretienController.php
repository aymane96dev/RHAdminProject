<?php

namespace App\Http\Controllers;

use App\Candidat;
use App\Entretien;
use App\Http\Resources\EntretienResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EntretienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        $this->authorize('view',Entretien::class);
        return view('layouts.gestion.entretien');
    }

    public function store(Request $request)
    {
        $this->authorize('view',Entretien::class);
        $validator= Validator::make($request->all(),[
            'date' => 'required|date_format:Y-m-d H:i',
            'description'=>'required|max:128',
            'candidat_id'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors;
        }

        $entretien=new Entretien(); 
        $entretien->date = $request->input('date');
        $entretien->description = $request->input('description');
        $entretien->id_candidat = $request->input('candidat_id');
        $entretien->save();

        $candidat = Candidat::find($request->input('candidat_id'));
        $entretien1 = DB::table('entretiens')->latest()->first();
        $candidat->id_entretien = $entretien1->id;
        $candidat->save();

        return new EntretienResource($entretien);
    }

    public function edit(Request $request)
    {
        $this->authorize('view',Entretien::class);
        $validator= Validator::make($request->all(),[
            'id'=> 'required|numeric',
            'date' => 'required|date_format:Y-m-d H:i',
            'description'=>'required|max:128',
            'candidat_id'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors;
        }

        $entretien=Entretien::find($request->input('id'));
        $entretien->date = $request->input('date');
        $entretien->description = $request->input('description');
        $entretien->id_candidat = $request->input('candidat_id');
        $entretien->save();

        $candidat = Candidat::find($request->input('candidat_id'));
        $candidat->id_entretien = $entretien->id;
        $candidat->save();

        return new EntretienResource($entretien);
    }

    public function index()
    {
        $this->authorize('view',Entretien::class);
        $entretiens = Entretien::paginate(5);
        return new EntretienResource($entretiens);
    }

    public function all()
    {
        $this->authorize('view',Entretien::class);
        $entretiens = Entretien::all();
        return new EntretienResource($entretiens);
    }

    public function getcandidat($id)
    {
        $this->authorize('view',Entretien::class);
        $entretien = Entretien::find($id);
        $candidat = Candidat::find($entretien->id_candidat);
        return new EntretienResource($candidat);
    }

    public function destroy($id)
    {
        $this->authorize('view',Entretien::class);
        $entretien = Entretien::find($id);
        Entretien::destroy($id);
        return new EntretienResource($entretien);
    }

    public function getcalendrier()
    {
        $this->authorize('view',Entretien::class);
        return view('layouts.gestion.calendrierEntretien');
    }

    public function getentretien($id)
    {
        $this->authorize('view',Entretien::class);
        $entretien = Entretien::find($id);
        return new EntretienResource($entretien);
    }
}
