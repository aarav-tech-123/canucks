<?php

/**
 * PHP Info Checker
 * DELETE THIS FILE AFTER YOU'RE DONE!
 */

// Display PHP configuration information
phpinfo();

// Also check specifically for PDO drivers
echo "<h2>PDO Drivers:</h2>";
echo "<pre>";
print_r(PDO::getAvailableDrivers());
echo "</pre>";
