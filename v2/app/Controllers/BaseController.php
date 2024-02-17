<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


use App\Models\Std;
use App\Models\Sub;
use App\Models\Cls;
use App\Models\Setting;
use Config\Services;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */

    protected $session = "";
    protected $std = "";
    protected $cls = "";
    protected $sub = "";
    protected $forge = "";
    protected $db = "";
    protected $settings = "";
    protected $viewData = [];


    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);


        $this->session = session();
        $this->std = new Std();
        $this->sub = new Sub();
        $this->cls = new Cls();
        $this->settings = new Setting();
        $this->db = db_connect();
        $this->forge = \Config\Database::forge();

        $this->viewData['locale'] = Services::request()->getLocale();
        $this->viewData['supportedLocales'] = $request->config->supportedLocales;
    }

    public function __construct()
    {
        $this->session = session();
        $this->std = new Std();
        $this->sub = new Sub();
        $this->cls = new Cls();
        $this->db = db_connect();
        $this->forge = \Config\Database::forge();
    }
}
