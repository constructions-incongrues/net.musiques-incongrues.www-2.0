<?php
// Make sure this file was not accessed directly and prevent register_globals configuration array attack
if (!defined('IN_VANILLA')) exit();
// Enabled Extensions

// Constructions Incongrues custom extensions
include($Configuration['EXTENSIONS_PATH']."CiElasticsearch/default.php");
