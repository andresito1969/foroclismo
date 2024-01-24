<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DB;

class CommentTest extends TestCase
{
    /**
     * TEST INFO:
     * Las funciones de crear-eliminar-actualizar no las testearemos porque podrían generar problemas de seguridad 
     * básicamente porque si intentamos poner el $request en el controlador(que se podría), alguien podría ejecutar esta función pública
     * con cualquier $request->user_id, de manera que un usuario común con conocimientos podría crear un comentario de admin.
     * 
     * Esto mismo sucede en la creación de topics.
     * 
     * TODO : Se puede solucionar haciendo que las peticiones pasen por API REST, de manera que desde esta función se llamaría a la API REST y desde
     * el testeo se llamaría a esta función con un token. Por lo tanto el usuario malicioso debería pasar siempre un token validado para poder crear 
     * dicha petición
     *  */ 
    public function test_show_existent_comment(): void
    {

        $commentList = DB::table('comments')
                ->join('users', 'users.id', 'comments.user_id')
                ->where('comments.topic_id', '=', 1)
                ->orderBy('comments.id')
                ->get();
        $foundComments = count($commentList) > 0;
        $this->assertTrue($foundComments);

    }

    public function test_show_unexistent_comment(): void
    {

        $commentList = DB::table('comments')
                ->join('users', 'users.id', 'comments.user_id')
                ->where('comments.topic_id', '=', -1)
                ->orderBy('comments.id')
                ->get();
        $foundComments = count($commentList) == 0;
        $this->assertTrue($foundComments);

    }
}
