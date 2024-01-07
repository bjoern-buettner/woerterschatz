<?php

use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/vendor/autoload.php';

$words = Yaml::parseFile(__DIR__ . '/vocabulary.yaml');

$types = array_keys($words);
shuffle($types);
$type = array_pop($types);

$keys = array_keys($words[$type]);
shuffle($keys);

header('Mime-Type: application/json; utf-8');
$case = rand(0, 2);
if ($case === 1 && count ($keys) >= 3) {
    $question = array_pop($keys);
    $wrong1 = array_pop($keys);
    $wrong2 = array_pop($keys);

    $answers = [$question, $wrong2, $wrong1];
    shuffle($answers);

    echo json_encode([
        'type' => 'multiple-choice',
        'answer' => array_search($question, $answers),
        'answers' => array_map(function (string $key) use(&$type, &$words) {
            if (is_array($words[$type][$key])) {
                shuffle($words[$type][$key]);
                return $words[$type][$key][0];
            }
            return $words[$type][$key];
        }, $answers),
        'question' => $question,
    ]);
} elseif ($case === 2 && count ($keys) >= 3) {
    $question = array_pop($keys);
    $wrong1 = array_pop($keys);
    $wrong2 = array_pop($keys);

    $answers = [$question, $wrong2, $wrong1];
    shuffle($answers);

    echo json_encode([
        'type' => 'multiple-choice',
        'answer' => array_search($question, $answers),
        'answers' => $answers,
        'question' => is_array($words[$type][$question]) ? $words[$type][$question][rand(0, count($words[$type][$question]) - 1)] : $words[$type][$question],
    ]);
} else {
    $answer = array_pop($keys);
    $question = $words[$type][$answer];
    if (is_array($question)) {
        shuffle($question);
        $question = $question[0];
    }
    echo json_encode([
        'type' => 'input',
        'answer' => $answer,
        'question' => $question,
    ]);
}
