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
if (rand(0, 1) === 1) {
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
$datetime = date('Y-m-d H:i:s');
file_put_contents(__DIR__ . '/log.txt', "$datetime {$_SERVER['REMOTE_ADDR']}\n", FILE_APPEND);
