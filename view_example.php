<?php
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
    new moodle_url('/local/aiquizgenerator/examples.php', ['courseid'=>$courseid]),
    get_string('back')
);

echo $OUTPUT->footer();
