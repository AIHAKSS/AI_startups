<?php 
class Session
{
    private static $cookiekey = "PHPOPUSSESSIONID";
    private static $sessionId = '';
    private static $username = '';
    private static $userid = '';

    public static function setMemcacheValue($key, $value)
    {
    	return SessionDataManager::getInstance()->setValue('', $key, $value);
    }
    public static function getMemcacheValue($key)
    {
    	return SessionDataManager::getInstance()->getValue('', $key);
    }
    public static function deleteMemcacheValue($key)
    {
        return SessionDataManager::getInstance()->delete('', $key);
    }
    
    
    
	public static function setValue($key, $value)
    {
        return SessionDataManager::getInstance()->setValue(self::getSessionId(), $key, $value);
	}	
	public static function getValue($key)
    {
        return SessionDataManager::getInstance()->getValue(self::getSessionId(), $key);
	}
    public static function deleteValue($key)
    {
        return SessionDataManager::getInstance()->delete(self::getSessionId(), $key);
    }



    public static function setSessionId($username,$userid)
    {
        self::$username = $username;
        self::$userid = $userid;
        
        self::$sessionId = self::getSessionId();
        if(empty(self::$sessionId )){
            self::$sessionId  = CGuidManager::GetGuid();
            setcookie(self::$cookiekey,self::$sessionId);
        }
        
        SessionDataManager::getInstance()->setValue(self::$sessionId, '',$username);
        SessionDataManager::getInstance()->setValue(self::$sessionId, 'userid',$userid);

        
    }

    public static function getSessionId()
    {
        return self::$sessionId != '' ? self::$sessionId : CHttpRequestInfo::cookie(self::$cookiekey);
    }

    public static function getUserName() 
    {
        self::$sessionId = self::getSessionId();
        if(empty(self::$sessionId)){
            return "";
        }
        
        if(self::$username == '')
        {
            self::$username = SessionDataManager::getInstance()->getValue(self::getSessionId(), '');
        }
        return self::$username;
    }
    public static function getUserId() 
    {
        self::$sessionId = self::getSessionId();
        if(empty(self::$sessionId)){
            return "";
        }
        
        if(self::$userid == '')
        {
            self::$userid = SessionDataManager::getInstance()->getValue(self::getSessionId(), 'userid');
        }
        return self::$userid;
    }

    public static function deleteSession()
    {
        SessionDataManager::getInstance()->cleanAllValues(self::getSessionId());
    }
}