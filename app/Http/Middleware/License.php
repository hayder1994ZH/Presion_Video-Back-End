<?php

namespace App\Http\Middleware;

use App\Models\Companies;
use App\Models\Companies_ip;
use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;

class License extends Middleware
{
    /**
     * Handle an incoming request.
     * @param array $company
     * @param $next
     * @param $request
     * @return mixed
     * @throws JWTException
     */
    public function handle($request, Closure $next, ...$company)
    {

        $request->attributes->add([
            'companyInfo' =>  $company,
            'host' =>  'http://'.$_SERVER['REMOTE_ADDR'].':8000',
            'host_video' => 'http://'.$_SERVER['REMOTE_ADDR'].':8000',
            ]);
        // $http_protocol = $request->server('REQUEST_SCHEME');
        // $ip = $request->server('REMOTE_ADDR');
        // $company = $this->checkCompany($ip);
        // $defualtCompany = $this->getDefualtCompany();
        // if ($request->server->has('HTTP_HOST_NAME')) {
        //     if (!is_null($company)) {
        //         $http = ($company->is_ssl)? 'https': 'http';
        //         $https = ($company->is_ssl_videos)? 'https': 'http';
        //         $request->attributes->add([
        //         'companyInfo' =>  $company,
        //         'host' =>  $http . '://' . $company->url,
        //         'host_video' =>  $https . '://' . $company->streamurl . ':' . $company->streamport,
        //         ]);
        //     } else {
        //         $http = ($defualtCompany->is_ssl)? 'https': 'http';
        //         $https = ($defualtCompany->is_ssl_videos)? 'https': 'http';
        //         $request->attributes->add([
        //             'companyInfo' =>  $defualtCompany,
        //             'host' =>  $http . '://' . $defualtCompany->url,
        //             'host_video' => $https . '://' . $defualtCompany->streamurl . ':' . $defualtCompany->streamport,
        //         ]);
        //     }
        // } else {
        //     $http = ($defualtCompany->is_ssl)? 'https': 'http';
        //     $https = ($defualtCompany->is_ssl_videos)? 'https': 'http';
        //     $request->attributes->add([
        //         'companyInfo' =>  $defualtCompany,
        //         'host' =>  $http . '://' . $defualtCompany->url,
        //         'host_video' =>  $https . '://' . $defualtCompany->streamurl . ':' . $defualtCompany->streamport,
        //     ]);
        // }
        return $next($request);
    }

    public function checkCompany($ip)
    {
       $company = Companies::where('localip', $ip)->first();
       if($company){
           return $company;
       }
       return null;
    } 
    public function getDefualtCompany()
    {
       $company = Companies::where('is_defualt', 1)->first();
       if($company){
           return $company;
       }
       return null;
    }
}
