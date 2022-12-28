<?php

/**
 * lib/Dhcp.php
 *
 *
 *
 * PHP version 5
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3.0 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category  default
 *
 * @author    Andrew Jones
 * @copyright 2022 @authors
 * @license   http://www.gnu.org/copyleft/lesser.html The GNU LESSER GENERAL PUBLIC LICENSE, Version 3.0
 */

namespace ohtarr\Gizmo;

use GuzzleHttp\Client as GuzzleHttpClient;

class Dhcp
{
    public $token;
    public $baseurl;

	public function __construct($token, $baseurl)
	{
        $this->token = $token;
        $this->baseurl = $baseurl;
	}

	public static function getAzureToken($tenantid, $clientid, $clientsecret, $scope)
	{
		$verb = "post";
        $url = "https://login.microsoftonline.com/" . $tenantid . "/oauth2/v2.0/token";
        $body = [
            'grant_type' => 'client_credentials',
            'client_id' => $clientid,
            'client_secret' => $clientsecret,
            'scope' => $scope,
        ];
        $options = [];
        $params = [
            'headers'   =>  [
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'Accept'        => 'application/json',
             ],
            'form_params' => $body,
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
        return $array;
	}

    public function getAllScopes()
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/scopes";

        $options = [];
        $params = [
            'headers'   =>  [
                 'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function getScope($scopeid)
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/scope/" . $scopeid;

        $options = [];
        $params = [
            'headers'   =>  [
                 'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

	public function getScopesBySitecode($sitecode)
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/scope/site/" . $sitecode;

        $options = [];
        $params = [
            'headers'   =>  [
                'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function getScopeStatistics($scopeid)
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/statistics/" . $scopeid;

        $options = [];
        $params = [
            'headers'   =>  [
                'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
    }

    public function getScopeReservations($scopeid)
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/reservations/" . $scopeid;

        $options = [];
        $params = [
            'headers'   =>  [
                'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

	public function addScopeReservation($scopeid, $mac, $ip, $description)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
			"scopeID"	    =>  $scopeid,
            "ClientId"      =>  $mac,
            "IPAddress"     =>  $ip,
            "Description"   =>  $description,
		];
		$verb = "POST";
		$url = $this->baseurl . "/api/dhcp/reservation";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function updateScopeReservation($scopeid, $mac, $ip, $description)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
			"scopeID"	    =>  $scopeid,
            "ClientId"      =>  $mac,
            "IPAddress"     =>  $ip,
            "Description"   =>  $description,
		];
		$verb = "PATCH";
		$url = $this->baseurl . "/api/dhcp/reservation";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function deleteScopeReservation($ip)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
            "IPAddress"     =>  $ip,
		];
		$verb = "DELETE";
		$url = $this->baseurl . "/api/dhcp/reservation";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function convertLeaseToReservation($ip)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/reservation/convert/" . $ip;

        $options = [];
        $params = [
            'headers'   =>  [
                'Accept'        => 'application/json',
                'Authorization'   => 'Bearer ' . $this->token,
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function getScopeLeases($scopeid)
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/leases/" . $scopeid;

        $options = [];
        $params = [
            'headers'   =>  [
                'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function deleteScopeLeases($scopeid)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
            "ScopeId"     =>  $scopeid,
		];
		$verb = "DELETE";
		$url = $this->baseurl . "/api/dhcp/leases";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function deleteScopeLeasesByIp($ips = [])
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
            "IpAddresses"     =>  $ips,
		];
		$verb = "DELETE";
		$url = $this->baseurl . "/api/dhcp/leases";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function deleteScopeLeasesByMac($macs = [])
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
            "Clients"     =>  $macs,
		];
		$verb = "DELETE";
		$url = $this->baseurl . "/api/dhcp/leases";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function getScopeFailover($scopeid)
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/failover/" . $scopeid;

        $options = [];
        $params = [
            'headers'   =>  [
                'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);

		//Fix response from Gizmo
		if(isset($array['name']))
		{
			if($array['name'])
			{
				return $array;
			}
		}
		return null;
	}

    public function addScopeFailover($scopeid, $failovername)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
			"scopeID"	        =>  $scopeid,
            "FailoverName"      =>  $failovername,
		];
		$verb = "POST";
		$url = $this->baseurl . "/api/dhcp/failover";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function deleteScopeFailover($scopeid, $failovername)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
			"scopeID"	        =>  $scopeid,
            "FailoverName"      =>  $failovername,
		];
		$verb = "DELETE";
		$url = $this->baseurl . "/api/dhcp/failover";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function getScopeNextIp($scopeid)
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/ip/" . $scopeid;

        $options = [];
        $params = [
            'headers'   =>  [
                'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function getScopeExclusion($scopeid)
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/scope/exclusion/" . $scopeid;

        $options = [];
        $params = [
            'headers'   =>  [
                'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function addScopeExclusion($scopeid, $startrange, $endrange)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }
		
		$body = [
            "ScopeId"       => $scopeid,
            "StartRange"    => $startrange,
            "EndRange"      => $endrange,
        ];
		$verb = "POST";
		$url =  $this->baseurl . "/api/dhcp/scope/exclusion";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
				//'Authorization' => $token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function deleteScopeExclusion($scopeid, $startrange, $endrange)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }
		
		$body = [
            "ScopeId"       => $scopeid,
            "StartRange"    => $startrange,
            "EndRange"      => $endrange,
        ];
		$verb = "DELETE";
		$url =  $this->baseurl . "/api/dhcp/scope/exclusion";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
				//'Authorization' => $token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function getScopeOptions($scopeid)
	{
		$verb = "get";
        $url = $this->baseurl . "/api/dhcp/options/" . $scopeid;

        $options = [];
        $params = [
            'headers'   =>  [
                'Accept'        => 'application/json',
             ],
        ];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function activateScope($scopeid)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }
		$verb = "GET";
		$url =  $this->baseurl . "/api/dhcp/scope/activate/" . $scopeid;
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
				//'Authorization' => $token,
			],
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function deactivateScope($scopeid)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }
		$verb = "GET";
		$url =  $this->baseurl . "/api/dhcp/scope/deactivate/" . $scopeid;
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
				//'Authorization' => $token,
			],
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function addScope($scopeparams)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }
		
		$body = $scopeparams;
		$verb = "POST";
		$url =  $this->baseurl . "/api/dhcp/scope";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
				//'Authorization' => $token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

    public function deleteScope($scopeid)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = ["scopeID" => $scopeid];
		$verb = "DELETE";
		$url =  $this->baseurl . "/api/dhcp/scope";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

	public function deleteScopeOption($scopeid, $optionid)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
			"scopeID"	=> $scopeid,
			"optionId"	=> $optionid,
		];
		$verb = "DELETE";
		$url = $this->baseurl . "/api/dhcp/options";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

	public function addScopeOption($scopeid, $optionid, $optionvalue)
	{
        if(!$this->token)
        {
            throw new \Exception('Token Required!');
        }

		$body = [
			"scopeID"	=> $scopeid,
			"optionId"	=> $optionid,
			"Value"		=> $optionvalue,//array
		];
		$verb = "POST";
		$url = $this->baseurl . "/api/dhcp/options";
		
        $options = [];
		$params = [
			'headers'   =>  [
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
		        'Authorization'   => 'Bearer ' . $this->token,
			],
			'body'  =>  json_encode($body),
		];

        $client = new GuzzleHttpClient($options);
        //Build a Guzzle POST request
        $apiRequest = $client->request($verb, $url, $params);
        $response = $apiRequest->getBody()->getContents();
        $array = json_decode($response,true);
		return $array;
	}

}