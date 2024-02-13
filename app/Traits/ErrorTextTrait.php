<?php
namespace App\Traits;
use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;


trait ErrorTextTrait {

    // TODO : There's a better way for sure of implementing and avoid traits.
    
    public function getGenericError() {
        return "¡Vaya! Algo ha fallado...";
    }

    /*
     * Text errors de comentarios
     */
    public function getCommentTextLengthError() {
        return "Tu comentario es demasiado largo o demasiado corto, debes poner entre 1 y " . Comment::maxLengthText . " carácteres...";
    }

    public function getCommentMaliciousDeleteError() {
        return 'No intentes borrar un comentario que no es tuyo!';
    }

    public function getCommentMaliciousEditError() {
        return 'No intentes editar un comentario que no es tuyo!';
    }

    /*
     * Text errors de topics
     */
    public function getTopicTextLengthError() {
        return "El texto es demasiado largo o demasiado corto, debes poner entre 1 y " . Topic::maxLengthText . " carácteres...";
    }
    
    public function getTopicTitleLengthError() {
        return "El título es demasiado largo o demasiado corto, debes poner entre 1 y " . Topic::maxLengthTitle . " carácteres...";
    }
    
    public function getTopicMaliciousEdit() {
        return 'No intentes editar un topic que no es tuyo!';
    }

    public function getTopicMaliciousDeleteError() {
        return 'No intentes borrar un comentario que no es tuyo!';
    }

    /*
     * Text errors de user
     */
    public function getNameError() {
        return 'Recuerda que tienes que poner un nombre y como máximo de ' . User::maxLengthName . ' caracteres';
    }

    public function getLastNameError() {
        return 'Recuerda que tienes que poner un apellido y como máximo de ' . User::maxLengthLastName . ' caracteres';
    }

    public function getPasswordError() {
        return 'Recuerda que la contraseña tiene que ser mayor a ' . User::minLengthPassword . ' e inferior a ' . User::maxLengthPassword . ' caracteres';
    }

    /*
     * Banned Message
     */
    public function getBannedUserError() {
        return 'vaya parece que has sido baneado :(';
    }
}