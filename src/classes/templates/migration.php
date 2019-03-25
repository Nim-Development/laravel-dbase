<?php


namespace NimDevelopment\DBase\Classes\Templates;

class Migration
{

    public $ouput = '';

    public $name = '';
    public $names = '';
    public $up = ''; 

    public function __construct($name, $up){
        $this->name = $name;
        $this->names = $name;
        $this->up = $up;
        //add s to end of name
        $this->names.= (substr($name, -1) !== 's') ? 's' : '';  
    }

    public function build(){
        $this->ouput =
        '<?php
        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;

        class '.$this->name.' extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create("'.$this->names.'", function (Blueprint $table) {
                    $table->increments("id");
                    '.$this->up.'
                    $table->timestamps();
                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists("'.$this->names.'");
            }
        }';
    }

    public function render(){
        return $this->ouput;
    }

}


?>