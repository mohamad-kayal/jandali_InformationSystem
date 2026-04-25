<?php
if (!function_exists('load_local_env')) {
function load_local_env($path)
{
	if (!is_readable($path)) {
		return;
	}

	foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
		$line = trim($line);
		if ($line === '' || strpos($line, '#') === 0 || strpos($line, '=') === false) {
			continue;
		}
		list($key, $value) = explode('=', $line, 2);
		$key = trim($key);
		$value = trim($value, " \t\n\r\0\x0B\"'");
		if ($key !== '' && getenv($key) === false) {
			putenv($key . '=' . $value);
			$_ENV[$key] = $value;
		}
	}
}
}

load_local_env(__DIR__ . '/.env');

$conn = mysqli_connect(
	getenv('DB_HOST') ?: 'localhost',
	getenv('DB_USER') ?: 'root',
	getenv('DB_PASS') ?: 'root',
	getenv('DB_NAME') ?: 'pos',
	(int) (getenv('DB_PORT') ?: 3306)
);

if (!$conn) {
	die('Database connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');
?>
