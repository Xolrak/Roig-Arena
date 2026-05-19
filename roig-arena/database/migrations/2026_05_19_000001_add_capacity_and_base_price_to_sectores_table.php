<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sectores', function (Blueprint $table) {
            $table->unsignedInteger('asientos_total')->default(0)->after('descripcion');
            $table->decimal('precio_base', 10, 2)->nullable()->after('asientos_total');
        });
    }

    public function down(): void
    {
        Schema::table('sectores', function (Blueprint $table) {
            $table->dropColumn(['asientos_total', 'precio_base']);
        });
    }
};