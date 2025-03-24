<?php

namespace Database\Seeders;

use App\Jobs\ImportWordsJob;
use App\Models\Word;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $word_list_filepath = storage_path('full-dictionary-20k-tiny.txt');

        if (!file_exists($word_list_filepath)) {
            $this->command->error("Word list file not found: $word_list_filepath");
            return;
        }

        $data = [];
        $jobs = [];
        $skipped_words = [];
        $batch_size = 5000;

        // go through the given word list line by line
        $handle = fopen($word_list_filepath, 'r');
        while (($word = fgets($handle)) !== false) {
            $word = Word::prepare($word);

            // if the prepare() method returns false, don't do anything with this word.
            if($word === false) continue;

            // logic here matches the Word model - inserts bypass Model events.
            $letters = Word::letters($word);
            $length = Word::length($word);
            $score = Word::score($word);

            // full list of words to import
            $data[] = [
                'word' => $word,
                'letters' => $letters,
                'length' => $length,
                'score' => $score
            ];

            if (count($data) >= $batch_size) {
                $jobs[] = new ImportWordsJob($data);
                $data = [];
            }
        }
        fclose($handle);

        if (!empty($data)) {
            $jobs[] = new ImportWordsJob($data);
        }

        Bus::batch($jobs)->dispatch();
        
    }
}
