<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

/* --- Debugging mode is on ---- */
ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
ini_set('log_errors', 'on');
ini_set('error_reporting', E_ALL);
$CFG->cursitesettings = ''; // Site Settings
$CFG->debug = 32767; // DEBUG_DEVELOPER // NOT FOR PRODUCTION SERVERS!

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'scw';
$CFG->dbuser    = 'scwuser';
$CFG->dbpass    = 'Scwdbuser123#';
$CFG->prefix    = 'scwxm_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '',
  'dbsocket' => '',
);

$CFG->wwwroot   = 'http://scw.4blabs.com';
$CFG->dataroot  = '/var/www/mdata/scw';
$CFG->admin     = 'admin';

$CFG->pwresettime = 172800; //48 hours password reset expiry time in seconds

$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
