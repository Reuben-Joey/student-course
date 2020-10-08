<?php
/*
The main method to make it possible to use classes anywhere
by autoloading those classes

This method also introduces another problem where we have to 
preceed every class with \
TODO: Need to work more on this method to avoid this namespacing issue.
*/
spl_autoload_register( function ($className) {
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = strtolower(substr($className, 0, $lastNsPos));
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    if (file_exists($fileName)) {
        require $fileName;
    }    
});

$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'],'/')) : '/';
if ($url == '/')
{
    // For the / url we display home page
    $home = new \Controller\Home();
    $home->show();
} else {
    // For all other urls we display its own page

    //The first element of the url should be a controller
    $Controller = ucfirst($url[0]); 

    // If a second part is added in the url, 
    // it should be a method
    $Method = isset($url[1])? $url[1] :'';

    // The remain parts are considered as 
    // arguments of the method
    $Params = array_slice($url, 2); 

    // Check if controller exists. NB: 
    // You have to do that for the model and the view too
    $ctrlPath = __DIR__.'/controller/'.$Controller.'.php';

    if (file_exists($ctrlPath))
    {
        /*
            TODO: Look for ways to create $ctrlObj dynamically
            example
            $ctrlObj = new \Controller\$Controller();
        */
        if ($Controller=='Student'){
            $ctrlObj = new \Controller\Student();
        } else if ($Controller=='Course'){
            $ctrlObj = new \Controller\Course();
        } else if ($Controller=='Subscription'){
            $ctrlObj = new \Controller\Subscription();
        }
        
        // If there is a method - Second parameter
        if ($Method != '')
        {
            // then we call the method via the view
            // dynamic call of the view
            $ctrlObj->$Method($Params);

        } else {
            $ctrlObj->show();  
        }

    }else{

        header('HTTP/1.1 404 Not Found');
        die('404 - The path - '.$ctrlPath.' - not found');
        //require the 404 controller and initiate it
        //Display its view
    }
}

 
