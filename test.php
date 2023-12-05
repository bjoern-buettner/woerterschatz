<?php

use Symfony\Component\Yaml\Yaml;

require_once __DIR__ . '/vendor/autoload.php';

$words = Yaml::parseFile(__DIR__ . '/vocabulary.yaml');

$types = array_keys($words);
shuffle($types);
$type = array_pop($types);

$keys = array_keys($words[$type]);
shuffle($keys);

$question = array_pop($keys);
$wrong1 = array_pop($keys);
$wrong2 = array_pop($keys);

$answers = [$question, $wrong2, $wrong1];
shuffle($answers);

header('Mime-Type: application/json; utf-8');
echo json_encode([
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
$datetime = date('Y-m-d H:i:s');
file_put_contents(__DIR__ . '/log.txt', "$datetime {$_SERVER['REMOTE_ADDR']}\n", FILE_APPEND);
