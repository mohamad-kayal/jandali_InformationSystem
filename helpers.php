<?php
require_once __DIR__ . '/connection.php';

function h($value)
{
	return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function request_value($source, $key, $default = '')
{
	return isset($source[$key]) ? trim((string) $source[$key]) : $default;
}

function request_int($source, $key, $default = 0)
{
	return filter_var(request_value($source, $key, (string) $default), FILTER_VALIDATE_INT, [
		'options' => ['default' => $default],
	]);
}

/**
 * Prepare and execute a SQL statement with optional bound parameters.
 * Returns the statement handle on success or false on failure.
 */
function db_execute($conn, $sql, $types = '', $params = [])
{
	$stmt = mysqli_prepare($conn, $sql);
	if (!$stmt) {
		error_log('SQL prepare failed: ' . mysqli_error($conn));
		return false;
	}

	if ($types !== '' && !empty($params)) {
		mysqli_stmt_bind_param($stmt, $types, ...$params);
	}

	if (!mysqli_stmt_execute($stmt)) {
		error_log('SQL execute failed: ' . mysqli_stmt_error($stmt));
		return false;
	}

	return $stmt;
}

/**
 * Execute a SQL query and return the first row as an associative array.
 * Returns null when the query fails or no row is found.
 */
function db_fetch_assoc($conn, $sql, $types = '', $params = [])
{
	$stmt = db_execute($conn, $sql, $types, $params);
	if (!$stmt) {
		return null;
	}
	$result = mysqli_stmt_get_result($stmt);
	return $result ? mysqli_fetch_assoc($result) : null;
}
?>
