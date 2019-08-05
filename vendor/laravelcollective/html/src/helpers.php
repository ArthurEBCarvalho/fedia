<?php
use App\Era;

if (! function_exists('link_to')) {
    /**
     * Generate a HTML link.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $secure
     * @param bool   $escape
     *
     * @return string
     */
    function link_to($url, $title = null, $attributes = [], $secure = null, $escape = true)
    {
        return app('html')->link($url, $title, $attributes, $secure, $escape);
    }
}

if (! function_exists('link_to_asset')) {
    /**
     * Generate a HTML link to an asset.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return string
     */
    function link_to_asset($url, $title = null, $attributes = [], $secure = null)
    {
        return app('html')->linkAsset($url, $title, $attributes, $secure);
    }
}

if (! function_exists('link_to_route')) {
    /**
     * Generate a HTML link to a named route.
     *
     * @param string $name
     * @param string $title
     * @param array  $parameters
     * @param array  $attributes
     *
     * @return string
     */
    function link_to_route($name, $title = null, $parameters = [], $attributes = [])
    {
        return app('html')->linkRoute($name, $title, $parameters, $attributes);
    }
}

if (! function_exists('link_to_action')) {
    /**
     * Generate a HTML link to a controller action.
     *
     * @param string $action
     * @param string $title
     * @param array  $parameters
     * @param array  $attributes
     *
     * @return string
     */
    function link_to_action($action, $title = null, $parameters = [], $attributes = [])
    {
        return app('html')->linkAction($action, $title, $parameters, $attributes);
    }
}

if (! function_exists('data_br')) {
    /**
     * Return data in BR (dd/mm/yyyy) format
     *
     * @param date  $data
     *
     * @return string
     */
    function data_br($data) {
        try {
            $retorno = date_format(date_create_from_format('Y-m-d', $data), 'd/m/Y');
        } catch (Exception $e) {
            $retorno = date_format(date_create_from_format('Y-m-d H:i:s', $data), 'd/m/Y');
        }
        return $retorno;
    }
}

if (! function_exists('data_us')) {
    /**
     * Return data in US (yyyy-mm-dd) format
     *
     * @param date $data
     *
     * @return string
     */
    function data_us($data) {
        return date_format(date_create_from_format('d/m/Y', $data), 'Y-m-d');;
    }
}

if (! function_exists('blank')) {
    /**
     * Return if param is nill or empty
     *
     * @param date $param
     *
     * @return boolean
     */
    function blank($param) {
        if(isset($param) && !empty($param) && !is_null($param))
            return false;
        else
            return true;
    }
}

if (! function_exists('get_path')) {
    /**
     * Return path, depending of the environment
     *
     * @param date $param
     *
     * @return string
     */
    function get_path() {
        if(env('APP_ENV') == "local")
            return "";
        else
            return "/public";
    }
}

if (! function_exists('get_tipo')) {
    /**
     * Return path, depending of the environment
     *
     * @param integer $tipo
     *
     * @return string
     */
    function get_tipo($tipo) {
        return ['Amistosos','Classificatória da Copa FEDIA','SuperCopa FEDIA','Final da Liga FEDIA'][$tipo];
    }
}

if (! function_exists('get_eras')) {
    /**
     * Return path, depending of the environment
     *
     * @param integer $tipo
     *
     * @return string
     */
    function get_eras() {
        return Era::lists('nome','id')->all();
    }
}
