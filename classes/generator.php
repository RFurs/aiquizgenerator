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

use core_ai\manager;
use core_ai\aiactions\generate_text;

/**
 * Class responsible for building a prompt and sending a request to AI subsystem
 */
class generator {
    /**
     * Generates a quiz using AI subsystem
     *
     * @param \stdClass $data Formos duomenys.
     * @param int $contextid Kurso konteksto ID.
     * @return string Sugeneruotas tekstas.
     * @throws \moodle_exception
     */
    public function generate_quiz(\stdClass $data, int $contextid): string {
        global $USER;

        $promptbuilder = new prompt_builder();
        $prompt = $promptbuilder->build($data);

        $action = new \core_ai\aiactions\generate_text(
            contextid: $contextid,
            userid: $USER->id,
            prompttext: $prompt,
        );

        $manager = \core\di::get(manager::class);
        $response = $manager->process_action($action);

        if (!$response->get_success()) {
            throw new \moodle_exception('aigenerationerror', 'local_aiquizgenerator', '', $response->get_errormessage());
        }

        return $this->cleanup_response($response->get_response_data()['generatedcontent'] ?? '');
    }

    /**
     * Cleans up AI response to extract pure JSON content.
     *
     * @param string $content Raw AI response.
     * @return string Clean JSON string.
     */
    private function cleanup_response(string $content): string {
        if (preg_match('/```(?:json)?\s*(.*?)\s*```/is', $content, $matches)) {
            $content = $matches[1];
        }

        $start = strpos($content, '{');
        $end = strrpos($content, '}');

        if ($start !== false && $end !== false) {
            $content = substr($content, $start, $end - $start + 1);
        }
        return trim($content);
    }
}
