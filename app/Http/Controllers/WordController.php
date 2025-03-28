<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    
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

        // sorting
        $sorted_all_words = $all_words->sortBy([
            ['score', 'desc'],
            ['word', 'asc'],
        ]);

        // letter-by-letter breakdowns
        foreach($letters_array as $letter) {

            // get the words from the list that contain this letter
            $words_with_this_letter = $sorted_all_words->filter(function(Word $value, int $key) use ($letter) {
                return str_contains($value->word, $letter);
            });
            
            // with that list, totals:
            // A. How many words from the list use this letter
            // 2. The Maximum Score for this letter
            // D. The list of words
            $word_breakdown[$letter] = [
                'count' => $words_with_this_letter->count(),
                'score' => $words_with_this_letter->sum('score'),
                'words' => $words_with_this_letter->pluck('word')->all()
            ];
        }

        // data for the view
        $data = [
            'letters' => $letters_array,
            'all_words' => $sorted_all_words,
            'word_breakdown' => $word_breakdown
        ];

        return view('find-words')->with($data);
    }
}
