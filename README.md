# gizmo
PHP Library for accessing a custom API

#Installation
composer require ohtarr/gizmo

#usage
use ohtarr\Gizmo\Dhcp;

$token = "yourazuretoken";
$baseurl = "https://gizmosecreturl.com";

$dhcp = new Dhcp($token, $baseurl);
$scopes = $dhcp->getAllScopes();
