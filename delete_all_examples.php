<?php
require('../../config.php');

require_sesskey();

$courseid = required_param('courseid', PARAM_INT);
$lang = required_param('lang', PARAM_ALPHA);
$subject = required_param('subject', PARAM_TEXT);
$topic = required_param('examplesname', PARAM_FILE);

require_login();
$context = context_course::instance($courseid);
require_capability('moodle/course:manageactivities', $context);

$fs = get_file_storage();

$filepath = '/' . $lang . '/' . $subject . '/' . $topic . '/';

$files = $fs->get_directory_files($context->id, 'local_aiquizgenerator', 'examples', 0, $filepath);

foreach ($files as $file) {
    $file->delete();
}

redirect(new moodle_url('/local/aiquizgenerator/examples.php', ['courseid' => $courseid]),
    get_string('examples_deleted_all', 'local_aiquizgenerator'), null, \core\output\notification::NOTIFY_SUCCESS);
