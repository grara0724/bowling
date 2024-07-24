<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScoreCalculationController extends Controller
{
    public function calc(Request $request)
    {
        $throw_scores = $request->input('throw-score');
        $total_scores = [];
        $accumulated_score = 0;

        for ($round = 1; $round <= 10; $round++) {
            $first_throw_score = (int)$throw_scores[$round * 2 - 2];
            $second_throw_score = (int)$throw_scores[$round * 2 - 1];
            $round_score = $this->calcRoundScore($first_throw_score, $second_throw_score);
            // ボーナススコアの計算
            // スペアもしくはストライク以外の時
            if ($round_score < 10) {
                $bonus_score = 0;
            }
            // ストライクの時
            else if ($first_throw_score == 10) {
                $bonus_score = $this->calcStrikeBonusScore($throw_scores, $round);
            }
            // スペアの時
            else {
                $bonus_score =  $this->calcSpareBonusScore($throw_scores, $round);
            }
            $accumulated_score += $round_score + $bonus_score;
            $total_scores[] = $accumulated_score;
        }
        $date = [
            'total_scores' => $total_scores,
            'throw_scores' => $throw_scores
        ];
        return view('index', $date);
    }


    // 1ラウンドのボーナス抜きのスコアを計算
    // 仮引数は抽象化
    public function calcRoundScore($first_throw_score, $second_throw_score)
    {
        //ストライクの時
        if ($first_throw_score == 10) {
            $round_score = 10;
        }
        // ストライクじゃない時
        else {
            $round_score = $first_throw_score + $second_throw_score;
        }
        return $round_score;
    }

    // 1ラウンドのスペアボーナスを計算
    public function calcSpareBonusScore($throw_scores, $round)
    {
        $spare_bonus_score = (int)$throw_scores[($round * 2)];
        return $spare_bonus_score;
    }


    // 1ラウンドのストライクボーナスを計算
    public function calcStrikeBonusScore($throw_scores, $round)
    {
        // 8ラウンド目までの時
        if ($round <= 8) {
            $bonus_first_throw_score = (int)$throw_scores[($round * 2)];
            // 2連続ストライクの時
            if ($bonus_first_throw_score == 10) {
                $bonus_second_throw_score = (int)$throw_scores[($round * 2 + 2)];
            } else {
                $bonus_second_throw_score = (int)$throw_scores[($round * 2 + 1)];
            }
        }
        // 9ラウンド目の時
        else if ($round == 9) {
            $bonus_first_throw_score = (int)$throw_scores[($round * 2)];
            $bonus_second_throw_score = (int)$throw_scores[($round * 2 + 1)];
        }
        // 10ラウンド目の時
        else {
            $bonus_first_throw_score = (int)$throw_scores[($round * 2 - 1)];
            $bonus_second_throw_score = (int)$throw_scores[($round * 2)];
        }
        $strike_bonus_score = $bonus_first_throw_score + $bonus_second_throw_score;
        return  $strike_bonus_score;
    }
}
