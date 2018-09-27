<?php
class TokenRepository
{
    public static function CheckUser($user)
    {
        $response = new ApiResponse(REQUEST_ERROR_TYPE::TOKEN, "User incorrecto");

        try {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta('SELECT * FROM users WHERE ' .
                'email = :email AND active=1');
            $consulta->execute(array(':email' => $user->GetEmail()));
            $array = $consulta->fetchall();
            if (count($array) > 0) {
                $row = $array[0];
                if (isset($row["password"]) && $row["password"] == $user->GetPass()) {
                    $perfil["email"] = $row["email"];
                    $perfil["naval"] = $row["naval"];
                    $perfil["tateti"] = $row["tateti"];
                    $perfil["agilidad"] = $row["agilidad"];
                    $perfil["piedra"] = $row["piedra"];
                    $perfil["numero"] = $row["numero"];
                    $perfil["anagrama"] = $row["anagrama"];
                    $response = new ApiResponse(REQUEST_ERROR_TYPE::NOERROR, $perfil);
                } else {
                    $response = new ApiResponse(REQUEST_ERROR_TYPE::TOKEN, "Pass incorrecto");
                }
            }
        } catch (PDOException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            throw $exception;
        }

        return $response;

    }

}
