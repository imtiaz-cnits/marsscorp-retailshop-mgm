<?php
$lines = file('C:/Users/ia647/.gemini/antigravity/brain/df5019a2-9b42-46fb-9dd9-e07008a4e322/.system_generated/logs/transcript.jsonl');
foreach ($lines as $line) {
    $j = json_decode($line, true);
    if ($j['step_index'] == 3890) {
        if (!empty($j['truncated_fields'])) {
            echo "Truncated in compact transcript. Reading from transcript_full.jsonl...\n";
            $fullLines = file('C:/Users/ia647/.gemini/antigravity/brain/df5019a2-9b42-46fb-9dd9-e07008a4e322/.system_generated/logs/transcript_full.jsonl');
            foreach ($fullLines as $fl) {
                $fj = json_decode($fl, true);
                if ($fj['step_index'] == 3890) {
                    file_put_contents('scratch/user_step_3890.txt', $fj['content']);
                    echo "Wrote " . strlen($fj['content']) . " bytes to scratch/user_step_3890.txt\n";
                    break;
                }
            }
        } else {
            file_put_contents('scratch/user_step_3890.txt', $j['content']);
            echo "Wrote " . strlen($j['content']) . " bytes to scratch/user_step_3890.txt\n";
        }
        break;
    }
}
