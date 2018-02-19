<?php
namespace WordPress\Plugins\Models;

/**
 * Defines the structure for a single plugin
 */
abstract class _Plugin
{
    
    /***************************************************************************
    *                              PUBLIC UTILITIES
    ***************************************************************************/

    /**
     * Retrieve a plugin's ID for its file path (relative to the plugins directory)
     *
     * @param string $relativePath Path to plugin file, relative to the plugins directory
     * @return string
     */
    final public static function ExtractID( string $relativePath )
    {
        return explode( '/', $relativePath )[ 0 ];
    }
    
    
    /***************************************************************************
    *                                  PROPERTIES
    ***************************************************************************/
    
    /**
     * Retrieve this plugin's ID
     *
     * @return string
     */
    abstract public function getID();
    
    /**
     * Retrieves this plugin's author name
     *
     * @return string
     */
    abstract public function getAuthorName();
    
    /**
     * Retrieves this plugin author's website
     *
     * @return string
     */
    abstract public function getAuthorURL();
    
    /**
     * Retrieves the description of this plugin's purpose
     *
     * @return string
     */
    abstract public function getDescription();
    
    /**
     * Retrieves the user-friendly name for this plugin's
     *
     * @return string
     */
    abstract public function getName();
    
    /**
    * Retrieves the path to this plugin's file, relative to the plugins directory
    *
    * @return string
    */
    abstract public function getRelativePath();
    
    /**
     * Retrieves this plugin's version number
     *
     * @return string
     */
    abstract public function getVersion();
}
