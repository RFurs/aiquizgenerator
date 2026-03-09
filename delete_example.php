<?php
require('../../config.php');

require_sesskey();

$courseid = required_param('courseid', PARAM_INT);
$filepath = required_param('filepath', PARAM_PATH);
$filename = required_param('filename', PARAM_FILE);

require_login();

$context = context_course::instance($courseid);
require_capability('moodle/course:manageactivities', $context);

$fs = get_file_storage();

$file = $fs->get_file(
    $context->id,
    'local_aiquizgenerator',
    'examples',
    0,
    $filepath,
    $filename
);

if ($file) {
    $file->delete();
}

redirect(
    new moodle_url('/local/aiquizgenerator/examples.php', ['courseid'=>$courseid]),
    get_string('filedeleted', 'local_aiquizgenerator')
);
