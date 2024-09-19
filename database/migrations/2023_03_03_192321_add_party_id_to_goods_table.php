<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const TABLE = 'goods';
    private const COLUMN = 'party_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::whenTableDoesntHaveColumn(self::TABLE, self::COLUMN, static function (Blueprint $table) {
            $table->unsignedBigInteger(self::COLUMN)->nullable()->after('id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::whenTableHasColumn(self::TABLE, self::COLUMN, static function (Blueprint $table) {
            $table->dropColumn(self::COLUMN);
        });
    }
};
