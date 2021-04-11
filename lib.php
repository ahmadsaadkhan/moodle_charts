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
 * Native mssql class representing moodle database interface.
 *
 * @package    core_dml
 * @copyright  2009 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 *
 * @package    local
 * @subpackage local_statsgraph
 * @copyright  20
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class Stats
{
    function courses_assignment_quiz_stats()
    {
        foreach ($this->_get_courses() as $course) {
            $courses_list[] = $course->fullname;
            $assigns = $this->_get_assigns($course->id);
            $quizes  = $this->_get_quizes($course->id);
            $assigns_list[] = count($assigns);
            $quizes_list[] = count($quizes);
        }
        $courses_stats = new stdClass();
        $courses_stats->courses_list = $courses_list;
        $courses_stats->assigns_list = $assigns_list;
        $courses_stats->quizes_list = $quizes_list;
        return $courses_stats;
    }


    function _get_courses()
    {
        global $DB, $CFG;
        return $DB->get_records('course', array('visible' => '1'));
    }

    function _get_assigns($course_id)
    {
        global $DB, $CFG;
        $sql = "SELECT cm.id AS coursemodule, m.*, cw.section, cm.visible AS visible,
        cm.groupmode, cm.groupingid
        FROM " . $CFG->prefix . "course_modules cm, " . $CFG->prefix . "course_sections cw, " . $CFG->prefix . "modules md,
        " . $CFG->prefix . "assign m
        WHERE cm.course = $course_id AND
        cm.instance = m.id AND
        cm.section = cw.id AND
        md.name = 'assign' AND
        md.id = cm.module order by m.allowsubmissionsfromdate desc";
        return $DB->get_records_sql($sql);
    }

    function _get_quizes($course_id)
    {
        global $DB, $CFG;
        $sql = "SELECT cm.id AS coursemodule, m.*, cw.section, cm.visible AS visible,
        cm.groupmode, cm.groupingid
    FROM " . $CFG->prefix . "course_modules cm, " . $CFG->prefix . "course_sections cw, " . $CFG->prefix . "modules md,
        " . $CFG->prefix . "quiz m
    WHERE cm.course = $course_id AND
        cm.instance = m.id AND
        cm.section = cw.id AND
        md.name = 'quiz' AND
        md.id = cm.module order by m.timeopen desc";
        return $DB->get_records_sql($sql);
    }

    function _enrolled_users($course_id)
    {
        global $DB, $CFG;
        $sql = "SELECT u.id AS user_id, c.id AS courseid, c.fullname, u.username, u.firstname, u.lastname, u.email
        FROM " . $CFG->prefix . "role_assignments ra, " . $CFG->prefix . "user u, " . $CFG->prefix . "course c, " . $CFG->prefix . "context cxt WHERE ra.userid = u.id AND ra.contextid = cxt.id AND cxt.contextlevel = '50' AND cxt.instanceid = c.id AND c.id = '" . $course_id . "' ";
        return $DB->get_records_sql($sql);
    }

    function courses_enrolled_users()
    {
        foreach ($this->_get_courses() as $course) {
            $courses_list[] = $course->fullname;
            $enrolled_users[] = count($this->_enrolled_users($course->id));
        }
        $enrolled_users_stats = new stdClass();
        $enrolled_users_stats->courses_list = $courses_list;
        $enrolled_users_stats->enrolled_users = $enrolled_users;
        return $enrolled_users_stats;
    }
}
