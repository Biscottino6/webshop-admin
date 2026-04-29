<?php
session_start();
function is_logged_in(): bool { return isset($_SESSION['user_id']); }
