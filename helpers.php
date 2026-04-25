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

function ensure_session_started()
{
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
}

function csrf_token()
{
	ensure_session_started();
	if (empty($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
	return $_SESSION['csrf_token'];
}

function csrf_input()
{
	return '<input type="hidden" name="csrf_token" value="' . h(csrf_token()) . '">';
}

function verify_csrf($source = null)
{
	ensure_session_started();
	$source = $source === null ? $_POST : $source;
	return isset($source['csrf_token'], $_SESSION['csrf_token'])
		&& hash_equals($_SESSION['csrf_token'], (string) $source['csrf_token']);
}

function require_post_with_csrf()
{
	if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST)) {
		http_response_code(403);
		echo 'Invalid request';
		exit;
	}
}

function require_authenticated_user()
{
	ensure_session_started();
	if (empty($_SESSION['user_id'])) {
		http_response_code(401);
		echo 'Authentication required';
		exit;
	}
	return (int) $_SESSION['user_id'];
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
