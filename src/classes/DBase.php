<?php 

namespace NimDevelopment\DBase\Classes;

use NimDevelopment\DBase\Classes\Templates\Migration;

class DBase
{
    //Can only be called on existing migrations.
    public function make_table($req, $name){

        // Build Path
        $date = str_replace('-','_',\Carbon\Carbon::now()->toDateString());
        $prepend = $this->last_6_ints();
        $file_name = $date.'_'.$prepend.'_'.$name.'.php';
        $migration_path = base_path(config('DBase.migration_path').'/'.$file_name);

        // Build table contents
        $up = '';
        foreach($req as $col){
            $nullable = ($col['nullable']) ? '->nullable();' : ';';
            $up .= '$table->'.$col['type'].'("'.$col['name'].'")'.$nullable;
        }
        
        $migration_tpl = new Migration($name, $up);
        $migration_tpl->build();

        //Write and save migration file
        $myfile = fopen($migration_path, "w") or die("Unable to open file!");
        if(fwrite($myfile, $migration_tpl->render())){
            if(fclose($myfile)){
                return true;
            }
        } return false; 
    }

    private function last_6_ints(){
        // From current time.
        return str_replace(':','',\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', \Carbon\Carbon::now())->format('H:i:s'));
    }

    public function model(){
        
    }
}

?>