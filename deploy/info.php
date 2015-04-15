<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'greylisting';
$app['version'] = '2.0.22';
$app['release'] = '1';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('greylisting_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('greylisting_app_name');
$app['category'] = lang('base_category_server');
$app['subcategory'] = lang('base_subcategory_messaging');

/////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['greylisting']['title'] = $app['name'];
$app['controllers']['settings']['title'] = lang('base_settings');
$app['controllers']['server']['title'] = lang('base_app_name');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['requires'] = array(
    'app-smtp',
);

$app['core_requires'] = array(
    'app-smtp-core',
    'postgrey >= 1.33-2',
);

$app['core_file_manifest'] = array(
    'postgrey.php'=> array('target' => '/var/clearos/base/daemon/postgrey.php'),
);

$app['core_directory_manifest'] = array(
    '/var/clearos/greylisting' => array(),
    '/var/clearos/greylisting/backup' => array(),
);

$app['delete_dependency'] = array(
    'app-greylisting-core',
    'postgrey'
);
