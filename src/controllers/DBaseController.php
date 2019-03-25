<?php

namespace  NimDevelopment\DBase\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class DBaseController extends Controller
{

    public function make_migration(Request $request, $name, $mdl = null){

        $req = json_decode($request->getContent(), true);

        if(resolve('DBase')->make_table($req, $name)){
            if($mdl){
                Artisan::call('make:model ' . ucfirst($name));
                return response()->json([
                    'state' => 'success',
                    'did' => 'Migration + Model'
                ]);
            }
        return response()->json([
            'state' => 'success',
            'did' => 'Migration'
        ]);
        }
    return response()->json([
        'state' => 'fail'
    ]);
    } 

    public function migrate(){
        $this->mgrt();
    }

    private function mgrt(){
        Artisan::call('migrate', ['--path' => config('DBase.migration_path'), '--force' => true]);
    }

    public function make_model($name){
        Artisan::call('make:model ' . ucfirst($name));
    }
    

}
