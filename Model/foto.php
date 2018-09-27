<?php
class Foto extends Entity
{
    private $foto;

    public function __construct($color, $marca, $talle, $precio)
    {
        $this->color = $color;
        $this->marca = $marca;
        $this->talle = $talle;
        $this->precio = $precio;
    }

    public function GetFoto()
    {
        return $this->foto;
    }

    public function SetFoto($foto)
    {
        $retorno = false;
        //if (is_int($foto)) {
        $this->foto = $foto;
        $retorno = true;
        //}

        return $retorno;
    }

    public static function SaveFoto($file, $email, $destino)
    {
        ////GUARDAR ARCHIVO
        $nombreAnterior = $file['foto']->getClientFilename();
        $extension = explode('.', $nombreAnterior);

        $file['foto']->moveTo($destino . "$email." . $extension[1]);
        return substr($destino, 2) . "$email." . $extension[1];
    }

    public static function BackupFoto($file, $path)
    {
        $return = false;
        $fileName = explode("/", $file);
        $file = trim($file);
        $emailFile = trim($fileName[count($fileName) - 1]);
        $pathFile = $path . $emailFile;
        $arrayFileName = explode(".", $nameFile);
        $return = true;
        copy($pathFile, "./backUp/" . $nameFile);
        unlink($pathFile);
        return $return;
    }
}
