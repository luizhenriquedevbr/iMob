<?php

class Security {

    public function authorize(array $credentials){
        if($usuario = $this->checkCredentials($credentials)){
            $this->setUser($usuario);
        }
    }

    public function setUser(array $usuario)
    {
        $data = [
            'co_autorizado'   => $usuario['co_autorizado'],
            'no_autorizado'   => $usuario['no_autorizado'],
            'ds_email'        => $usuario['ds_email'],
            'tp_autorizado'   => $usuario['tp_autorizado'],
        ];

        $_SESSION['user'] = $data;
    }

    public static function getUser()
    {
        return $_SESSION['user'] ?? [];
    }

    public static function getUserRoles()
    {
        $user = self::getUser();

        if(empty($user)){
            return [];
        }

        $unidadeRoles = [
            1 => 'ROLE_ADM',
            2 => 'ROLE_USER',
        ];

        $roles[] = 'ROLE_USER';

        $roles[] = $unidadeRoles[$user['tp_autorizado']];

        return $roles;
    }

    public function checkCredentials($credentials)
    {
        $autorizado = new Autorizado();

        $dados = $autorizado->pesquisarAutorizadoPorEmail($credentials['ds_email']);

        if( ! $dados){
            throw new Exception('Usuário não encontrado.');
        }

        if (hash("SHA512", $credentials['senha']) !== $dados['senha']) {
            throw new Exception('A senha digitada está incorreta.');
        }

        if( ! (bool) $dados['status']){
            throw new Exception('Usuário não está habilitado para acessar o sistema.');
        }

        return $dados;
    }

    public static function isAuthenticated(){
        return ! empty(self::getUser());
    }

    public static function isGranted(string $role){
        if( ! self::isAuthenticated()){
            return false;
        }

        return in_array($role, self::getUserRoles());
    }

    public function destroy(){
        unset($_SESSION['user']);
    }

}
