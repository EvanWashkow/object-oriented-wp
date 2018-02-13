<?php
namespace WordPress;

/*******************************************************************************
* WordPress Site (blog) manager
*******************************************************************************/

class Sites {
    
    //
    // METHODS
    
    // Get site or sites, indexed by id
    public static function Get( $id = NULL ) {
        
        // Get site by ID
        if ( isset( $id ) && is_numeric( $id )) {
            $site = self::getCache( $id );
            if ( !isset( $site )) {
                self::loadComponents();
                $site = new Sites\Site( $id );
                self::addCache( $site );
            }
            return $site;
        }
        
        // Return all sites
        else {
            return self::getAll();
        }
    }
    
    // Get all sites, indexed by id
    private static function getAll() {
        
        // Exit. Return all sites from cache.
        if ( self::isCompleteCache() ) {
            return self::getCache();
        }
        
        // Lookup sites. For each, create and cache new a site instance.
        $wp_sites = get_sites();
        foreach ( $wp_sites as $wp_site ) {
            self::loadComponents();
            $id   = $wp_site->blog_id;
            $site = self::getCache( $id );
            
            // Cache new site object
            if ( !isset( $site )) {
                $site = new Sites\Site( $id );
                self::addCache( $site );
            }
        }
        
        // Return sites. Mark cache complete.
        self::isCompleteCache( true );
        return self::getCache();
    }
    
    
    //
    // CACHE
    
    // Sites cache
    private static $isCompleteCache = false;
    private static $_sites          = [ /* site_id => site_object*/ ];
    
    // Are all sites in the cache?
    private static function isCompleteCache( $bool = NULL ) {
        if ( isset( $bool ) && is_bool( $bool )) {
            self::$isCompleteCache = $bool;
        }
        return self::$isCompleteCache;
    }
    
    // Add site to cache
    private static function addCache( $site ) {
        self::$_sites[ $site->getID() ] = $site;
    }
    
    // Get site or sites from cache
    private static function getCache( $siteID = NULL ) {
        if ( isset( $siteID )) {
            return empty( self::$_sites[ $siteID ] ) ? NULL : self::$_sites[ $siteID ];
        }
        else {
            return self::$_sites;
        }
    }
    
    
    //
    // COMPONENTS
    
    // Load components
    private static function loadComponents() {
        $directory = dirname( __FILE__ ) . '/Sites';
        require_once( "{$directory}/Site.php" );
    }
}
?>
