<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Activitylog\Models\Activity;
class CreateActivityLogTable extends Migration
{
    public function up()
    {
        Schema::connection(config('activitylog.database_connection'))->create(config('activitylog.table_name'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject', 'subject');
            $table->nullableMorphs('causer', 'causer');
            $table->integer('business_id')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
            $table->index('log_name');
        });
        $activites = Activity::with(['causer'])->get()->groupBy('causer_id');

        foreach ($activites as $activity) {
            Activity::where('causer_id', $activity->causer_id)
                ->update(['business_id' => $activity->causer->business_id ?? null]);
        }
    }

    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->dropIfExists(config('activitylog.table_name'));
    }
}
