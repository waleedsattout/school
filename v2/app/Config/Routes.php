<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('\App\Controllers');
$routes->setDefaultController('\App\Controllers\Students');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->useSupportedLocalesOnly(true);

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */



$segments = request()->getUri()->getSegments();

if (count($segments) == 0) {
    $routes->get('/', function () {
        return redirect('/IDK why this works');
    });
} else {
    if (in_array($segments[0], config('App')->supportedLocales)) {
        $routes->get('/{locale}/students', 'Students::index');
        $routes->get('/{locale}/subjects', 'Subjects::index');
        $routes->get('/{locale}/classes', 'Classes::index');
    } else {
        $skipCheckingForLocaleIn = [
            '/get',
            '/BackupDb',
            '/change_class',
            'login/logout',
            'promote_students'
        ];
        $found = true;
        foreach ($skipCheckingForLocaleIn as $word)
            if (str_contains(request()->getUri()->getPath(), $word))
                $found = false;
        if ($found) {
            header(
                "Location: " .
                    base_url(config('App')->supportedLocales[0] . '/' . implode('/', request()->getUri()->getSegments()))
            );
            exit();
        }
    }
}


// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/{locale}/login', 'Login::index');
$routes->post('/{locale}/validate_login', 'Login::validate_login');
$routes->get('/login/logout', 'Login::logout');


$routes->get('/{locale}/hide', 'Migrate::hide');
$routes->get('/{locale}/startup', 'Migrate::quickCheck');
$routes->get('/{locale}/migrate/import', 'Migrate::importData');
$routes->get('/{locale}/migrate_students_data', 'Migrate::migrateStudentsData');
$routes->match(['get', 'post'], '/promote_students', 'Migrate::promoteStudents');
$routes->match(['get', 'post'], '/{locale}/migrate/', 'Migrate::backupDatabases');


$routes->get('/{locale}/students/temp', 'Students::temp');
$routes->get('/{locale}/students/manage_student', 'Students::manageStudent');
$routes->match(['get', 'post'], '/{locale}/students/hideStudent/(:any)', 'Students::hideStudent/$1');
$routes->match(['get', 'post'], '/{locale}/students/hideStudent', 'Students::hideStudent');
$routes->post('students/edit_student', 'Students::editStudent');
$routes->post('students/add_student', 'Students::addStudent');
$routes->match(['get', 'post'], '/{locale}/students/edit_student_marks', 'Students::editStudentMarks');
$routes->match(['get', 'post'], '/{locale}/students/edit_behav', 'Students::editBehav');
$routes->match(['get', 'post'], '/{locale}/students/edit_absent', 'Students::editAbsent');
$routes->get('/{locale}/students/delete_student/(:any)', 'Students::deleteStudent/$1');
$routes->get('/{locale}/students/certificate', 'Students::certificate');
$routes->get('/{locale}/students/certificate/(:any)', 'Students::certificate/$1');
$routes->get('/{locale}/students/cert', 'Students::cert');


$routes->get('/{locale}/subjects/manage_subject', 'Subjects::manageSubject');
$routes->match(['get', 'post'], '/{locale}/subjects/add_sum', 'Subjects::add_sum');
$routes->match(['get', 'post'], '/{locale}/subjects/add_subject', 'Subjects::addEditSubject');
$routes->match(['get', 'post'], '/{locale}/subjects/edit_subject', 'Subjects::addEditSubject');
$routes->get('/{locale}/subjects/sum', 'Subjects::sum');
$routes->get('/{locale}/subjects/delete_subject/(:any)', 'Subjects::delSubject/$1');
$routes->get('/{locale}/subjects/sum/(:any)/(:any)/(:any)', 'Subjects::sum/$1/$2/$3');
$routes->get('/{locale}/subjects/order', 'Subjects::order');


$routes->get('/{locale}/classes/manage_classes', 'Classes::manageClasses');
$routes->get('/{locale}/classes/delete_class/(:any)', 'Classes::deleteClass/$1');
$routes->match(['get', 'post'], '/{locale}/classes/edit_class', 'Classes::editClass');
$routes->match(['get', 'post'], '/{locale}/classes/add_class', 'Classes::addClass');
$routes->get('classes/change_class/(:any)', 'Classes::changeClass/$1');


$routes->get('/{locale}/admin/', 'Admin::index', ['filter' => 'admin']);
$routes->get('/{locale}/admin/change', 'Admin::change', ['filter' => 'admin']);
$routes->get('/{locale}/admin/change/(:any)', 'Admin::change/$1', ['filter' => 'admin']);


$routes->get('/{locale}/modals/add_student', 'Modals::addStudent');
$routes->get('/{locale}/modals/edit_student/(:any)', 'Modals::manageStudent/$1');
$routes->get('/{locale}/modals/manage_student', 'Modals::manageStudent');
$routes->get('/{locale}/modals/manage_student/(:any)', 'Modals::manageStudent/$1');
$routes->match(['get', 'post'], '/{locale}/modals/edit_behav/', 'Modals::editBehav/');
$routes->match(['get', 'post'], '/{locale}/modals/edit_absent/', 'Modals::editAbsent/');
$routes->get('/{locale}/modals/add_sum/(:any)/(:any)/(:any)', 'Modals::addSum/$1/$2/$3');
$routes->get('/{locale}/modals/add_subject', 'Modals::addEditSubject');
$routes->match(['get', 'post'], '/{locale}/modals/edit_subject/(:any)', 'Modals::addEditSubject/$1');
$routes->get('/{locale}/modals/show_classes', 'Modals::showClasses');
$routes->get('/{locale}/modals/edit_class/(:any)', 'Modals::editClass/$1');
$routes->get('/{locale}/modals/add_class', 'Modals::addClass');


$routes->get('BackupDb', 'BackupDb::index');
$routes->get('get/(:any)', 'WLP::$1', ['filter' => 'api']);

$routes->match(['get', 'post'], '/{locale}/settings', 'Settings::index');


$routes->get('{locale}', 'Students::manageStudent');

/*
* --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */


if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
