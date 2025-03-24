<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spelling Bee Word Tester</title>

    {{-- Bootstrap 5.3.3 CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="p-5">

    <div class="container">

        <div class="row">
            <div class="col">
                <p>The letters you entered were:</p>
                <h1 class="display-1">
                    <span>{{ implode(' - ', $letters) }}</span>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col">
                
                <div class="accordion" id="all_words_accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-all-letters" aria-expanded="false" aria-controls="collapse-all-letters">
                            {{ $all_words->count() }} {{ Str::plural('Word', count($all_words)) }} with Given Letters
                            </button>
                        </h2>
                        <div id="collapse-all-letters" class="accordion-collapse collapse" data-bs-parent="#all_words_accordion">
                            <div class="accordion-body">
                                <ul class="row row-cols-2 row-cols-lg-4">
                                    @foreach($all_words->pluck('word') as $word)
                                        <li>{{ $word }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
 
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                
                <div class="accordion" id="required_letter_accordions">
                    @foreach($word_breakdown as $letter => $letter_group)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $letter }}" aria-expanded="false" aria-controls="collapse-{{ $letter }}">
                                <strong>{{ $letter }}</strong>&nbsp;&mdash;&nbsp;{{ $letter_group['count'] }} {{ Str::plural('Word', $letter_group['count']) }} / {{ $letter_group['score'] }} {{ Str::plural('Point', $letter_group['score']) }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $letter }}" class="accordion-collapse collapse" data-bs-parent="#required_letter_accordions">
                                <div class="accordion-body">
                                    <ul class="row row-cols-4 row-cols-xs-2">
                                        @foreach($letter_group['words'] as $word)
                                            <li>{{ $word }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
 
            </div>
        </div>

    </div>



    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    
</body>
</html>


