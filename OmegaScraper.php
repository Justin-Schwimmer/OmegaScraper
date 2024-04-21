<?php
namespace src\lib\cls;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverElement;

use configs\OmegaEngineConfigs;

class OmegaScraper 
{
    private $driver;

    /**
     *  
     */
    public function __construct()
    {
        ## set to true if selenium srv isn't on localhost

        ## is selenium server up and running?
        
        ## start selenimum server run cmd
        
        ## Set task params

    } 

    /**
     * check if selenium server is up
     */
    /* private function checkSeleniumSrvUp()
    {
        pingSeleniumServer
    } */


    /**
     *  GENERIC PHRASE SCRAPE 
     */

     public function scrapeResultsFor( string|array $phrases )
     { 
         $search_queries      = $phrases;
         $search_engine_type  = 'main';
         $max_pgs_to_scrape   = 3;
         $SCRAPE_PLACES_FLAG  = true;
         /* 
         $search_queries      = $omegaTask->getPhrases();
         $search_engine_type  = $omegaTask->getTypeOfSearchEngines();
         $max_pgs_to_scrape   = $omegaTask->getScrapeDepth();
         $SCRAPE_PLACES_FLAG  = $omegaTask->getScrapePlacesFlag();
          */
         ## FOREACH DEVICE/BROWSERS
         foreach( OMEGA_ENGINE_BROWSERS as $browser )
         {
             $capabilities   = DesiredCapabilities::{$browser}();
 
             try {
 
                 $this->driver    = RemoteWebDriver::create( 
                                                        OMEGA_SCRAPER_HOST, 
                                                         $capabilities, 
                                                         5000 );
 
                 ## 
                 
 
 
                 
                 ## FOREACH SEARCH ENGINE
                 foreach( OMEGA_SEARCH_ENGINES[ $search_engine_type ] 
                                         as $se => $seMetaData )
                 {
                     ## GET THE URL SET UP, ADD SPACE FOR PARAM
                     $url = $seMetaData['serps']['url'];
 
                     ## FOREACH QUERY
                     foreach ( $search_queries as $phrase )
                     {
                         $url .= urlencode($phrase);
 
                         ##$driver->get( 'http://docs.seleniumhq.org/' );
                         $this->driver->get( $url );
 
                         ## if places flag is set, go to fetch place data firsts
                         ## click 'more places', fetch up to page depth setting
                         if( $SCRAPE_PLACES_FLAG === true ) {
                             $x = 0;
                             do {
 
                                 ## find more places link
                                 ##$this->driver->findElement(  );
                                 
                                 ## pull down next pages up to limit
                                 ## navigate to next pg once one page is done
                                 
                                 $x++;
                                 
                             } while( $x < $this->max_pgs_to_scrape );
                         }
 
 
                         file_put_contents( "bin/$browser-$se-$phrase.txt", $this->driver->getPageSource() );
 
                         
                     }
 
                 }
 
             } 
             catch (\Throwable $th) 
             {
                 ##$this->closeWebDriver();
                 echo 'throwable q ';
                 $this->driver->close();
                 $this->driver->quit();
                 
                 throw $th;
             }
             
             echo 'q-3 ';
             $this->driver->close();
             $this->driver->quit();
             ##$this->closeWebDriver();
 
             echo __FUNCTION__ . '<pre>'; 
             var_dump($this->driver); 
             echo '</pre>'; 
             exit;
             
         }
 
     }


    /**
     *  scraper task
     */

    public function runSearchScraper( object $omegaTask )
    {
        $search_queries      = $omegaTask->getPhrases();
        $search_engine_type  = $omegaTask->getTypeOfSearchEngines();
        $max_pgs_to_scrape   = $omegaTask->getScrapeDepth();
        $SCRAPE_PLACES_FLAG  = $omegaTask->getScrapePlacesFlag();
        
        ## FOREACH DEVICE/BROWSERS
        foreach( OMEGA_ENGINE_BROWSERS as $browser )
        {
            $capabilities   = DesiredCapabilities::{$browser}();

            try {

                $this->driver    = RemoteWebDriver::create( OMEGA_SCRAPER_HOST, 
                                                            $capabilities, 
                                                            5000 );

                ## 
                


                
                ## FOREACH SEARCH ENGINE
                foreach( OMEGA_SEARCH_ENGINES[ $search_engine_type ] 
                                        as $se => $seMetaData )
                {
                    ## GET THE URL SET UP, ADD SPACE FOR PARAM
                    $url = $seMetaData['serps']['url'];

                    ## FOREACH QUERY
                    foreach ( $search_queries as $phrase )
                    {
                        $url .= urlencode($phrase);

                        ##$driver->get( 'http://docs.seleniumhq.org/' );
                        $this->driver->get( $url );

                        ## if places flag is set, go to fetch place data firsts
                        ## click 'more places', fetch up to page depth setting
                        if( $SCRAPE_PLACES_FLAG === true ) {
                            $x = 0;
                            do {

                                ## find more places link
                                ##$this->driver->findElement(  );
                                
                                ## pull down next pages up to limit
                                ## navigate to next pg once one page is done
                                
                                $x++;
                                
                            } while( $x < $this->max_pgs_to_scrape );
                        }


                        file_put_contents( "bin/$browser-$se-$phrase.txt", $this->driver->getPageSource() );

                        
                    }

                }

            } 
            catch (\Throwable $th) 
            {
                ##$this->closeWebDriver();
                echo 'throwable q ';
                $this->driver->close();
                $this->driver->quit();
                
                throw $th;
            }
            
            echo 'q-3 ';
            $this->driver->close();
            $this->driver->quit();
            ##$this->closeWebDriver();

            echo __FUNCTION__ . '<pre>'; 
            var_dump($this->driver); 
            echo '</pre>'; 
            exit;
            
        }

    }

    /**
     * use if we neeed later to replace multiple quit calls
     */
    private function closeWebDriver()
    {
        if( !is_null( $this->driver ) ) {

            $this->driver->close();
            $this->driver->quit();

        }

        return;
    }

    /**
     *  
     */
    public function __destruct()
    {
        $this->closeWebDriver();
    }
    
}