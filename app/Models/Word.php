<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Profanity; // ConsoleTVs\Profanity\Facades\Profanity;

class Word extends Model
{
    // mass-fillable columns
    protected $fillable = ['word', 'letters', 'length', 'score'];


    /**
     * called any time the class is instantiated
     */
    protected static function boot()
    {
        parent::boot();

        // attributes to determine before saving a new word to the DB
        static::creating(function($word) {
            $word->letters = Word::letters($word);
            $word->length  = Word::length($word);
            $word->score   = Word::score($word);
        });
    }

    /**
     * Returns the number of unique letters in the word.
     */
    public static function letters(string $word)
    {
        return count(array_unique(str_split($word)));
    }

    /**
     * Returns the length of the word.
     */
    public static function length(string $word)
    {
        return strlen($word);
    }

    /**
     * Returns the score of the word.
     *
     * 4-letter words are worth 1.
     * All other words are worth their length.
     */
    public static function score(string $word)
    {
        return (Word::length($word) < 5) ? 1 : Word::length($word);
    }

    /**
     * Prepare a word before inserting into the database.
     *
     * @param string $word
     * @return string|false Returns the prepared word or false if validation fails
     */
    public static function prepare(string $word)
    {
        $word = strtoupper(trim($word)); // Ensure uppercase and remove spaces
        $length = strlen($word);
        $unique_letters = count(array_unique(str_split($word))); // Count unique letters

        if ($length < 5 || $length > 15 || $unique_letters > 7) {
            return false; // Word does not meet criteria
        }

        // no swears/profanity/slurs
        if(Profanity::blocker($word)->clean() === false) {
            return false; // not a suitable word otherwise
        }

        return $word; // Word is valid and formatted
    }


    /**
     * Mutator to always store words in uppercase
     * @param [type] $value [description]
     */
    public function setWordAttribute(string $value)
    {
        $this->attributes['word'] = strtoupper($value);
    }
}
