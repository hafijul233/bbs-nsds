<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDivisionIdOnStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('states', 'division_id')) {
            Schema::table('states', function (Blueprint $table) {
                $table->foreignId('division_id')->nullable()->default(null)->after('native');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('states', 'division_id')) {
            Schema::table('states', function (Blueprint $table) {
                $table->dropColumn('division_id');
            });
        }
    }
}
