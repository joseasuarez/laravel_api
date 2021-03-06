<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'identificador' => (int)$user->id,
            'nombre' => (string)$user->name,
            'email' => (string)$user->email,
            'verificado' => (int)$user->verified,
            'esAdministrador' => $user->esAdministrador(),
            'fechaCreacion' => (string)$user->created_at,
            'fechaActualizacion' => (string)$user->updated_at,
            'fechaModificacion' => isset($user->deleted_at) ? (string) $user->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('users.show',$user->id),
                ],
            ],
        ];


    }
    public static function originalAttribute($index){
        $attributes = [
            'identificador' =>'id',
            'nombre' => 'name',
            'email' => 'email',
            'verificado' => 'verified',
            'esAdministrador' => 'admin',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaModificacion' =>'deleted_at',
        ];
        return isset($attributes[$index])? $attributes[$index] : null;
    }
    public static function transformedAttribute($index){
        $attributes = [
            'id' => 'identificador',
            'name'=> 'nombre',
            'email'=> 'email',
            'verified'=> 'verificado',
            'admin'=> 'esAdministrador',
            'created_at'=> 'fechaCreacion',
            'updated_at'=> 'fechaActualizacion',
            'deleted_at'=> 'fechaModificacion',
        ];
        return isset($attributes[$index])? $attributes[$index] : null;
    }

}
