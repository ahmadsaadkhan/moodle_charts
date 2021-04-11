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
 * Book plugin version info
 *
 * @package    local_statsgraph
 * @copyright  2004-2012 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2021010102;
$plugin->requires  = 2020060900;
$plugin->cron      = 0;
$plugin->component = 'local_statsgraph';   // Declare the type and name of this plugin.
$plugin->maturity  = MATURITY_STABLE;   // Declares the maturity level of this plugin version: MATURITY_ALPHA, MATURITY_BETA, MATURITY_RC or MATURITY_STABLE.
$plugin->release   = 'v1.0-r1';   // Human readable version name that should help to identify each release of the plugin
