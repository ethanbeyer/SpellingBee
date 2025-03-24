<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
            $word->letters = count(array_unique(str_split($word->word)));
            $word->length = strlen($word->word);

            // if it's less than 5 letters, 1 point
            // if it's 5 or more, the length and score are the same
            $word->score = ($word->length < 5) ? 1 : $word->length;
        });
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
