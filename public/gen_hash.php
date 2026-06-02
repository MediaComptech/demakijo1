<?php
// Script generate hash dan verifikasi
$password = 'DemakijoAdmin2026!';
$hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
$verify = password_verify($password, $hash);

echo "PASSWORD : " . $password . PHP_EOL;
echo "HASH     : " . $hash . PHP_EOL;
echo "VERIFY   : " . ($verify ? 'OK - COCOK' : 'FAIL - TIDAK COCOK') . PHP_EOL;
echo PHP_EOL;
echo "=== SQL untuk phpMyAdmin ===" . PHP_EOL;
echo "UPDATE \`users\` SET \`password\` = '" . $hash . "', \`updated_at\` = NOW() WHERE \`email\` = 'admin@sdndemakijo1.sch.id';" . PHP_EOL;
echo PHP_EOL;
echo "UPDATE \`users\` SET \`password\` = '" . $hash . "', \`updated_at\` = NOW() WHERE \`email\` = 'operator@sdndemakijo1.sch.id';" . PHP_EOL;
echo PHP_EOL;
echo "UPDATE \`users\` SET \`password\` = '" . $hash . "', \`updated_at\` = NOW() WHERE \`id\` = 3;" . PHP_EOL;
