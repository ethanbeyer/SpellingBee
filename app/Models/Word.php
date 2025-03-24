<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    // fillable columns
    protected $fillable = ['word', 'length', 'score'];


    /**
     * called any time the class is instantiated
     */
    protected static function boot()
    {
        parent::boot();

        // attributes to determine before saving a new word to the DB
        static::creating(function($word) {
            $word->length = strlen($word->word);

            // if it's less than 5 letters, 1 point
            // if it's 5 or more, the length and score are the same
            $word->score = ($word->length < 5) ? 1 : $word->length;
        });
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
