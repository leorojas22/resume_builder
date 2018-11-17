<?php
namespace App\Service;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;


class JwtService
{
    private $error;

    public function createJwtCookie($payload = [])
    {
        $expireTime = isset($payload['exp']) ? $payload['exp'] : time() + 3600;
        $payload['exp'] = $expireTime;

        $jwt = JWT::encode($payload, getenv("JWT_SECRET"));

        // If you are developing on a non-https server, you will need to set
        // the $useHttps variable to false

        $useHttps = false;
        setcookie("jwt", $jwt, $expireTime, "", "", $useHttps, true);
    }

    public function verifyToken($token)
    {
        // Default error message
        $this->error = "Unable to validate session.";

        try
        {
            $decodedJwt = JWT::decode($token, getenv("JWT_SECRET"), ['HS256']);

            $this->error = "";

            // Refresh token if it's expiring in 10 minutes
            if(time() - $decodedJwt->exp < 600)
            {
                $this->createJwtCookie([
                    'user_id' => $decodedJwt->user_id,
                    'email'   => $decodedJwt->email
                ]);
            }

            return [
                'user_id' => $decodedJwt->user_id,
                'email' => $decodedJwt->email
            ];
        }
        catch(ExpiredException $e)
        {
            $this->error = "Session has expired.";
        }
        catch(SignatureInvalidException $e)
        {
            // In this case, you may also want to send an email to yourself with the JWT
            // If someone uses a JWT with an invalid signature, it could
            // be a hacking attempt.
            $this->error = "Attempting access invalid session.";
        }
        catch(\Exception $e)
        {
           // Use the default error message
        }

        return false;
    }

    public function getError()
    {
        return $this->error;
    }
}

