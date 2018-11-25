<?php

namespace Bulb\Http;


/**
 * Interface IRequest
 * @package Bulb\Http
 */
interface IRequest
{
    /**
     * Current Request Controller (Typically 1st url param)
     * @return string
     */
    public function getController() : string;

    /**
     * Set Current Request Controller
     * @param string $_controller
     * @return IRequest
     */
    public function setController(string $_controller);


    /**
     * Current Request Action (Typically 2nd url param)
     * @return string
     */
    public function getAction() : string;

    /**
     * Set Current Request Action
     * @param string $_action
     * @return IRequest
     */
    public function setAction(string $_action);


    /**
     * Current Request ID (Typically 3rd url param)
     * @return string|int
     */
    public function getId();

    /**
     * Set Current Request ID
     * @param string|int|null $_id
     * @return IRequest
     */
    public function setId($_id = null);


    /**
     * Get Current Request Path as array
     * @return array
     */
    public function getRoute() : array;

    /**
     * Set Current Path from array
     * @param array $_route
     * @return IRequest
     */
    public function setRoute(array $_route);


    /**
     * Get Current Request Path (Typcally /getController()/getAction()/getId())
     * @return string
     */
    public function getPath() : string;

    /**
     * Get Current Request Path (Typcally /controller/action/id)
     * @param string $_path
     * @return IRequest
     */
    public function setPath(string $_path);


    /**
     * Get Current Request URL (Typcally /getController()/getAction()/getId()).
     * @return string
     */
    public function getUrl() : string;


    /**
     * Set Current Request Url
     * @param string|null $_controller
     * @param string|null $_action
     * @param string|null $_id
     * @return IRequest
     */
    public function setUrl(string $_controller = null, string $_action = null, string $_id = null);


    /**
     * @return mixed
     */
    public function go();

    /**
     * @param string|null $_controller
     * @param string|null $_action
     * @param null $_id
     * @return mixed
     */
    public function goTo(string $_controller = null, string $_action = null, $_id = null);
}