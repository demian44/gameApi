<?php

class UserApi
{
    public function Ver($request, $response, $args)
    {
        $response->getBody()->write('Hola');
    }

    public function TraerTodos($request, $response, $args)
    {
        try {
            if (UserRepository::TraerUsuarios($arrayUsers)) {
                $result = new ApiResponse(REQUEST_ERROR_TYPE::NOERROR, $arrayUsers);
            } else {
                $result = new ApiResponse(REQUEST_ERROR_TYPE::NODATA, "Sin elementos");
            }
        } catch (PDOException $exception) {
            $result = new ApiResponse(REQUEST_ERROR_TYPE::DATABASE, $exception->getMessage());
        } catch (Exception $exception) {
            $result = new ApiResponse(REQUEST_ERROR_TYPE::GENERAL, $exception->getMessage());
        }
        $response->getBody()->write($result->ToJsonResponse());
    }

    public function CargarUno($request, $response, $args)
    {
        try {
            $parsedBody = $request->getParsedBody();
            $user = new User(
                $parsedBody['email'],
                $parsedBody['password']
            );

            $requestResponse = UserRepository::Insert($user);
            $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::NOERROR, 
                $this->GenerateToken($user->GetEmail()));
            } catch (PDOException $exception) {
                $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::DATABASE, $exception->getMessage());
            } catch (Exception $exception) {
                $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::GENERAL, $exception->getMessage());
            }
            
            $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::NOERROR, 
                                        $this->GenerateToken("email"));
        $response->getBody()->write($requestResponse->ToJsonResponse());        
    }

    public function GenerateToken($email){
         // Metodo devuelve true si no hay error
            $token = array(
                "email" => $email,
                'exp' => time() + (6000 * 3), // La sesión dura 10 minutos.
                'nbf' => time(),
            );

            $securityToken = new SecurityToken();
            $encodedToken = $securityToken->Encode($token);
            return $encodedToken;
    }

    public function Editar($request, $response, $args)
    {
        try {
            $parsedBody = $request->getParsedBody();
            $user = new User(                
                $parsedBody['email'],
                $parsedBody['password']
                );

            $requestResponse = UserRepository::EditUsuarios($user);
        } catch (PDOException $exception) {
            $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::DATABASE, $exception->getMessage());
        } catch (Exception $exception) {
            $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::GENERAL, $exception->getMessage());
        }

        $response->getBody()->write($requestResponse->ToJsonResponse());
    }
    public function SaveResult($request, $response, $args)
    {
        try {
            $parsedBody = $request->getParsedBody();
            $user = new User($parsedBody['email'],"");
            $user->SetActualGame($parsedBody['game']);
            $user->SetActualGamePoints($parsedBody['point']);

            $requestResponse = UserRepository::SaveResult($user);
        } catch (PDOException $exception) {
            $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::DATABASE, $exception->getMessage());
        } catch (Exception $exception) {
            $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::GENERAL, $exception->getMessage());
        }
        
        $response->getBody()->write($requestResponse->ToJsonResponse());
    }

    public function Borrar($request, $response, $args)
    {
        try {
            $parsedBody = $request->getParsedBody();
            $id = $request->getParsedBody()['id'];
            $foto = $response->getHeader("foto");
            Venta::BackupFoto($foto[0], './UserImg/');
            $requestResponse = UserRepository::EliminarUsuario($id);
        } catch (PDOException $exception) {
            $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::DATABASE, $exception->getMessage());
        } catch (Exception $exception) {
            $requestResponse = new ApiResponse(REQUEST_ERROR_TYPE::GENERAL, $exception->getMessage());
        }

        $response->getBody()->write($requestResponse->ToJsonResponse());
    }
}
