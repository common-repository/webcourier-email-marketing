<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebcourierFunctions
 *
 * @author dgledson.rabelo
 */
class WebcourierFunctions {

    public function makeRequest($path, $params) {
        $requester = new WP_Http();
        $headers = array('Accept-Language' => '*');
        $params = http_build_query($params);
        $url = "https://app.webcourier.com.br/api/mailmarketing/$path?$params";
        $result = $requester->request($url, array('headers' => $headers));
        $response = json_decode($result['body']);

        return $response;
    }

    public function getCampanhas($api) {
        return $this->makeRequest('getcampanhas', array('api' => $api));
    }

    public function getCampanhaById($api, $id) {
        return $this->makeRequest('copy', array('api' => $api, 'id' => $id));
    }

    public function checkCampanha($api) {
        return $this->makeRequest('checkcampanha', array('api' => $api));
    }

    public function getGrupos($api) {
        return $this->makeRequest('getgrupos', array('api' => $api));
    }

    public function getSubGrupos($api, $id) {
        return $this->makeRequest('getsubgrupos', array('api' => $api, 'id' => $id));
    }
    
    public function getFiltros($api) {
        return $this->makeRequest('getfiltros', array('api' => $api));
    }
    
    public function getAllFiltroOptions($api, $id){
        return $this->makeRequest('getallfiltrooptions', array('api' => $api, 'id' => $id));
    }
    
    public function createWordpressGroups($api, $groupFull, $groupSubscribers, $groupCustomers){
        return $this->makeRequest('createwordpressgroups', array('api' => $api, 'groupFull' => $groupFull, 'groupSubscribers' => $groupSubscribers, 'groupCustomers' => $groupCustomers));
    }
    
    public function getTemplates($api){
        return $this->makeRequest('gettemplates', array('api' => $api));
    }
    
    public function getCampanhasWordpress($api) {
        return $this->makeRequest('getcampanhaswordpress', array('api' => $api));
    }
    
    public function getClienteIdx($api){
        return $this->makeRequest('getclienteidx', array('api' => $api));
    }
    
    public function getTemplateById($api, $id, $tipo){
        return $this->makeRequest('gettemplatebyid', array('api' => $api, 'id' => $id, 'tipo' => $tipo));
    }
    
}
