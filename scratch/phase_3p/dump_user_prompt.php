<?php
$f = fopen('C:/Users/ia647/.gemini/antigravity/brain/df5019a2-9b42-46fb-9dd9-e07008a4e322/.system_generated/logs/transcript_full.jsonl', 'r');
$out = fopen(__DIR__ . '/last_user_prompt.txt', 'w');
while (($line = fgets($f)) !== false) {
    $data = json_decode($line, true);
    if ($data && isset($data['step_index']) && $data['step_index'] == 4523) {
        fwrite($out, $data['content']);
        echo "Found and wrote prompt to last_user_prompt.txt\n";
        break;
    }
}
fclose($f);
fclose($out);

