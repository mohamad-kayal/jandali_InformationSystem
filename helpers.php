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

function db_execute($conn, $sql, $types = '', $params = [])
{
	$stmt = mysqli_prepare($conn, $sql);
	if (!$stmt) {
		error_log('SQL prepare failed: ' . mysqli_error($conn));
		return false;
	}

	if ($types !== '' && !empty($params)) {
		$refs = [];
		foreach ($params as $key => $value) {
			$refs[$key] = &$params[$key];
		}
		array_unshift($refs, $types);
		call_user_func_array([$stmt, 'bind_param'], $refs);
	}

	if (!mysqli_stmt_execute($stmt)) {
		error_log('SQL execute failed: ' . mysqli_stmt_error($stmt));
		return false;
	}

	return $stmt;
}

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
