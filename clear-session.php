<?php
session_start();
// Clear all session data
session_destroy();
echo "Session cleared! <a href='index.php'>Go to Homepage</a>";
?>
