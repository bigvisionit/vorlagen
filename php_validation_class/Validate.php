<?php
/*
	PHP Validation Class
	author: David Kempf
*/
class Validate {
    protected static $_instance=null;
    const MAIL      ='MAIL';
    const URL       ='URL';
    const IP        ='IP';
    const DATE      ='DATE';
    const ZIP       ='ZIP';
    const PHONE     ='PHONE';
    const INTEGER   ='INTEGER';
    const NUMERIC   ='NUMERIC';
    const CURRENCY  ='CURRENCY';
    const BASE64    ='BASE64';
    const ALPHA     ='ALPHA';
    const ALPHANUM  ='ALPHANUM';
    const LOWERCASE ='LOWERCASE';
    const UPPERCASE ='UPPERCASE';
    const MIN       ='MIN';
    const MAX       ='MAX';
    const BETWEEN   ='BETWEEN';
    const NOT_EMPTY ='NOT_EMPTY';
    const MATCH     ='MATCH';
    private $_lastNoValidData=null;
    /**
     * Gets an instance of the Validate.
     * @return Validate
     */
    public static function getInstance() {
        if(null===self::$_instance)
            self::$_instance=new Validate();
        return self::$_instance;
    }
    public function getLastNoValidData() {
        return $this->_lastNoValidData;
    }
    public function isValid() {
        $params=func_get_args();
        $isValid=true;
        $this->_lastNoValidData=array();
        foreach($params as $param) {
            $isValidParam=$this->_checkValid($param);
            $isValid=$isValidParam && $isValid;
        }
        if(empty($this->_lastNoValidData))
            $this->_lastNoValidData=null;
        return $isValid;
    }
    private function _checkValid($param) {
        $isValidParam=true;
        if(!is_array($param['validate']))
            $param['validate']=array($param['validate']);
        $notValid=array();
        foreach($param['validate'] as $validate) {
            $isValidParamValidate=false;
            switch($validate) {
                case Validate::MAIL:
                    $isValidParamValidate=$this->isMail($param['value']);
                    break;
                case Validate::URL:
                    $isValidParamValidate=$this->isUrl($param['value']);
                    break;
                case Validate::IP:
                    $isValidParamValidate=$this->isIP($param['value']);
                    break;
                case Validate::DATE:
                    $isValidParamValidate=$this->isDate($param['value']);
                    break;
                case Validate::ZIP:
                    $isValidParamValidate=$this->isZip($param['value']);
                    break;
                case Validate::PHONE:
                    $isValidParamValidate=$this->isPhone($param['value']);
                    break;
                case Validate::INTEGER:
                    $isValidParamValidate=$this->isInteger($param['value']);
                    break;
                case Validate::NUMERIC:
                    $isValidParamValidate=$this->isNumeric($param['value']);
                    break;
                case Validate::CURRENCY:
                    $isValidParamValidate=$this->isCurrency($param['value']);
                    break;
                case Validate::BASE64:
                    $isValidParamValidate=$this->isBase64($param['value']);
                    break;
                case Validate::ALPHA:
                    $isValidParamValidate=$this->isAlpha($param['value']);
                    break;
                case Validate::ALPHANUM:
                    $isValidParamValidate=$this->isAlphanum($param['value']);
                    break;
                case Validate::LOWERCASE:
                    $isValidParamValidate=$this->isLowercase($param['value']);
                    break;
                case Validate::UPPERCASE:
                    $isValidParamValidate=$this->isUppercase($param['value']);
                    break;
                case Validate::MIN:
                    $isValidParamValidate=$this->min($param['value'],$param['min']);
                    break;
                case Validate::MAX:
                    $isValidParamValidate=$this->max($param['value'],$param['max']);
                    break;
                case Validate::BETWEEN:
                    $isValidParamValidate=$this->between($param['value'],$param['min'],$param['max']);
                    break;
                case Validate::NOT_EMPTY:
                    $isValidParamValidate=$this->isNotEmpty($param['value']);
                    break;
                case Validate::MATCH:
                    $isValidParamValidate = $this->isMatch($param['value'],$param['match']);
                    break;
                default:
                    throw new Exception('Unbekannter Validator!');
                    break;
            }
            if(!$isValidParamValidate)
                $notValid[]=$validate;
            $isValidParam=$isValidParamValidate&&$isValidParam;
        }
        if(!$isValidParam) {
            $param['notValid']=$notValid;
            if(isset($param['name']))
                $this->_lastNoValidData[$param['name']][]=$param;
            else
                $this->_lastNoValidData[]=$param;
        }
        return $isValidParam;
    }
    public function isMail($string) {
        return (false===!filter_var($string,FILTER_VALIDATE_EMAIL));
    }
    public function isUrl($string) {
        return (false===!filter_var($string, FILTER_VALIDATE_URL));
    }
    public function isIP($string) {
        return (false===!filter_var($string, FILTER_VALIDATE_IP));
    }
    function isDate($string,$format='YYYY-MM-DD') {
        switch($format) {
            case 'YYYY/MM/DD':
            case 'YYYY-MM-DD':
                list($y,$m,$d)=preg_split('/[-\.\/ ]/',$string);
                break;
            case 'YYYY/DD/MM':
            case 'YYYY-DD-MM':
                list($y,$d,$m)=preg_split('/[-\.\/ ]/',$string);
                break;
            case 'DD-MM-YYYY':
            case 'DD/MM/YYYY':
                list($d,$m,$y)=preg_split('/[-\.\/ ]/',$string);
                break;
            case 'MM-DD-YYYY':
            case 'MM/DD/YYYY':
                list($m,$d,$y)=preg_split('/[-\.\/ ]/', $string);
                break;
            case 'YYYYMMDD':
                $y=substr($string,0,4);
                $m=substr($string,4,2);
                $d=substr($string,6,2);
                break;
            case 'YYYYDDMM':
                $y=substr($string,0,4);
                $d=substr($string,4,2);
                $m=substr($string,6,2);
                break;
            default:
                throw new Exception('Invalid Date Format');
        }
        return checkdate($m,$d,$y);
    }
    public function isZip($string,$country_code='de') {
        $zip_reg=array(
            "us"=>"^\d{5}([\-]?\d{4})?$",
            "uk"=>"^(GIR|[A-Z]\d[A-Z\d]??|[A-Z]{2}\d[A-Z\d]??)[ ]??(\d[A-Z]{2})$",
            "de"=>"\b((?:0[1-46-9]\d{3})|(?:[1-357-9]\d{4})|(?:[4][0-24-9]\d{3})|(?:[6][013-9]\d{3}))\b",
            "ca"=>"^([ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ])\ {0,1}(\d[ABCEGHJKLMNPRSTVWXYZ]\d)$",
            "fr"=>"^(F-)?((2[A|B])|[0-9]{2})[0-9]{3}$",
            "it"=>"^(V-|I-)?[0-9]{5}$",
            "au"=>"^(0[289][0-9]{2})|([1345689][0-9]{3})|(2[0-8][0-9]{2})|(290[0-9])|(291[0-4])|(7[0-4][0-9]{2})|(7[8-9][0-9]{2})$",
            "nl"=>"^[1-9][0-9]{3}\s?([a-zA-Z]{2})?$",
            "es"=>"^([1-9]{2}|[0-9][1-9]|[1-9][0-9])[0-9]{3}$",
            "dk"=>"^([D-d][K-k])?( |-)?[1-9]{1}[0-9]{3}$",
            "se"=>"^(s-|S-){0,1}[0-9]{3}\s?[0-9]{2}$",
            "be"=>"^[1-9]{1}[0-9]{3}$"
        );
        return ((isset($zip_reg[$country_code])&&preg_match("/".$zip_reg[$country_code]."/i",$string))?true:false);
    }
    public function isPhone($string) {
        return ((preg_match('/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/',$string))?true:false);
    }
    public function isInteger($string) {
        return (false===!filter_var($string,FILTER_VALIDATE_INT));
    }
    public function isNumeric($string) {
        return is_numeric($string);
    }
    public function isCurrency($string, $delimeter = '.') {
        if('.'==$delimeter)$delimeter='\.';
        return((preg_match("/^-?[0-9]+(?:".$delimeter."[0-9]{1,2})?$/",$string))?true:false);
    }
    public function isBase64($string) {
        return ((base64_decode($string,true))?true:false);
    }
    public function isAlpha($string) {
        return ctype_alpha($string);
    }
    public function isAlphanum($string) {
        return ctype_alnum($string);
    }
    public function isLowercase($string) {
        return ($string===strtolower($string));
    }
    public function isUppercase($string){
        return ($string===strtoupper($string));
    }
    public function min($string,$length) {
        return (strlen($string)>=$length);
    }
    public function max($string,$length) {
        return (strlen($string)<=$length);
    }
    public function between($string,$min,$max) {
        return (strlen($string)>=$min&&strlen($string)<=$max);
    }
    public function isNotEmpty($string) {
        return (strlen($string)>0);
    }
    public function isMatch($string1,$string2) {
        return ($string1==$string2);
    }
}