<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

    // --- Helpers for simulation ---
        // Simulate: any known SQLi pattern is rejected
        // Only 'user' and 'ValidPassword123!' succeed
        // Simulate login context for a given user role
