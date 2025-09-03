<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banco', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nome');
            $table->timestamps();
        });

        Schema::create('convenio', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('convenio');
            $table->string('verba');
            $table->unsignedBigInteger('banco_id');
            $table->timestamps();

            $table->foreign('banco_id')->references('id')->on('banco')->onDelete('cascade');
        });

        Schema::create('convenio_servico', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->unsignedBigInteger('convenio_id');
            $table->string('servico');
            $table->timestamps();

            $table->foreign('convenio_id')->references('id')->on('convenio')->onDelete('cascade');
        });

        Schema::create('contrato', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->date('prazo');
            $table->decimal('valor', 15, 2);
            $table->timestamp('data_inclusao');
            $table->unsignedBigInteger('convenio_servico_id');
            $table->timestamps();

            $table->foreign('convenio_servico_id')->references('id')->on('convenio_servico')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrato');
        Schema::dropIfExists('convenio_servico');
        Schema::dropIfExists('convenio');
        Schema::dropIfExists('banco');
    }
};
