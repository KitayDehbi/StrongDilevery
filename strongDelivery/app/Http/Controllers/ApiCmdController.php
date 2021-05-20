<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

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
        $cmds = Commande::find($cmd_id)->update(['delivery_id' => $id_delivery]);
        $cmds->save();
        return response()->json("{'status' : 'success'}");
    }
}
