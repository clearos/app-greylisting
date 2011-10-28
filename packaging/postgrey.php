<?php

///////////////////////////////////////////////////////////////////////////////
// B O O T S T R A P
///////////////////////////////////////////////////////////////////////////////

$bootstrap = getenv('CLEAROS_BOOTSTRAP') ? getenv('CLEAROS_BOOTSTRAP') : '/usr/clearos/framework/shared';
require_once $bootstrap . '/bootstrap.php';

///////////////////////////////////////////////////////////////////////////////
// T R A N S L A T I O N S
///////////////////////////////////////////////////////////////////////////////

clearos_load_language('greylisting');

///////////////////////////////////////////////////////////////////////////////
// C O N F I G L E T
///////////////////////////////////////////////////////////////////////////////

$configlet = array(
	'title' => lang('greylisting_app_name'),
	'package' => 'postgrey',
	'process_name' => 'postgrey',
	'pid_file' => '/var/run/postgrey.pid',
	'reloadable' => FALSE,
	'url' => '/app/greylisting'
);
