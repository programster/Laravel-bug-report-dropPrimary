<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creating the database with raw SQL in order to create the table with a unique primary key index name.
        $createTableQuery = '
            CREATE TABLE my_table (
                id uuid NOT NULL,
                legacy_id uuid CONSTRAINT custom_constraint_name PRIMARY KEY,
                name varchar(255) NOT NULL
            );
        ';

        DB::statement($createTableQuery);

        // Now try to remove the primary key constraint (this is the bug as it does not work).
        // this doesn't work if you put the name inside an array either.
        Schema::table('my_table', function (Blueprint $table) {
            $table->dropPrimary('custom_constraint_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
