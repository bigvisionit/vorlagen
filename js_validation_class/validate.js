/*
	JS Validation Class
	author: David Kempf
*/
var Validate = {};

Validate.ISSET      = 'ISSET';
Validate.NOT_EMPTY  = 'NOT_EMPTY';
Validate.MAIL       = 'MAIL';
Validate.URL        = 'URL';
Validate.DATE       = 'DATE';
Validate.ZIP        = 'ZIP';
Validate.PHONE      = 'PHONE';
Validate.INTEGER    = 'INTEGER';
Validate.NUMERIC    = 'NUMERIC';
Validate.CURRENCY   = 'CURRENCY';
Validate.IP         = 'IP';
Validate.BASE64     = 'BASE64';
Validate.ALPHA      = 'ALPHA';
Validate.ALPHANUM   = 'ALPHANUM';
Validate.LOWERCASE  = 'LOWERCASE';
Validate.UPPERCASE  = 'UPPERCASE';
Validate.MIN        = 'MIN';
Validate.MAX        = 'MAX';
Validate.BETWEEN    = 'BETWEEN';
Validate.MATCH      = 'MATCH';

Validate._lastNoValidData = null;

Validate.isValid = function() {
    var params = arguments;
    var isValid = true;
    this._lastNoValidData = [];
    for(var i = 0, x = params.length; i < x; i++) {
        var isValidParam = this._checkValid(params[i]);
        isValid = isValidParam && isValid;
    }
    if(validNumProps(this._lastNoValidData) == 0) {
        this._lastNoValidData = null;
    }
    return isValid;
}

Validate.getLastNoValidData = function() {
    return this._lastNoValidData;
}

Validate._checkValid = function(param) {
    var isValidParam = true;
    if(!(param['validate'] instanceof Array)) {
        param['validate'] = [$param['validate']];
    }
    var notValid = [];
    for(var i = 0, x = param['validate'].length; i < x; i++) {
        var isValidParamValidate = false;
        switch(param['validate'][i]) {
            case Validate.ISSET :
                isValidParamValidate = this.isset(param['value']);
                break;
            case Validate.NOT_EMPTY :
                isValidParamValidate = this.notEmpty(param['value']);
                break;
            case Validate.MAIL :
                isValidParamValidate = this.mail(param['value']);
                break;
            case Validate.URL :
                isValidParamValidate = this.url(param['value']);
                break;
            case Validate.DATE :
                isValidParamValidate = this.date(param['value']);
                break;
            case Validate.ZIP :
                isValidParamValidate = this.zip(param['value']);
                break;
            case Validate.PHONE :
                isValidParamValidate = this.phone(param['value']);
                break;
            case Validate.INTEGER :
                isValidParamValidate = this.integer(param['value']);
                break;
            case Validate.NUMERIC :
                isValidParamValidate = this.numeric(param['value']);
                break;
            case Validate.CURRENCY :
                isValidParamValidate = this.currency(param['value']);
                break;
            case Validate.IP :
                isValidParamValidate = this.ip(param['value']);
                break;
            case Validate.BASE64 :
                isValidParamValidate = this.base64(param['value']);
                break;
            case Validate.ALPHA :
                isValidParamValidate = this.alpha(param['value']);
                break;
            case Validate.ALPHANUM :
                isValidParamValidate = this.alphaNumeric(param['value']);
                break;
            case Validate.LOWERCASE :
                isValidParamValidate = this.lowercase(param['value']);
                break;
            case Validate.UPPERCASE :
                isValidParamValidate = this.uppercase(param['value']);
                break;
            case Validate.MIN :
                isValidParamValidate = this.min(param['value'], param['min']);
                break;
            case Validate.MAX :
                isValidParamValidate = this.min(param['value'], param['max']);
                break;
            case Validate.BETWEEN :
                isValidParamValidate = this.between(param['value'], param['min'], param['max']);
                break;
            case Validate.MATCH :
                isValidParamValidate = this.match(param['value'], param['match']);
                break;
            default:
                console.log('Unbekannter Validator!');
                break;
        }
        if(!isValidParamValidate) {
            notValid.push(param['validate'][i]);
        }
        isValidParam = isValidParamValidate && isValidParam;
    }
    if(!isValidParam) {
        param['notValid'] = notValid;
        if(param['name']) {
            if(!(param['name'] instanceof Array)) {
                this._lastNoValidData[param['name']] = [];
            }
            this._lastNoValidData[param['name']].push(param);
        } else {
            this._lastNoValidData.push(param);
        }
    }
    return isValidParam;
}

Validate.isset = function(string) {
    return !!string;
}
Validate.notEmpty = function(string) {
    return string.replace(/\s+/g, '').length > 0;
}
Validate.mail = function(string) {
    return /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/i.test(string);
}
Validate.url = function(string) {
    return /[-a-zA-Z0-9@:%_\+.~#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~#?&//=]*)?/i.test(string);
}
Validate.date = function(string, preutc) {
    var date = Date.parse(string);
    if(isFinite(date)) {
        return true;
    }
    if(preutc) {
        var now = new Date();
        string = string.replace(/\d{4}/, now.getFullYear());
        date = Date.parse(string);
        return isFinite(date);
    }
    return false;
}
Validate.zip = function(string, plus4) {
    var pattern = plus4 ? /^\d{5}-\d{4}$/ : /^\d{5}$/;
    return pattern.test(string);
}
Validate.phone = function(string) {
    return /^\(?([0-9]{3})\)?[-.\s]?([0-9]{3})[-.\s]?([0-9]{4})$/.test(string);
}
Validate.integer = function(string) {
    return /^\-?\d+$/.test(string);
}
Validate.numeric = function(string) {
    return /^-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(string);
}
Validate.currency = function(string, us) {
    return /^\$-?(?:\d+|\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test(string);
}
Validate.ip = function(string) {
    return /^((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){3}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})$/.test(string);
}
Validate.base64 = function(string) {
    return /[^a-zA-Z0-9\/\+=]/i.test(string);
}
Validate.alpha = function(string) {
    return /^[a-z]$/i.test(string);
}
Validate.alphaNumeric = function(string) {
    return /^[a-z0-9]$/i.test(string);
}
Validate.lowercase = function(string) {
    return string.toLowerCase() == string;
}
Validate.uppercase = function(string) {
    return string.toUpperCase() == string;
}
Validate.min = function(string, length) {
    return string.length >= length;
}
Validate.max = function(string, length) {
    return string.length <= length;
}
Validate.between = function(string, min, max) {
    return string.length >= min && string.length <= max;
}
Validate.match = function(string1, string2) {
    return string1 == string2;
}

function validNumProps(obj) {
    var c = 0;
    for(var key in obj) {
        if(obj.hasOwnProperty(key)) ++c;
    }
    return c;
}