<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Panier;
use App\Models\Plat;
use App\Models\Restaurant;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use DB;

class ApiCmdController extends Controller
{
    public function deliveryWaitingCmds(Request $request)
    {
        $cmds = Commande::whereNull('delivery_id')->get();
        return response()->json($cmds);
    }

    public function reservCmd($cmd_id,Request $request)
    {
        $id_delivery = $request->user()->id;
        $cmds = Commande::find($cmd_id)->update(['delivery_id' => $id_delivery, 'statut' => 'en cours']);
        return response()->json("{'status' : 'success'}");
    }

    public function annulerCmd($cmd_id)
    {
        $cmds = Commande::find($cmd_id)->update(['statut' => 'annuler']);
        return response()->json("{'status' : 'success'}");
    }

    public function dilevredCmd($cmd_id)
    {
        $cmds = Commande::find($cmd_id)->update(['statut' => 'livré']);
        return response()->json("{'status' : 'success'}");
    }
    
    public function allPanier($cmd_id)
    {
        $paniers = Panier::Where('commande_id', $cmd_id)->get();
        foreach ($paniers as $panier) {
            $plat = Plat::find($panier['plat_id']);
            unset($panier['plat_id']);
            $panier['plat'] = $plat;
        }
        return response()->json($paniers);
    }
    
    public function deletePanier($panier_id)
    {
        try {
            //code...
            $paniers = Panier::destroy($panier_id);
            return response()->json("{'status' : 'success'}");
        } catch (\Throwable $th) {
            return response()->json("{'status' : 'failed'}");
            //throw $th;
        }
    }

    public function allPlat($resto_id)
    {
        $plats = Plat::where('restaurant_id', $resto_id);
        return response()->json($plats);
    }
    
    public function platInfo($plat_id)
    {
        $plat = Plat::find($plat_id);
        return response()->json($plat);
    }

    public function allResto()
    {
        $restos = Restaurant::all();
        return response()->json($restos);
    }
    
    public function restoInfo($resto_id)
    {
        $resto = Restaurant::find($resto_id);
        return response()->json($resto);
    }

    public function addCmd(Request $request)
    {
        // return $request->user()->id;
        $cmdBody = request()->json()->all();
        // $cmd = $cmdBody['cmd'];
        $cmd_id = DB::table('commandes')->insertGetId(
            array('client_id'=> request()->user()->id,'adresse' => $cmdBody['adresse'], 'date' => $cmdBody['date'],'type_de_paiment'=> $cmdBody['type_de_paiment'])
        );
        // DB::insertGetId('insert into commandes (adresse, date, type_de_paiment) values (?, ?, ?)', [$cmdBody['adresse'], $cmdBody['date'],$cmdBody['type_de_paiment']]);
        $plats = $cmdBody['plats'];
        $totale = 0;
        foreach ($plats as $panier) {
            $plat = Plat::find($panier['plat_id']);
            DB::insert('insert into paniers (plat_id, commande_id, occurrence) values (?, ?, ?)', [$plat->id, $cmd_id, $panier['occurrence']]);
            $totale += $plat->prix * $panier['occurrence'];
        }
        DB::update('update commandes set total = ? where id = ?', [$totale ,$cmd_id]);
        
        // $cmds = Commande::find($cmd_id)->update(['delivery_id' => $]);
        return response()->json("{'status' : 'success'}");;
    }

}
