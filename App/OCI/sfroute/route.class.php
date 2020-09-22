<?php

class route {

    var $_CHECKHEADER = 'shsxsy'; //客户卡号,校验码
    var $_CHECKBODY = '1SfmfJUPCW9676AZpY4MadtO65hA3uZB'; //checkbody
    //var $_CHECKBODY = 'j8DzkIFgmlomPt0aLuwU';
    var $_URL = 'https://bsp-oisp.sf-express.com/bsp-oisp/sfexpressService';

    var $_XML = "";
    var $_RES = "";


    function RouteService($mailno){
        $xml = '<?xml version="1.0" encoding="utf-8" ?>';
        $xml .= '<Request service="RouteService" lang="zh-CN">';
        $xml .= '<Head>' . $this->_CHECKHEADER . '</Head>';
        $xml .= '<Body>';
        $xml .= '<RouteRequest tracking_type="1" method_type="1" tracking_number="'.$mailno.'"/> ';
        $xml .= '</Body>';
        $xml .= '</Request>';
        $this->XML($xml);
        return $this;
    }

    function XML($xmltext) {
        $this->_XML = $xmltext;
        return $this;
    }

    function Send() {
        if ($this->_XML == "") {
            return $this;
        } else {
            $newbody = $this->_XML . $this->_CHECKBODY;
            $md5 = md5($newbody, true);
            $verifyCode = base64_encode($md5);

            $PostData = array(
                "xml" => $this->_XML,
                "verifyCode" => $verifyCode
            );
            $this->_RES = $this->HTTP_POST($this->_URL, $PostData);
            return $this;
        }
    }

    private function HTTP_POST($url, $param) {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, false);
        }

        $strPOST = http_build_query($param);

        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POST, true);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, $strPOST);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, true);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        return $sContent;
    }

    function View() {
        return $this->_RES;
    }

    function webView() {

        $res = str_replace("<", "&lt", $this->_RES);
        $res = str_replace(">", "&gt", $res);
        $res = str_replace("'", "&quot;", $res);
        return $res;
    }

}

?>
