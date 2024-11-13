<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require '../src/vendor/autoload.php';
$app = new \Slim\App;

    //user registration
    $app->post('/user/register', function (Request $request, Response $response, 
    array $args) {
        $data=json_decode($request->getBody());
        $usr =$data->username;
        $pass=$data->password;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO users (username,password)
        VALUES ('". $usr ."','". hash('SHA256',$pass) ."')";
        // use exec() because no results are returned
        $conn->exec($sql);
        $response->getBody()->write(json_encode(array("status"=>"success","data"=>null)));
    } catch(PDOException $e) {
        $response->getBody()->write(json_encode(array("status"=>"fail",
        "data"=>array("title"=>$e->getMessage()))));
    }
        return $response;
    });

     //user authentication
     $app->post('/user/authenticate', function (Request $request, Response $response, 
     array $args) {
         $data=json_decode($request->getBody());
         $usr =$data->username;
         $pass=$data->password;
 
         $servername = "localhost";
         $username = "root";
         $password = "";
         $dbname = "library";
         try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM users WHERE username='". $usr ."'
                    AND password='". hash('SHA256',$pass) ."'";
                    
            // use exec() because no results are returned
            $stmt=$conn->prepare($sql);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data=$stmt->fetchAll();

            if(count($data)==1){
               // echo $uname;
                $key = 'server_hack';
                $iat=time();
                $payload = [
                    'iss' => 'http://library.org',
                    'aud' => 'http://library.com',
                    'iat' => $iat,
                    'exp' => $iat+3600,
                    "data" => array(
                        "userid" => $data[0]['userid']
                    )
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');
                $response->getBody()->write(json_encode(
                array("status"=>"success","token"=>$jwt,"data"=>null)));
            }else{
                $response->getBody()->write(json_encode(array("status"=>"fail",
                "data"=>array("title"=>"Authentication Failed"))));
            } 
          
        } catch(PDOException $e) {
            $response->getBody()->write(json_encode(array("status"=>"fail",
            "data"=>array("title"=>$e->getMessage()))));
        }

         return $response;
     });
 
 

    

$app->run();
?>