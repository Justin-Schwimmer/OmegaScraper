<?php
namespace src;

require_once(__DIR__ . '/../vendor/autoload.php');

use src\lib\cls\OmegaScraper;
use src\lib\cls\OmegaTask;
use src\lib\cls\tasks\BizAnalTask;

set_time_limit( 0 );
error_reporting( E_ALL );

########################
##
## GRAB CMD PARAM: TASK METADATA
##
########################
if( !empty( $argv ) ) {

    ##
    ## INPUT STAGE: TEST DATA
    ##
    ## strip_clubs_task_metadata.json

    ## f: campaign meta file 
    ## t: task to run, default gets default
    $campaign_metadata_file = getopt("f:");

    ## fetch campaign meta data
    $campaign_metadata = file_get_contents( __DIR__ . 
                            "/../campaigns/{$campaign_metadata_file['f']}" );





    ## set omegatask data
    $omega_task = new OmegaTask( json_decode( $campaign_metadata, true ) );

    ## create omega scraper object
    $omega_scraper = new OmegaScraper();
    
    ## Loop through tasks
    foreach ( $omega_task->getTasks() as $key => $task ) 
    {

        ##$taskObj = new $tasks( $campaign_metadata );

        echo __FUNCTION__ . '<pre>'; 
        var_dump($task); 
        echo '</pre>'; 
        exit;

        

        ## run omega scraper with params
        $results = $omega_scraper->runSearchScraper( $omega_task );
        
    }
echo __FUNCTION__ . '<pre>'; 
var_dump('end'); 
echo '</pre>'; 
exit;

} else {
    throw new \Exception( 'Needs Campaign Task MetaData', 1);
}


#
########################
## v.2 - load campagin.cfg file ot BizAnalTask
########################
/* $taskObj = new BizAnalTask();
## END TASK TO PERFORM
########################

## create omega scraper object
$omega_scraper = new OmegaScraper();

## run omega scraper with params
$results = $omega_scraper->runSearchScraper( $omega_task );
  */
## TEST 1: STORE URLS, TITLES, & DESC FOR 3 PAGES
## UNIQUE, BUT SORTED BY SERP LISTNG
## KEEP SPONSIERE3D DOMAINS LABELD DIFFERENT FROM
## ORGANCIC LISTINGS