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

        $mform->addElement(
            'select',
            'jsonexamples',
            get_string('jsonexamples', 'local_aiquizgenerator'),
            $whitelist
        );

        $PAGE->requires->js_call_amd(
            'local_aiquizgenerator/jsonexamples',
            'init',
            [$alltopics]
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
    * Builds an array containing topics that are present at aiquizgenerator/data/examples/...
    * @return array Generated XML content.
    */
    private function get_all_example_topics(): array {
        global $CFG;

        $currentlang = current_language();
        $lang = ($currentlang === 'lt') ? 'lt' : 'en';
        $basepath = $CFG->dirroot . '/local/aiquizgenerator/data/examples/' . $lang;

        $result = [];

        if (!is_dir($basepath)) {
            return $result;
        }

        foreach (scandir($basepath) as $subject) {
            if ($subject === '.' || $subject === '..') {
                continue;
            }

            $subjectpath = $basepath . '/' . $subject;

            if (!is_dir($subjectpath)) {
                continue;
            }

            $topics = ['default'];

            foreach (scandir($subjectpath) as $topic) {
                if ($topic !== '.' && $topic !== '..' &&
                    is_dir($subjectpath . '/' . $topic)) {
                    $topics[] = $topic;
                }
            }

            $result[$subject] = array_values(array_unique($topics));

        }
        return $result;
    }
}
