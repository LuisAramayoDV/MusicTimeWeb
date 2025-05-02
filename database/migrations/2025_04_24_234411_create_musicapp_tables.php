<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicappTables extends Migration
{
    public function up()
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('artists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('artist_id')->nullable();
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->string('audio_path');
            $table->string('cover_image')->nullable();
            $table->unsignedBigInteger('plays_count')->default(0);
            $table->timestamps();
        });

        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('playlist_song', function (Blueprint $table) {
            $table->foreignId('playlist_id')->constrained()->onDelete('cascade');
            $table->foreignId('song_id')->constrained()->onDelete('cascade');
            $table->primary(['playlist_id', 'song_id']);
        });

        Schema::create('reproductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('song_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reproductions');
        Schema::dropIfExists('playlist_song');
        Schema::dropIfExists('playlists');
        Schema::dropIfExists('songs');
        Schema::dropIfExists('artists');
        Schema::dropIfExists('genres');
    }
}

