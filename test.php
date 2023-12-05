<?php

$words = [
    'nouns' => [
        'Multiplikation' => 'Vervielfachung einer Zahl um eine andere',
        'Grundsatz' => [
            'feste Regel, die jemand zur Richtschnur seines Handelns macht',
            'allgemeingültiges Prinzip, das einer Sache zugrunde liegt, nach dem sie ausgerichtet ist, das sie kennzeichnet; Grundprinzip',
        ],
        'Divisionskalkulation' => '(bei der Kostenrechnung) anteilsmäßige Verteilung der Gesamtkosten nach bestimmten Prinzipien',
        'Facharbeiter' => 'Arbeiter mit abgeschlossener Lehre in einem anerkannten Lehrberuf',
        'Agentur' => [
            'Institution, die jemanden, etwas vertritt, jemanden, etwas vermittelt',
            'Geschäftsstelle, Büro eines Agenten',
        ],
        'Initiative' => [
            'erster tätiger Anstoß zu einer Handlung; erster Schritt bei einem bestimmten Handeln.',
            'Entschlusskraft; Unternehmungsgeist',
            'Fähigkeit, aus eigenem Antrieb zu handeln',
            'Zusammenschluss von Bürgerinnen und Bürgern, Verbänden, Vereinen, Firmen und/oder öffentlichen Einrichtungen zur Erreichung eines gemeinsamen [größer angelegten] Ziels',
            '[Recht auf] das Einbringen von Gesetzesvorlagen',
            'Begehren nach Erlass, Änderung oder Aufhebung eines Gesetzes oder Verfassungsartikels per Volksentscheid',
        ],
        'Koalition' => '(zum Zweck der Durchsetzung gemeinsamer Ziele geschlossenes) Bündnis besonders von politischen Parteien',
        'Besprechung' => [
            'ausführliches Gespräch über eine bestimmte Sache, Angelegenheit',
            'Rezension',
        ],
        'Vokabular' => [
            'Wortschatz, dessen sich jemand bedient oder der zu einem bestimmten [Fach]bereich gehört',
            'Wörterverzeichnis',
        ],
        'Assimilation' => [
            'Angleichung, Anpassung',
            'Angleichung eines Konsonanten an einen anderen (z. B. das b in mittelhochdeutsch lamb zu m in neuhochdeutsch Lamm)',
            'Angleichung eines Einzelnen oder einer Gruppe an die Eigenart einer anderen Gruppe, eines anderen Volkes',
            'Angleichung neuer Wahrnehmungsinhalte und Vorstellungen an bereits vorhandene',
            'erbliche Fixierung eines erworbenen Merkmals',
        ],
        'Finanzbuchhaltung' => 'Bestandteil des betrieblichen Rechnungswesens, der den außerbetrieblichen Werteverkehr erfasst',
        'Innovation' => [
            'geplante und kontrollierte Veränderung, Neuerung in einem sozialen System durch Anwendung neuer Ideen und Techniken',
            'Einführung von etwas Neuem; Neuerung; Reform',
            'Realisierung einer neuartigen, fortschrittlichen Lösung für ein bestimmtes Problem, besonders die Einführung eines neuen Produkts oder die Anwendung eines neuen Verfahrens',
            '(bei ausdauernden Pflanzen) jährliche Erneuerung eines Teiles des Sprosssystems',
        ],
        'Tradition' => 'etwas, was im Hinblick auf Verhaltensweisen, Ideen, Kultur o. Ä. in der Geschichte, von Generation zu Generation [innerhalb einer bestimmten Gruppe] entwickelt und weitergegeben wurde [und weiterhin Bestand hat]',
        'Renommee' => [
            'Ruf, in dem jemand, etwas steht; Leumund',
            'guter Ruf, den jemand, etwas genießt; hohes Ansehen, Wertschätzung',
        ],
        'Institution' => [
            'einem bestimmten Bereich zugeordnete gesellschaftliche, staatliche, kirchliche Einrichtung, die dem Wohl oder Nutzen des Einzelnen oder der Allgemeinheit dient',
            'bestimmten stabilen Mustern folgende Form menschlichen Zusammenlebens'
        ],
        'Start-up' => 'neu gegründetes Wirtschaftsunternehmen',
        'Hausordnung' => 'von dem Vermieter, der Vermieterin eines [Wohn]hauses, von der Leitung eines Heims o. Ä. erlassene Gesamtheit von Vorschriften für das Verhalten der Bewohner und Bewohnerinnen, Insassen und Insassinnen o. Ä., die die Benutzung bestimmter, zum Haus gehörender Einrichtungen betreffen',
    ]
];

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
    'answers' => array_map(function (string $key) use(&$ytpe, &$words) {
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
