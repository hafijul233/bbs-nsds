<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBlameableColumnsInEnumeratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('enumerators', 'created_by')) {
            Schema::table('enumerators', function (Blueprint $table) {
                $table->integer('created_by')->unsigned()->nullable()->default(null)->after('created_at');
            });
        }

        if (! Schema::hasColumn('enumerators', 'updated_by')) {
            Schema::table('enumerators', function (Blueprint $table) {
                $table->integer('updated_by')->unsigned()->nullable()->default(null)->after('updated_at');
            });
        }

        if (! Schema::hasColumn('enumerators', 'deleted_by')) {
            Schema::table('enumerators', function (Blueprint $table) {
                $table->integer('deleted_by')->unsigned()->nullable()->default(null)->after('deleted_at');
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
        if (Schema::hasColumn('enumerators', 'created_by')) {
            Schema::table('enumerators', function (Blueprint $table) {
                $table->dropColumn('created_by');
            });
        }

        if (Schema::hasColumn('enumerators', 'updated_by')) {
            Schema::table('enumerators', function (Blueprint $table) {
                $table->dropColumn('updated_by');
            });
        }

        if (Schema::hasColumn('enumerators', 'deleted_by')) {
            Schema::table('enumerators', function (Blueprint $table) {
                $table->dropColumn('deleted_by');
            });
        }
    }
}
