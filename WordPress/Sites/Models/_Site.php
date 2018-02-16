<?php
namespace WordPress\Sites\Models;

use \WordPress\Sites;

/**
 * Defines the basic structure for a Site model
 */
abstract class _Site
{
    
    /***************************************************************************
    *                             GENERAL INFORMATION
    ***************************************************************************/
    
    /**
     * Get the unique identifier for this site (blog)
     *
     * @return int
     */
    abstract public function getID();
    
    
    /**
     * Get the site title
     *
     * @return string
     */
    abstract public function getTitle();
    
    
    /**
     * Set the site title
     *
     * @param string $title The new site title
     * @return bool Whether or not the title change was successful
     */
    abstract public function setTitle( string $title );
    
    
    /**
     * Get the site description
     *
     * @return string
     */
    abstract public function getDescription();
    
    
    /**
     * Set the site description
     *
     * @param string $description The new site description
     * @return bool Whether or not the description change was successful
     */
    abstract public function setDescription( string $description );
    
    
    /***************************************************************************
    *                                    URLS
    ***************************************************************************/
    
    /**
     * Retrieve the primary site URL
     *
     * If you want to retrieve the front-facing home URL, see getHomePageURL()
     *
     * @return string
     */
    abstract public function getURL();
    
    /**
     * Set the primary site URL
     *
     * If you want to set the front-facing home URL, see setHomePageURL()
     *
     * @param string $url The new URL
     * @return bool Whether or not the URL change was successful
     */
    abstract public function setURL( string $url );
    
    
    /**
     * Retrieve the home page URL for this site
     *
     * @return array
     */
    abstract public function getHomePageURL();
    
    
    /**
     * Set the home page URL for this site
     *
     * @param string $url The new URL
     * @return bool Whether or not the URL change was successful
     */
    abstract public function setHomePageURL( string $url );
    
    
    /**
     * Returns "http" or "https" for the primary URL
     *
     * @return string
     */
    abstract public function getProtocol();
    
    
    /***************************************************************************
    *                           PLUGINS AND THEMES
    ***************************************************************************/
    
    /**
     * Retrieve the currently-active theme ID
     *
     * Use \WordPress\Themes for related theme management
     *
     * @return string
     */
    abstract public function getActiveThemeID();
    
    
    /**
     * Retrieve the active plugin IDs for this site (does not include network)
     *
     * Use \WordPress\Plugins for related plugin management
     *
     * @return array
     */
    abstract public function getActivePluginIDs();
    
    
    /***************************************************************************
    *                               ADMINISTRATION
    ***************************************************************************/
    
    /**
     * Retrieve the administator's email address
     *
     * @return string
     */
    abstract public function getAdministratorEmail();
    
    
    /**
     * Change the administator's email address
     *
     * @param string $email The new administrator email address
     * @return bool Whether or not the change was successful
     */
    abstract public function setAdministratorEmail( string $email );
    
    
    /**
     * Get the default user role identifier
     *
     * Use \WordPress\Users\Roles for related user role management
     *
     * @return string
     */
    abstract public function getDefaultUserRoleID();
    
    
    /**
     * Get time zone for this site
     *
     * @return \WordPress\TimeZone
     */
    abstract public function getTimeZone();
    
    
    /**
     * Set time zone for this site
     *
     * @param \WordPress\TimeZone $timeZone
     * @return bool Whether or not the TimeZone change was successful
     */
    abstract public function setTimeZone( \WordPress\TimeZone $timeZone );
    
    
    /***************************************************************************
    *                               UTILITIES
    ***************************************************************************/
    
    /**
     * Retrieve a property for this site
     *
     * @param string $key          The property key
     * @param mixed  $defaultValue The property's default value
     * @return mixed The property value
     */
    final public function get( string $key, $defaultValue = NULL )
    {
        // Variables
        $key   = self::sanitizeKey( $key );
        $value = $defaultValue;
        
        // Retrieve value
        if ( '' != $key ) {
            Sites::SwitchTo( $this->getID() );
            $value = get_option( $key, $defaultValue );
            Sites::SwitchBack();
        }
        return $value;
    }
    
    /**
     * Set a property on this site
     *
     * @param string $key   The property key
     * @param mixed  $value The new value for the property
     * @return bool If the property was successfully set or not
     */
    final public function set( string $key, $value )
    {
        // Variables
        $key = self::sanitizeKey( $key );
        $isSuccessful = false;
        
        // Set value
        if ( '' != $key ) {
            Sites::SwitchTo( $this->getID() );
            update_option( $key, $value );
            $isSuccessful = true;
            Sites::SwitchBack();
        }
        
        return $isSuccessful;
    }
    
    
    /**
     * Sanitize the site property key
     *
     * @param string $key The property key
     * @return string
     */
    final protected static function sanitizeKey( string $key )
    {
        return trim( $key );
    }
}
