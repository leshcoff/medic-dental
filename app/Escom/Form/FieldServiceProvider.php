<?php

namespace Escom\Form;

use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider {
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {

        $this->registerFieldBuilder();
        //$this->app->alias('field', 'Escom\Form\FieldBuilder');
    }



    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerFieldBuilder()
    {

        app()->bind('field', function () {
            return new FieldBuilder;
        });



    }
}
