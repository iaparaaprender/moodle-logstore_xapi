<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Save log to local test.
 *
 * @package   logstore_xapi
 * @copyright 2024 David Herney - cirano
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define('AJAX_SCRIPT', true);

require_once(__DIR__ . '/../../../../../config.php');

$pwd = get_config('logstore_xapi', 'password');
if (!$_SERVER || empty($_SERVER['PHP_AUTH_PW']) || $_SERVER['PHP_AUTH_PW'] !== $pwd) {
    header('HTTP/1.0 403 Forbidden');
    die;
}

$getvalues = !empty($_GET) ? json_encode($_GET) : '';
$postvalues = !empty($_POST) ? json_encode($_POST) : '';
$postbody = file_get_contents('php://input');
$servervalues = json_encode($_SERVER);

$data = (object)[
    'timecreated' => time(),
    'byget' => $getvalues,
    'bypost' => $postvalues,
    'bypostbody' => $postbody,
    'byserver' => $servervalues,
];

$DB->insert_record('logstore_xapi_localtest', $data);

echo 1;
