<?php
$lines = file('C:/Users/ia647/.gemini/antigravity/brain/df5019a2-9b42-46fb-9dd9-e07008a4e322/.system_generated/logs/transcript_full.jsonl');
foreach ($lines as $line) {
    $j = json_decode($line, true);
    if ($j['step_index'] == 3353) {
        echo substr($j['content'] ?? '', 0, 1000) . "\n";
        if (!empty($j['tool_calls'])) {
            echo "Tool calls:\n" . json_encode($j['tool_calls'], JSON_PRETTY_PRINT) . "\n";
        }
        break;
    }
}

