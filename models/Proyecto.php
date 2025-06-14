<?php

namespace Proyecto;

use Model\ActiveRecord;

/* MODELO PARA PROYECTOS */

#[\AllowDynamicProperties]
class Proyecto extends ActiveRecord
{
    protected static $tabla = 'proyectos';
    protected static $columnasDB = ['id', 'proyecto', 'url', 'propietarioId'];

    public $id;
    public $proyecto;
    public $url;
    public $propietarioId;

    /* CONSTRUCTOR */
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->proyecto = $args['proyecto'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->propietarioId = $args['propietarioId'] ?? '';
    }
}
