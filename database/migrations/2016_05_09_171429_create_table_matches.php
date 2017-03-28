<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Match;
use App\Team;

class CreateTableMatches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('team_a')->unsigned();
            $table->foreign('team_a')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');

            $table->integer('team_b')->unsigned();
            $table->foreign('team_b')
                ->references('id')
                ->on('teams')
                ->onDelete('cascade');

            $table->dateTime('match_time'); //thoi gian bat dau tran dau

            $table->float('rate_a', 5, 2);
            $table->float('rate_b', 5, 2);


            $table->integer('result')->default(0); //id cua doi thang , = 0 neu hoa , = 1 neu ko co ket qua
            $table->string('score',32); //id cua doi thang.

            $table->integer('league_id')->unsigned(); //id cua giai dau
            $table->foreign('league_id')
                ->references('id')
                ->on('leagues')
                ->onDelete('cascade');

            $table->integer('d2top_id');
            $table->integer('d2vp_id');
            $table->integer('d2lounge_id');
            $table->smallInteger('status')->default(0);  // trang thai cua tran dau
            $table->string('handicap_a', 32);
            $table->string('handicap_b', 32);

            $table->enum('rounds', ['BO1','BO2','BO3','BO5','BO7']); // bo1, bo3 , bo5
            $table->enum('type', ['normal','handicap','10 kills','fb']); 
            $table->text('desc');
            $table->integer('score_a')->default(0);
            $table->integer('score_b')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matches');
    }
}
