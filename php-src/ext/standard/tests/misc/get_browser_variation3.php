<?php

$lst = file(__DIR__ . "/user_agents.txt", FILE_IGNORE_NEW_LINES);
foreach ($lst as $agent) {
    $pattern = get_browser($agent, true)['browser_name_pattern'];
    echo "Agent $agent\n    Matched by: $pattern\n";
}
?>
