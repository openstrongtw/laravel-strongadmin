<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserAddApiTokenAtApiTokenRefershAt extends Migration
{

    /**
     * The database connection.
     * @var type
     */
    protected $connection;

    /**
     * The database schema.
     *
     * @var \Illuminate\Database\Schema\Builder
     */
    protected $schema;

    /**
     * Create a new migration instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->connection = $this->getConnection();
        $this->schema = Schema::connection($this->connection);
    }

    /**
     * Get the migration connection name.
     *
     * @return string|null
     */
    public function getConnection()
    {
        return config('strongadmin.storage.database.connection');
    }
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table_prefix = config("database.connections.{$this->connection}.prefix");
        DB::unprepared("ALTER TABLE `{$table_prefix}strongadmin_user` 
ADD COLUMN `api_token` varchar(100) NULL AFTER `updated_at`,
ADD COLUMN `api_token_at` datetime(0) NULL AFTER `api_token`,
ADD COLUMN `api_token_refresh_at` datetime(0) NULL AFTER `api_token_at`,
ADD UNIQUE INDEX `uniq_api_token`(`api_token`);");
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

}
