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
 * Version information for local_aiquizgenerator.
 *
 * @package    local_aiquizgenerator
 * @copyright  2026 Renat Furs <fursrenat@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$courseid = required_param('courseid', PARAM_INT);
$filepath = required_param('filepath', PARAM_PATH);
$filename = required_param('filename', PARAM_FILE);

require_login();

$context = context_course::instance($courseid);
require_capability('moodle/course:manageactivities', $context);

$PAGE->set_url(new moodle_url('/local/aiquizgenerator/view_example.php', ['courseid' => $courseid]));
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');

$fs = get_file_storage();

$file = $fs->get_file(
    $context->id,
    'local_aiquizgenerator',
    'examples',
    0,
    $filepath,
    $filename
);

if (!$file) {
    throw new moodle_exception('filenotfound');
}

$content = $file->get_content();

echo $OUTPUT->header();

echo html_writer::tag('h3', $filename);

echo html_writer::tag(
    'pre',
    s(json_encode(json_decode($content), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)),
    ['style' => 'background:#f5f5f5;padding:15px']
);

echo html_writer::link(
    new moodle_url('/local/aiquizgenerator/examples.php', ['courseid' => $courseid]),
    get_string('back')
);

echo $OUTPUT->footer();
