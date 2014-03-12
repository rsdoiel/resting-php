<?php
/**
 * resting.php - a simple functional style library for building RESTful http services.
 */

/**
 * fmtHeader() - assemble a header for eventual processing by a renderRoute. Typically
 * you append the results of this function to a list of headers.
 * @param $message - the text, e.g. "Content-Type: text/plain"
 * @param $overwrite - set the replace status for processing with PHP's header() function.
 * @param $status_code - this is a HTTP 1.1 status code (e.g. 404, 503, 302)
 * @returns an array of one to three elements formatted for use by renderRoutes
 * Example:
 *   $myheaders = array();
 *   $myheaders[] = fmtHeader("", true, 200);
 *   $myheaders[] = fmtHeader("Content-Type: text/plain");
 */
function fmtHeader($message, $overwrite = null, $status_code = null) {
    $h = array($message);
    if ($overwrite !== null) {
        $h[] = $overwrite;
    }
    if ($status_code !== null) {
        $h[] = $status_code;
    }
    return $h;
}

/**
 * fmtReponse - assemble an array of headers and content into a full HTTP response.
 * @param $headers - an array of headers formatted with fmtHeader()
 * @param $content - the content to be sent back to the browser (e.g. HTML, JSON, etc);
 */
function fmtResponse($headers, $content) {
    return array(
        // An array of parameters to call with the PHP  headers function
        "HTTP_HEADER" => $headers,
        // The content to send to the web browser after headers are finished.
        "HTTP_CONTENT" => $content
    );
}

/**
 * defaultRoute - this basically sets up a 404 as this is the default route for a request
 * that is not valid. It is also an example of the function signature expected to by executeRoute();
 */
function defaultRoute($path_info, $options) {
    $h = array();
    $h[] = fmtHeader("File Not Found", true, 404);
    $h[] = fmtHeader("Content-Type: text/plain", true);
    // If this was a user defined route handler they would use things like safeGET(), safePOST(), etc. to
    // process the request and validate things.
    return fmtResponse($h, "File Not Found");
}

/**
 * fmtRoute - build a simple Associative array which can be used to process routes
 * when calling a list of routes in executeRoute()
 * @param $path_reg_exp - a PRCE reg exp representing the target path
 * @param $callback - the callback to execute if route matches
 * @param $options - an associative array of options to pass to the callback function (e.g. validation rules)
 * @return an associative array describing the route to be processed.
 */
function fmtRoute($path_reg_exp, $callback, $options = null) {
    // Escape any | pipe symbols in the route so we have a valid pattern to pass to PCRE
    return array("path_reg_exp" => '#' . str_replace('#', '\#', $path_reg_exp) . '#',
                 "callback" => $callback,
                 "options" => $options);
}

/**
 * executeRoute - using a array of routes scan $_SERVER['PATH_INFO'] and execute
 * appropriate callbacks.
 * @param $path_info -  the urlencoded path to match, typically from $_SERVER['PATH_INFO'])
 * @param $routes - an array of routes constructed with fmtRoute().
 * @return a PHP Associative array suitable for processing with renderRoute();
 */
function executeRoute($path_info, $routes) {
    $path = urldecode($path_info);
    for ($i = 0; $i < count($routes); $i += 1) {
        if (preg_match($routes[$i]["path_reg_exp"], $path) === 1 ) {
            // We have a match so make the callback passing it any 
            // options defined in the route.
            return $routes[$i]["callback"]($path, $routes[$i]["options"]);
        }
    }
    // We really didn't find it so the default case is 404.
    return defaultRoute($path, null);
}

/**
 * renderRoute - emmit headers and contents described by the results of executeRoute()
 * @param $route_results
 * @sideeffects emits headers and sends content to stdout
 * @return always true
 */
function renderRoute($route_results) {
    // Output headers
    foreach($route_results["HTTP_HEADER"] as $header_params) {
        if (count($header_params) === 1) {
            header($header_params[0]);
        } else if (count($header_params) === 2) {
            header($header_params[0], $header_params[1]);
        } else if (count($header_params) === 3) {
            header($header_params[0], $header_params[1], $header_params[2]);
        }
    }
    // Out put content.
    echo $route_results["HTTP_CONTENT"];
    return true;
}
?>
