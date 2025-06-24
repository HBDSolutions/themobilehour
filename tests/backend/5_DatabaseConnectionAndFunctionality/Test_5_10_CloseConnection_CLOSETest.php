<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

        // Close connection
        // Try to run a query after close
        // Open and close connections multiple times
        // If all connections closed without error, resource leaks are unlikely in PHP's context.
