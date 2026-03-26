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

/**
 * Class responsible for building a prompt and augmenting it with question examples
 */
class prompt_builder {
    /**
     * Function building a prompt using data received from form.
     * @param \stdClass $data The form data (subject, topic, questioncount, cognitive_difficulty)
     * @return array The fully constructed prompt and flag used for determining whether default examples were used
     */
    public function build(\stdClass $data): array {
        $a = new \stdClass();
        $a->subject   = $data->subject;
        $a->topic     = $data->topic;
        $a->count     = $data->questioncount;
        $a->level     = $data->cognitive_difficulty;

        $prompt = get_string('prompt', 'local_aiquizgenerator', $a);

        $examplesdata = $this->get_examples_json($data);

        if (!empty($examplesdata)) {
            $prompt .= "\n\n" . get_string('examplesprefix', 'local_aiquizgenerator') . "\n" . $examplesdata['content'];
        }
        return [
            'prompt' => $prompt,
            'examplesnotfound' => $examplesdata['examplesnotfound'],
        ];
    }

    /**
     * Locates and reads the appropriate JSON example file based on language, subject, topic, and level.
     * @param \stdClass $data
     * @return array JSON content and flag used for determining whether default examples were used.
     */
    protected function get_examples_json(\stdClass $data): array {
        global $CFG;

        $currentlang = \current_language();
        $lang = (substr($currentlang, 0, 2) === 'lt') ? 'lt' : 'en';
        $fs = get_file_storage();

        $subject = $data->subject;
        $examplesname = $data->jsonexamples;
        $level = strtolower($data->cognitive_difficulty);

        $levelmap = [
            'remember'   => 'lvl1.json',
            'understand' => 'lvl2.json',
            'apply'      => 'lvl3.json',
            'analyze'    => 'lvl4.json',
            'evaluate'   => 'lvl5.json',
            'create'     => 'lvl6.json',
        ];

        $filename = $levelmap[$level] ?? 'lvl1.json';

        $coursecontext = \context_course::instance($data->courseid ?? SITEID);
        $filepath = "/{$lang}/{$subject}/{$examplesname}/";
        $file = $fs->get_file($coursecontext->id, 'local_aiquizgenerator', 'examples', 0, $filepath, $filename);

        if ($file) {
            return [
                'content' => $file->get_content(),
                'examplesnotfound' => false,
            ];
        }

        $defaultpath = $CFG->dirroot . "/local/aiquizgenerator/data/examples/{$lang}/{$subject}/default/{$filename}";

        if ($examplesname === 'default' && file_exists($defaultpath)) {
            return [
                'content' => file_get_contents($defaultpath),
                'examplesnotfound' => false,
            ];
        } else if (file_exists($defaultpath)) {
            return [
                'content' => file_get_contents($defaultpath),
                'examplesnotfound' => true,
            ];
        }

        return [
            'content' => null,
            'examplesnotfound' => false,
        ];
    }
}
