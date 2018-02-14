<?php
namespace WordPress;

/**
 * Manages WordPress sites
 */
class Sites
{
    
    /**
     * Cache of all sites
     *
     * @var \PHP\Cache
     */
    private static $cache;
    
    
    /***************************************************************************
    *                                   MAIN
    ***************************************************************************/
    
    /**
     * Retrieve site(s)
     *
     * @param int $id The site ID to lookup
     * @return Sites\Site|array
     */
    public static function Get( int $id = NULL )
    {
        // Setup
        self::initializeCache();
        
        // Return site(s)
        if ( isset( $id )) {
            return self::getSingle( $id );
        }
        else {
            return self::getAll();
        }
    }
    
    
    /**
     * Retrieve the current site ID
     *
     * @return int
     */
    final public static function GetCurrentSiteID()
    {
        return get_current_blog_id();
    }
    
    
    /***************************************************************************
    *                               SUB-ROUTINES
    ***************************************************************************/
    
    
    /**
     * Retrieve single site
     *
     * @param int $id Site ID to lookup
     * @return Sites\Site
     */
    private static function getSingle( int $id )
    {
        $site  = NULL;
        $sites = self::getAll();
        if ( array_key_exists( $id, $sites )) {
            $site = $sites[ $id ];
        }
        return $site;
    }
    
    
    /**
     * Retrieve all sites
     *
     * @return array
     */
    private static function getAll()
    {
        
        // Variables
        $sites = [];
        
        // Read all sites from cache.
        if ( self::$cache->isComplete() ) {
            $sites = self::$cache->get();
        }
        
        // Lookup sites
        else {
            
            // Retrieve sites from the multisite setup
            if ( is_multisite() ) {
                $wp_sites = get_sites();
                foreach ( $wp_sites as $wp_site ) {
                    $id = $wp_site->blog_id;
                    $sites[ $id ] = Sites\Models::Create( $id );
                }
            }
            
            // Retrieve site from default, non-multisite setup
            else {
                $sites[ 1 ] = Sites\Models::Create( 1 );
            }
            
            // Set cache, marking it complete
            self::$cache->set( $sites );
        }
        
        return $sites;
    }
    
    
    /***************************************************************************
    *                               UTILITIES
    ***************************************************************************/
    
    /**
     * Create cache instance
     */
    protected static function initializeCache()
    {
        if ( !isset( self::$cache )) {
            self::$cache = new \PHP\Cache();
        }
    }
}
