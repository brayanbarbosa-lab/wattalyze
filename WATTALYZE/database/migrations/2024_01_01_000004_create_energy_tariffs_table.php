<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnergyTariffsTable extends Migration
{
    public function up()
    {
        Schema::create('energy_tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider')->nullable();
            $table->string('region')->nullable();
            $table->string('tariff_type')->nullable();
            $table->float('peak_rate')->nullable();
            $table->float('off_peak_rate')->nullable();
            $table->float('intermediate_rate')->nullable();
            $table->time('peak_hours_start')->nullable();
            $table->time('peak_hours_end')->nullable();
            $table->float('tax_rate')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('energy_tariffs');
    }
}