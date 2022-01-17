<?php

use Illuminate\Support\Str;

function getAllModels()
{
    $classes = \File::allFiles(app_path('Models'));
    $model = collect();
    foreach ($classes as $class) {
        $model->add(
            Str::lower(Str::plural($class->classname = str_replace(
                [app_path(), '/', '.php'],
                ['App', '\\', ''],
                $class->getFilename())
            )));
    }

    return $model;
}
