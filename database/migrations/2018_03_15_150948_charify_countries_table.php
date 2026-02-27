<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CharifyCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
            $tableName = DB::getTablePrefix() . \Config::get('countries.table_name');

            Schema::table(\Config::get('countries.table_name'), function ($table) use ($tableName) {
                if (DB::getDriverName() === 'mysql') {
                    DB::statement("ALTER TABLE {$tableName} MODIFY country_code CHAR(3) NOT NULL DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} MODIFY iso_3166_2 CHAR(2) NOT NULL DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} MODIFY iso_3166_3 CHAR(3) NOT NULL DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} MODIFY region_code CHAR(3) NOT NULL DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} MODIFY sub_region_code CHAR(3) NOT NULL DEFAULT ''");
                } elseif (DB::getDriverName() === 'pgsql') {
                    // PostgreSQL syntax differs from MySQL's MODIFY.
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN country_code TYPE CHAR(3)");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN country_code SET DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN country_code SET NOT NULL");

                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN iso_3166_2 TYPE CHAR(2)");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN iso_3166_2 SET DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN iso_3166_2 SET NOT NULL");

                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN iso_3166_3 TYPE CHAR(3)");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN iso_3166_3 SET DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN iso_3166_3 SET NOT NULL");

                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN region_code TYPE CHAR(3)");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN region_code SET DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN region_code SET NOT NULL");

                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN sub_region_code TYPE CHAR(3)");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN sub_region_code SET DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN sub_region_code SET NOT NULL");
                }
            });
        }
	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
            $tableName = DB::getTablePrefix() . \Config::get('countries.table_name');

            Schema::table(\Config::get('countries.table_name'), function ($table) use ($tableName) {
                if (DB::getDriverName() === 'mysql') {
                    DB::statement("ALTER TABLE {$tableName} MODIFY country_code VARCHAR(3) NOT NULL DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} MODIFY iso_3166_2 VARCHAR(2) NOT NULL DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} MODIFY iso_3166_3 VARCHAR(3) NOT NULL DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} MODIFY region_code VARCHAR(3) NOT NULL DEFAULT ''");
                    DB::statement("ALTER TABLE {$tableName} MODIFY sub_region_code VARCHAR(3) NOT NULL DEFAULT ''");
                } elseif (DB::getDriverName() === 'pgsql') {
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN country_code TYPE VARCHAR(3)");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN iso_3166_2 TYPE VARCHAR(2)");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN iso_3166_3 TYPE VARCHAR(3)");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN region_code TYPE VARCHAR(3)");
                    DB::statement("ALTER TABLE {$tableName} ALTER COLUMN sub_region_code TYPE VARCHAR(3)");
                }
            });
	}

}
