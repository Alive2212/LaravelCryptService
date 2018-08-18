<?php

namespace Alive2212\LaravelCryptService\Console\Commands;

use Alive2212\LaravelCryptService\LaravelCryptService;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypt:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To initialize laravel crypt service';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * to generate private key execute
     * "openssl genpkey -algorithm RSA -pkeyopt rsa_keygen_bits:{bits} -out {address}/{private file name}"
     *
     */
    public function handle()
    {
        $this->generatePrivateKey();
        $this->generatePublicKey();
    }

    /**
     *
     */
    public function generatePrivateKey()
    {
        // enter before execute any thing
        echo PHP_EOL;

        // create new process
        $process = new Process(
            'openssl genpkey -algorithm RSA -pkeyopt rsa_keygen_bits:' .
            config('laravel-crypt-service.bits') .
            ' -out ' .
            (new LaravelCryptService())->getPrivateKeyAddress());
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            echo $process->getErrorOutput();
            return;
        }

        echo config('laravel-crypt-service.file.name') .
            ' in ' .
            config('laravel-crypt-service.file.address') .
            ' successfully created.';
        echo PHP_EOL;
    }

    /**
     * for generate public key execute
     * "openssl rsa -pubout -in {address}/{private file name} -out {address}/{public file name}"
     */
    public function generatePublicKey()
    {
        // enter before execute any thing
        echo PHP_EOL;

        // create new process
        $process = new Process(
            'openssl rsa -pubout -in ' .
            (new LaravelCryptService())->getPrivateKeyAddress().
            ' -out ' .
            (new LaravelCryptService())->getPrivateKeyAddress().
            '.pub');
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            echo $process->getErrorOutput();
            return;
        }

        echo config('laravel-crypt-service.file.name') .
            ' in ' .
            config('laravel-crypt-service.file.address').'.pub'.
            ' successfully created.';
        echo PHP_EOL;
    }

}

