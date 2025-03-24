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
        
        // first make sure all the letters are unique
        $unique_letters = count(array_unique($letters_array));
        if($unique_letters !== 7) {
            return "There must be 7 Unique Letters.";
        }

        // all the words that match these letters
        $words = Word::whereRaw("BINARY word REGEXP '^[{$letters}]+$'")->get();


        $data = [
            'all_words' => $words,
        ];

        return view('find-words')->with($data);
    }
}
