<?php
// 
// This file is part of the local_statsgraph module for Moodle - http://moodle.org/
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
 * Instance add/edit form
 *
 * @package    local_statsgraph
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../config.php');
include_once('lib.php');
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/local/local_statsgraph/index.php');
$PAGE->navbar->add(get_string('statsgraph', 'local_statsgraph'));
$PAGE->set_title(get_string('statsgraph', 'local_statsgraph'));
$PAGE->set_heading(get_string('statsgraph', 'local_statsgraph'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('statsgraph', 'local_statsgraph'));

$stats = new Stats();
$courses_stats = $stats->courses_assignment_quiz_stats();
$enrolled_users_stats = $stats->courses_enrolled_users();

// CHART 1
$assigns = new core\chart_series(get_string('assignments', 'local_statsgraph'), $courses_stats->assigns_list);
$quizes = new core\chart_series(get_string('quizes', 'local_statsgraph'), $courses_stats->quizes_list);
$chart = new core\chart_bar();
$chart->set_labels($courses_stats->courses_list);
$chart->set_title(get_string('coursesassignmentschart', 'local_statsgraph'));
$chart->add_series($assigns);
$chart->add_series($quizes);
echo $OUTPUT->render($chart);

// CHART 2
$assigns = new core\chart_series(get_string('assignments', 'local_statsgraph'), $courses_stats->assigns_list);
$quizes = new core\chart_series(get_string('quizes', 'local_statsgraph'), $courses_stats->quizes_list);
$chart = new core\chart_bar();
$chart->set_labels($courses_stats->courses_list);
$chart->set_title(get_string('coursesassignmentschartstacked', 'local_statsgraph'));
$chart->set_stacked(true);
$chart->add_series($assigns);
$chart->add_series($quizes);
echo $OUTPUT->render($chart);

// CHART 3
$chart = new \core\chart_pie();
$chart->set_doughnut(true);
$enrolled_users = new core\chart_series(get_string('enrolledusers', 'local_statsgraph'), $enrolled_users_stats->enrolled_users);
$chart->set_title(get_string('enrolleduserschart', 'local_statsgraph'));
$chart->add_series($enrolled_users);
$chart->set_labels($enrolled_users_stats->courses_list);
echo $OUTPUT->render($chart);

echo $OUTPUT->footer();
