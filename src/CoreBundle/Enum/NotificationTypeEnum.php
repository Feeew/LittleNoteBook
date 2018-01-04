<?php

namespace CoreBundle\Enum;

abstract class NotificationTypeEnum
{
    const TYPE_SHARE    = "share";
    
    /** @var array user friendly named type */
    protected static $typeName = [
        self::TYPE_SHARE    => 'Partage'
    ];
    
    /**
     * @param  string $typeShortName
     * @return string
     */
    public static function getTypeName($typeShortName)
    {
        if (!isset(static::$typeName[$typeShortName])) {
            return "Unknown type ($typeShortName)";
        }
        
        return static::$typeName[$typeShortName];
    }
    
    /**
     * @return array<string>
     */
    public static function getAvailableTypes()
    {
        return [
            self::TYPE_SHARE
        ];
    }
}