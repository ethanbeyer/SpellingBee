<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Word $word)
    {
        //
    }


    public function find_words(string $letters)
    {
        // always uppercase...
        $letters = strtoupper($letters);
        $letters_array = str_split($letters);
        $word_breakdown = [];
        
        // first make sure all the letters are unique
        $unique_letters = count(array_unique($letters_array));
        if($unique_letters !== 7 || strlen($letters) !== 7) {
            return "There must be 7 Unique Letters.";
        }

        // make sure the input is only letters
        if(!preg_match('/^[A-Z]+$/', $letters)) {
            return "This tool only searches for words with letters.";
        }


        // all the words that match these letters
        $all_words = Word::whereRaw("BINARY word REGEXP '^[{$letters}]+$'")->get();

        // letter-by-letter breakdowns
        foreach($letters_array as $letter) {
            $words_with_this_letter = $all_words->filter(function(int $value, int $key) {
                dd('HERE');
                return str_contains($value->word, $letter);
            });

            // dd($words_with_this_letter);
            
            $word_breakdown[$letter] = [
                'count' => $words_with_this_letter->count(),
                'score' => $words_with_this_letter->sum('score')
            ];
        }

        die('oh no');

        $data = [
            'letters' => $letters_array,
            'all_words' => $all_words,
            'word_breakdown' => $word_breakdown
        ];

        return view('find-words')->with($data);
    }
}
