<?php
$lines = file('C:/Users/ia647/.gemini/antigravity/brain/df5019a2-9b42-46fb-9dd9-e07008a4e322/.system_generated/logs/transcript.jsonl');
foreach ($lines as $line) {
    if (strpos($line, 'marsscorpdb_staging_verify') !== false && strpos($line, 'battery:migrate-from-retail') !== false) {
        $j = json_decode($line, true);
        echo "Step: {$j['step_index']}, Type: {$j['type']}\n";
    }
}

