<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('bride_name');
            $table->string('bride_short_name');
            $table->string('bride_parents');
            $table->string('bride_instagram')->nullable();
            $table->string('groom_name');
            $table->string('groom_short_name');
            $table->string('groom_parents');
            $table->string('groom_instagram')->nullable();
            $table->dateTime('event_at');
            $table->string('display_date');
            $table->string('akad_time');
            $table->string('reception_time');
            $table->string('venue');
            $table->text('address');
            $table->text('maps_url');
            $table->text('quote');
            $table->timestamps();
        });

        $defaults = config('invitation');

        DB::table('users')->where('role', 'admin')->orderBy('id')->each(function (object $user) use ($defaults): void {
            DB::table('invitations')->insert([
                'user_id' => $user->id,
                'slug' => 'undangan-'.$user->id,
                'bride_name' => $defaults['bride']['name'],
                'bride_short_name' => $defaults['bride']['short_name'],
                'bride_parents' => $defaults['bride']['parents'],
                'bride_instagram' => $defaults['bride']['instagram'],
                'groom_name' => $defaults['groom']['name'],
                'groom_short_name' => $defaults['groom']['short_name'],
                'groom_parents' => $defaults['groom']['parents'],
                'groom_instagram' => $defaults['groom']['instagram'],
                'event_at' => $defaults['date'],
                'display_date' => $defaults['display_date'],
                'akad_time' => $defaults['akad'],
                'reception_time' => $defaults['reception'],
                'venue' => $defaults['venue'],
                'address' => $defaults['address'],
                'maps_url' => $defaults['maps_url'],
                'quote' => $defaults['quote'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
