<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeRepository extends GeneratorCommand
{
    /**
     * The name and name of the console command.
     *
     * @var string
     */
    protected $name = 'make:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     *
     * Replace the class name for the given stub.
     *
     * @param string $stub
     * @param string $name
     * @return string
     */
    public function replaceClass($stub, $name): String
    {
        $stub = parent::replaceClass($stub, $name);
        return Str::replace('DummyRepository', $this->argument('name'), $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return app_path() . '/Console/Commands/Stubs/make-repository.stub';
    }

    /**
     * Get the default namespace for the class
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): String
    {
        return "$rootNamespace\Http\Repositories";
    }
    /**
     * Get the console command arguments
     *
     * @return array
     */
    protected function getArguments(): Array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository is required.'],
        ];
    }
}
