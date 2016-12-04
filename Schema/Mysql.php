<?php

namespace Kanboard\Plugin\OAuth2\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec('ALTER TABLE users ADD COLUMN oauth2_user_id VARCHAR(255)');
}
