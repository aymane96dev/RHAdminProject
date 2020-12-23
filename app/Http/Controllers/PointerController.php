<?php

namespace App\Http\Controllers;

use App\Employe;
use App\Http\Resources\PointerResource;
use App\Pointage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;

use function PHPSTORM_META\map;

class PointerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view()
    {
        /*$nbr = Employe::withTrashed()
                ->where('deleted_at', null)
                ->count();
        
        $deleted_ones = Employe::onlyTrashed()
                ->count();*/

        return view('layouts.gestion.pointage');
    }

    public function historypause()
    {
        return view('layouts.gestion.historique');
    }

    public function full(Request $request)
    {
        $ptr_date = $request->input('date');
        $ptrs = $this->index($ptr_date);
        return $ptrs;
    }

    public function ptrshistory($id)
    {
        $ptrs = DB::table('pointages')->where('id_employe','=',$id)->where('deleted_at','=',null)->paginate(5); 
        return new PointerResource($ptrs);
    }

    public function fullptrshistory($id)
    {
        $ptrs = DB::table('pointages')->where('id_employe','=',$id)->where('deleted_at','=',null)->get(); 
        return new PointerResource($ptrs);
    }

    public function getinfos(Request $request)
    {
        $ids= $request->input('ids');
        $fullnames=[];
        foreach($ids as $id){
            $emp = Employe::find($id);
            $fullname = $emp->nom.' '.$emp->prenom;
            array_push($fullnames,$fullname);
        }
        return json_encode($fullnames);
    }

    public function index($dateRequest=null)
    {
        $date=null;
        if($dateRequest != null){
            $date = $dateRequest;
        }else{
            $date = date('Y-m-d');
        }

        $pointers9H = DB::table('pointages')->where('date','=',$date)
        ->where('heure_debut','>=',date('09:00:00'))->where('heure_fin','<=',date('10:00:00'))
        ->whereNull('deleted_at')->get();
        $ptr9Hcolor=null;
        if(count($pointers9H) ){
            if(count($pointers9H) > 1)
            {
                $ptr9Hcolor = 'bg-primary';
            }else if($pointers9H[0]->libelle === 'Pause café')
            {
                $ptr9Hcolor = 'bg-custom-grey';
            }else if($pointers9H[0]->libelle === 'Pause déjeuner')
            {
                $ptr9Hcolor = 'bg-custom-purple';
            }else if($pointers9H[0]->libelle === 'Autres')
            {
                $ptr9Hcolor = 'bg-warning';
            }
        }
        $pointers10H = DB::table('pointages')->where('date','=',$date)
        ->where('heure_debut','>=',date('10:00:00'))->where('heure_fin','<=',date('11:00:00'))
        ->whereNull('deleted_at')->get();
        $ptr10Hcolor=null;
        if(count($pointers10H)){
            if(count($pointers10H) > 1)
            {
                $ptr10Hcolor = 'bg-primary';
            }else if($pointers10H[0]->libelle === 'Pause café')
            {
                $ptr10Hcolor = 'bg-custom-grey';
            }else if($pointers10H[0]->libelle === 'Pause déjeuner')
            {
                $ptr10Hcolor = 'bg-custom-purple';
            }else if($pointers10H[0]->libelle === 'Autres')
            {
                $ptr10Hcolor = 'bg-warning';
            }
        }
        $pointers11H = DB::table('pointages')->where('date','=',$date)
        ->where('heure_debut','>=',date('11:00:00'))->where('heure_fin','<=',date('12:00:00'))
        ->whereNull('deleted_at')->get();
        $ptr11Hcolor=null;
        if(count($pointers11H)){
            if(count($pointers11H) > 1)
            {
                $ptr11Hcolor = 'bg-primary';
            }else if($pointers11H[0]->libelle === 'Pause café')
            {
                $ptr11Hcolor = 'bg-custom-grey';
            }else if($pointers11H[0]->libelle === 'Pause déjeuner')
            {
                $ptr11Hcolor = 'bg-custom-purple';
            }else if($pointers11H[0]->libelle === 'Autres')
            {
                $ptr11Hcolor = 'bg-warning';
            }
        }   
        $pointers12H = DB::table('pointages')->where('date','=',$date)
        ->where('heure_debut','>=',date('12:00:00'))->where('heure_fin','<=',date('13:00:00'))
        ->whereNull('deleted_at')->get();
        $ptr12Hcolor=null;
        if(count($pointers12H)){
            if(count($pointers12H) > 1)
            {
                $ptr12Hcolor = 'bg-primary';
            }else if($pointers12H[0]->libelle === 'Pause café')
            {
                $ptr12Hcolor = 'bg-custom-grey';
            }else if($pointers12H[0]->libelle === 'Pause déjeuner')
            {
                $ptr12Hcolor = 'bg-custom-purple';
            }else if($pointers12H[0]->libelle === 'Autres')
            {
                $ptr12Hcolor = 'bg-warning';
            }
        }
        $pointers13H = DB::table('pointages')->where('date','=',$date)
        ->where('heure_debut','>=',date('13:00:00'))->where('heure_fin','<=',date('14:00:00'))
        ->whereNull('deleted_at')->get();
        $ptr13Hcolor=null;
        if(count($pointers13H)){
            if(count($pointers13H) > 1)
            {
                $ptr13Hcolor = 'bg-primary';
            }else if($pointers13H[0]->libelle === 'Pause café')
            {
                $ptr13Hcolor = 'bg-custom-grey';
            }else if($pointers13H[0]->libelle === 'Pause déjeuner')
            {
                $ptr13Hcolor = 'bg-custom-purple';
            }else if($pointers13H[0]->libelle === 'Autres')
            {
                $ptr13Hcolor = 'bg-warning';
            }
        }
        $pointers14H = DB::table('pointages')->where('date','=',$date)
        ->where('heure_debut','>=',date('14:00:00'))->where('heure_fin','<=',date('15:00:00'))
        ->whereNull('deleted_at')->get();
        $ptr14Hcolor=null;
        if(count($pointers14H)){
            if(count($pointers14H) > 1)
            {
                $ptr14Hcolor = 'bg-primary';
            }else if($pointers14H[0]->libelle === 'Pause café')
            {
                $ptr14Hcolor = 'bg-custom-grey';
            }else if($pointers14H[0]->libelle === 'Pause déjeuner')
            {
                $ptr14Hcolor = 'bg-custom-purple';
            }else if($pointers14H[0]->libelle === 'Autres')
            {
                $ptr14Hcolor = 'bg-warning';
            }
        }
        $pointers15H = DB::table('pointages')->where('date','=',$date)
        ->where('heure_debut','>=',date('15:00:00'))->where('heure_fin','<=',date('16:00:00'))
        ->whereNull('deleted_at')->get();
        $ptr15Hcolor=null;
        if(count($pointers15H)){
            if(count($pointers15H) > 1)
            {
                $ptr15Hcolor = 'bg-primary';
            }else if($pointers15H[0]->libelle === 'Pause café')
            {
                $ptr15Hcolor = 'bg-custom-grey';
            }else if($pointers15H[0]->libelle === 'Pause déjeuner')
            {
                $ptr15Hcolor = 'bg-custom-purple';
            }else if($pointers15H[0]->libelle === 'Autres')
            {
                $ptr15Hcolor = 'bg-warning';
            }
        }
        $pointers16H = DB::table('pointages')->where('date','=',$date)
        ->where('heure_debut','>=',date('16:00:00'))->where('heure_fin','<=',date('17:00:00'))
        ->whereNull('deleted_at')->get();
        $ptr16Hcolor=null;
        if(count($pointers16H)){
            if(count($pointers16H) > 1)
            {
                $ptr16Hcolor = 'bg-primary';
            }else if($pointers16H[0]->libelle === 'Pause café')
            {
                $ptr16Hcolor = 'bg-custom-grey';
            }else if($pointers16H[0]->libelle === 'Pause déjeuner')
            {
                $ptr16Hcolor = 'bg-custom-purple';
            }else if($pointers16H[0]->libelle === 'Autres')
            {
                $ptr16Hcolor = 'bg-warning';
            }
        }
        $pointers17H = DB::table('pointages')->where('date','=',$date)
        ->where('heure_debut','>=',date('17:00:00'))->where('heure_fin','<',date('18:00:00'))
        ->whereNull('deleted_at')->get();
        $ptr17Hcolor=null;
        if(count($pointers17H)){
            if(count($pointers17H) > 1)
            {
                $ptr17Hcolor = 'bg-primary';
            }else if($pointers17H[0]->libelle === 'Pause café')
            {
                $ptr17Hcolor = 'bg-custom-grey';
            }else if($pointers17H[0]->libelle === 'Pause déjeuner')
            {
                $ptr17Hcolor = 'bg-custom-purple';
            }else if($pointers17H[0]->libelle === 'Autres')
            {
                $ptr17Hcolor = 'bg-warning';
            }
        }
        $pointers2day = ['neufh'=>$pointers9H,'dixh'=>$pointers10H,'onzeh'=>$pointers11H,'douzeh'=>$pointers12H,
        'treizeh'=>$pointers13H,'quatorzeh'=>$pointers14H,'quinzeh'=>$pointers15H,'seizeh'=>$pointers16H,'dixsepth'=>$pointers17H,
        'neufhcolor'=>$ptr9Hcolor,'dixhcolor'=>$ptr10Hcolor,'onzehcolor'=>$ptr11Hcolor,'douzehcolor'=>$ptr12Hcolor,
        'treizehcolor'=>$ptr13Hcolor,'quatorzehcolor'=>$ptr14Hcolor,'quinzehcolor'=>$ptr15Hcolor,'seizehcolor'=>$ptr16Hcolor,'dixsepthcolor'=>$ptr17Hcolor];
        return new PointerResource($pointers2day);
    }

    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'id_emp' => 'required|numeric',
            'date' => 'required|date',
            'tps_debut' => 'required',
            'tps_fin' => 'required',
            'type' => 'required|max:32',
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $pointer=new Pointage();
        $pointer->date = $request->input('date');
        $pointer->heure_debut = $request->input('tps_debut');
        $pointer->heure_fin = $request->input('tps_fin');
        $pointer->libelle = $request->input('type');
        $pointer->id_employe = $request->input('id_emp');
        $pointer->save();

        return new PointerResource($pointer);
    }

    public function getEmployes()
    {
        $names=[];
        $employes = Employe::all();
        foreach($employes as $emp){
            $name = $emp->nom.' '.$emp->prenom;
            $e = new stdClass();
            $e->id = $emp->id;
            $e->name = $name;
            array_push($names,$e);
        }
        return json_encode($names);
    }

    public function destroy($id)
    {
        $ptr = Pointage::find($id);
        Pointage::destroy($id);

        return new PointerResource($ptr);
    }

    public function edit(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'id' => 'required|numeric',
            'id_emp' => 'required|numeric',
            'date' => 'required|date',
            'tps_debut' => 'required',
            'tps_fin' => 'required',
            'type' => 'required|max:32',
        ]);

        if ($validator->fails()) {
            $json_errors = $validator->errors();
            return $json_errors; 
        }

        $pointer=Pointage::find($request->input('id'));
        $pointer->date = $request->input('date');
        $pointer->heure_debut = $request->input('tps_debut');
        $pointer->heure_fin = $request->input('tps_fin');
        $pointer->libelle = $request->input('type');
        $pointer->id_employe = $request->input('id_emp');
        $pointer->save();

        return new PointerResource($pointer);
    }
}
