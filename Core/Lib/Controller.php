<?php
namespace Core\Lib;

use App\Helpers\Utils;

use Core\Application;
use Core\Config;

use Illuminate\Http\Response;
use Illuminate\Http\Request as Request;

use Philo\Blade\Blade;

class Controller extends Application
{

    protected 	$blade;

	public 		$framework , $request , $response , $params;

	/**
	 * Controller constructor.
	 */
	public function __construct() {
        parent::__construct();

        $this->blade 	= new Blade(
			Config::get('app.path_views'),
			Config::get('app.path_views_cache')
		);

        $this->framework= (object) Config::get('framework');
        $this->request 	= (new Request);
        $this->response	= (new Response);
    }

	/**
	 * @return int
	 */
	public function _404() {
		return print($this->blade
			->view()
			->make("error.404")
			->with('Utils',Utils::getInstance())
            ->with('framework',$this->framework));
	}

    /**
     * @param      $view
     * @param null $params
     *
     * @return int
     */
    public function view($view, $params = null) {
        echo $this->blade->view()->make($view)
            ->with($params)
            ->with('useUtils',Utils::getInstance())
            ->with('framework',$this->framework)->render();
    }


	/**
	 * Determine if the uploaded data contains a file.
	 *
	 * @param  string $key
	 * @param null    $default
	 *
	 * @return bool
	 */
	public function getFile($key = null, $default = null) {
		return $this->request->capture()->file($key, $default);
	}

	/**
	 * Determine if the uploaded data contains a file.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function hasFile($key) {
		if($this->request->capture()->hasFile($key)){
			return $this->request->capture()->file($key);
		}else{
			return $this->request->capture()->hasFile($key);
		}
	}

	/**
	 * Checks if the request method is of specified type.
	 *
	 * @param string $method Uppercase request method (GET, POST etc).
	 *
	 * @return bool
	 */
	public function isMethod($method){
		return $this->request->capture()->isMethod($method);
	}

	/**
	 * Get the request method.
	 *
	 * @return string
	 */
	public function method(){
		return $this->request->capture()->method();
	}


	/**
	 * Retrieve an input item from the request.
	 *
	 * @param  string  $key
	 * @param  string|array|null  $default
	 * @return string|array
	 */
	public function input($key = null, $default = null) {
		return $this->request->capture()->input($key , $default);
	}

	/**
	 * Determine if the request contains a given input item key.
	 *
	 * @param $string
	 *
	 * @return bool
	 * @internal param array|string $key
	 */
	public function exists($string) {
		return $this->request->capture()->has($string);
	}

	/**
	 * Get all of the input and files for the request.
	 *
	 * @return array
	 */
	public function all() {
		return $this->request->all();
	}

	/**
	 * Get the JSON payload for the request.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function json($key = null, $default = null){
		return $this->request->json($key, $default);
	}

	/**
	 * Determine if the request is the result of an AJAX call.
	 *
	 * @return bool
	 */
	public function ajax(){
		return $this->request->json();
	}


}