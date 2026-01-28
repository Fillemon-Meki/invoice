<?php
// Clear opcode cache
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "Opcode cache cleared!<br>";
} else {
    echo "Opcode cache not enabled<br>";
}

echo "<a href='index.php'>Go to Login Page</a> | <a href='check_database.php'>Check Database</a>";
?>
