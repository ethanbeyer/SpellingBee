<?php

namespace Database\Seeders;

use App\Jobs\ImportWordsJob;
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
        $word_list_filepath = storage_path('full-dictionary2.txt');

        if (!file_exists($word_list_filepath)) {
            $this->command->error("Word list file not found: $word_list_filepath");
            return;
        }

        $data = [];
        $jobs = [];
        $batch_size = 5000;

        $handle = fopen($word_list_filepath, 'r');
        while (($word = fgets($handle)) !== false) {
            $word = trim($word);

            // first determine if we should do anything with this word
            // is it long enough (4 letters or more)?
            // can it be made with only 7 letters?
            if($this->word_is_eligible($word) === false) continue;

            // logic here matches the Word model - inserts bypass Model events.
            $word = strtoupper($word);
            $length = strlen($word);
            $score = ($length < 5) ? 1 : $length;

            // full list of words to import
            $data[] = ['word' => $word, 'length' => $length, 'score' => $score];

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

    private function word_is_eligible(string $word)
    {
        // if length < 4 return false
        $letter_count = strlen($word);
        if($letter_count < 4) return false;

        // if letter count > 7 return false
        $unique_letters = count(array_unique(str_split($word)));
        if($unique_letters > 7) return false;

        return true;
    }
}
