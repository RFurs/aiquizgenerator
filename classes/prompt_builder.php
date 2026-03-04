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
namespace local_aiquizgenerator;

defined('MOODLE_INTERNAL') || die();

/**
 * Class responsible for building a prompt and augmenting it with question examples
 */
class prompt_builder {
    /**
     * Function building a prompt using data received from form.
     * @param \stdClass $data The form data (subject, topic, questioncount, cognitive_difficulty)
     * @return string The fully constructed prompt
     */
    public function build(\stdClass $data): string {
        $a = new \stdClass();
        $a->subject   = $data->subject;
        $a->topic     = $data->topic;
        $a->count     = $data->questioncount;
        $a->level     = $data->cognitive_difficulty;

        $prompt = get_string('prompt', 'local_aiquizgenerator', $a);

        $jsonexamples = $this->get_examples_json($data);

        if (!empty($jsonexamples)) {
            $prompt .= "\n\n" . get_string('examplesprefix', 'local_aiquizgenerator') . "\n" . $jsonexamples;
        }
        return $prompt;
    }

    /**
     * Locates and reads the appropriate JSON example file based on language, subject, topic, and level.
     * @param \stdClass $data
     * @return string|null JSON content or null if not found.
     */
    protected function get_examples_json(\stdClass $data): ?string {
        global $CFG;
        $currentlang = \current_language();

        $lang = ($currentlang === 'lt') ? 'lt' : 'en';

        $basepath = $CFG->dirroot . '/local/aiquizgenerator/data/examples/' . $lang;

        $subject = $data->subject;
        $examplesname   = $data->jsonexamples;
        $level   = $data->cognitive_difficulty;

        $topicpath = $basepath . '/' . $subject . '/' . $examplesname;

        if (!is_dir($topicpath)) {
            $topicpath = $basepath . '/' . $subject . '/default';
        }

        $levelnum = match (strtolower($data->cognitive_difficulty)) {
            'remember'   => 1,
            'understand' => 2,
            'apply'      => 3,
            'analyze'    => 4,
            'evaluate'   => 5,
            'create'     => 6,
            default      => 1,
        };

        $filename = 'lvl' . $levelnum . '.json';
        $fullpath = $topicpath . '/' . $filename;

        if (file_exists($fullpath)) {
            return file_get_contents($fullpath);
        }

        return null;
    }
}
