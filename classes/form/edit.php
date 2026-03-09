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
namespace local_aiquizgenerator\form;

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/formslib.php');

/**
 * Generator form class.
 */
class edit extends \moodleform {
    /**
     * Defining form structure
     */
    public function definition() {
        global $CFG, $PAGE;
        $mform = $this->_form;
        $courseid = $this->_customdata['courseid'];
        $context = \context_course::instance($courseid);

        $mform->addElement(
            'header',
            'general',
            get_string('aiquizgenerator', 'local_aiquizgenerator')
        );

        $subjects = [
            'C' => get_string('c', 'local_aiquizgenerator'),
            'C++' => get_string('cpp', 'local_aiquizgenerator'),
            'Java' => get_string('java', 'local_aiquizgenerator'),
            'Data structures and algorithms' =>
                get_string('dsa', 'local_aiquizgenerator'),
            'Computer architecture' =>
                get_string('comparch', 'local_aiquizgenerator'),
        ];

        $mform->addElement(
            'select',
            'subject',
            get_string('quizsubject', 'local_aiquizgenerator'),
            $subjects
        );

        $mform->addElement(
            'text',
            'topic',
            get_string('quiztopic', 'local_aiquizgenerator'),
            ['size' => '50']
        );

        $mform->setType('topic', PARAM_TEXT);

        $mform->addRule(
            'topic',
            get_string('topicisrequired', 'local_aiquizgenerator'),
            'required',
            null,
            'client'
        );

        $mform->addRule(
            'topic',
            get_string('topicisnotvalid', 'local_aiquizgenerator'),
            'regex',
            '/^(?!default$)[\p{L}]+([\s\p{L}]+)?$/u',
            'client'
        );

        $mform->addElement(
            'text',
            'questioncount',
            get_string('numberofquestions', 'local_aiquizgenerator')
        );

        $mform->setType('questioncount', PARAM_INT);

        $mform->setDefault('questioncount', 5);

        $mform->addRule(
            'questioncount',
            get_string('numofquestrestriction', 'local_aiquizgenerator'),
            'regex',
            '/^([1-9]|[1-2][0-9]|30)$/',
            'client'
        );

        $bloomlevels = [

            'remember' =>
                get_string('remember', 'local_aiquizgenerator'),

            'understand' =>
                get_string('understand', 'local_aiquizgenerator'),

            'apply' =>
                get_string('apply', 'local_aiquizgenerator'),

            'analyze' =>
                get_string('analyze', 'local_aiquizgenerator'),

            'evaluate' =>
                get_string('evaluate', 'local_aiquizgenerator'),

            'create' =>
                get_string('create', 'local_aiquizgenerator'),
        ];

        $mform->addElement(
            'select',
            'cognitive_difficulty',
            get_string('cognitivedifficulty', 'local_aiquizgenerator'),
            $bloomlevels
        );

        $alltopics = $this->get_all_example_topics();
        $alltopics_json = json_encode($alltopics);

        $whitelist = ['default' => 'default']; 
        foreach ($alltopics as $subject => $topiclist) {
            foreach ($topiclist as $topic) {
                $whitelist[$topic] = $topic;
            }
        }

        $jsonselect = $mform->createElement(
            'select',
            'jsonexamples',
            '',
            $whitelist
        );

        $PAGE->requires->js_call_amd(
            'local_aiquizgenerator/jsonexamples',
            'init',
            [$alltopics]
        );

        $examplesurl = new \moodle_url('/local/aiquizgenerator/examples.php', ['courseid' => $courseid]);
        $managebutton = $mform->createElement(
            'static', 
            'manageexamples', 
            '', 
            \html_writer::tag('a',
                get_string('manageexamples', 'local_aiquizgenerator'),
                ['href' => $examplesurl->out(), 'class' => 'btn btn-secondary ml-2', 'role' => 'button']
            )
        );

        $mform->addGroup(
            [$jsonselect, $managebutton], 
            'examples_group', 
            get_string('jsonexamples', 'local_aiquizgenerator'), 
            [' '], // Separator between elements
            false
        );

        if ((int)$CFG->branch >= 500) {

            $banks = \core_question\local\bank\question_bank_helper::
                get_activity_instances_with_shareable_questions(
                    incourseids: [$courseid],
                    havingcap: ['moodle/question:add'],
                );

            usort($banks, function($a, $b) {
                return strcasecmp($a->name, $b->name);
            });

            $contexts = [];

            foreach ($banks as $bank) {
                $contexts[] = \context_module::instance($bank->modid);
            }

            $context = !empty($contexts) ? $contexts[0] : \context_course::instance($courseid);

        } else {

            $coursecontext = \context_course::instance($courseid);
            $questioncontexts = new \core_question\local\bank\question_edit_contexts($coursecontext);
            $contexts = $questioncontexts->all();
        }

        $mform->addElement(
            'questioncategory',
            'category',
            get_string('category', 'local_aiquizgenerator'),
            ['contexts' => $contexts]
        );
        
        $defaultcategory = \question_get_default_category($context->id);
        $mform->setDefault('category', $defaultcategory->id);

        $mform->addElement('hidden', 'courseid');
        $mform->setDefault('courseid', $courseid);
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons(
            true,
            get_string('generatequiz', 'local_aiquizgenerator')
        );
    }


    /**
    * Builds a flat array containing default JSON output examples and user-defined JSON examples that are found in course filearea
    * @return array Generated XML content.
    */
    private function get_all_example_topics(): array {
        global $CFG;
        $courseid = $this->_customdata['courseid'];
        $context = \context_course::instance($courseid);

        $result = [];

        $currentlang = current_language();
        $lang = ($currentlang === 'lt') ? 'lt' : 'en';
        $basedefault = $CFG->dirroot . '/local/aiquizgenerator/data/examples/' . $lang;

        if (is_dir($basedefault)) {
            foreach (scandir($basedefault) as $subject) {
                if ($subject === '.' || $subject === '..') {
                    continue;
                }
                $subjectpath = $basedefault . '/' . $subject;
                if (!is_dir($subjectpath)) {
                    continue;
                }
                $defaultpath = $subjectpath . '/default';
                if (is_dir($defaultpath)) {
                    $result[$subject] = ['default'];
                }
            }
        }

        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'local_aiquizgenerator', 'examples', 0, 'filepath', false);

        foreach ($files as $file) {
            $fp = $file->get_filepath();
            $parts = array_values(array_filter(explode('/', $fp)));

            if (count($parts) < 3) {
                continue;
            }

            $filelang = $parts[0];
            $subject  = $parts[1];
            $topic    = $parts[2];

            if ($filelang !== $lang) {
                continue;
            }

            if (!isset($result[$subject])) {
                $result[$subject] = ['default'];
            }
            if (!in_array($topic, $result[$subject], true)) {
                $result[$subject][] = $topic;
            }
        }
        return $result;
    }
}
