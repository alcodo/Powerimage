<?php

use Alcodo\PowerImage\Jobs\CreateImage;

class TestCase extends Orchestra\Testbench\TestCase
{
    public function setUp()
    {
        parent::setUp();

        $exampleFile = __DIR__.'/files/example.png';

        $temp_file = sys_get_temp_dir().'/example.png';
        copy($exampleFile, $temp_file);

        $this->tempFile = $temp_file;
    }

    public function tearDown()
    {
        Storage::disk('powerimage')->deleteDirectory('powerimage');
        unlink($this->tempFile);
        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Alcodo\PowerImage\PowerImageServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $fileSystemSettings = [
            'driver' => 'local',
            'root' => storage_path('powerimage'),
        ];

        $app['config']->set('filesystems.disks.powerimage', $fileSystemSettings);
    }

    public function callPrivateOrProtectedMethod($obj, $name, array $args)
    {
        $class = new \ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method->invokeArgs($obj, $args);
    }

    public function getImage($folder = null)
    {
        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile($this->tempFile, 'example.png');

        // convert and save
        $image = new CreateImage($file, null, $folder);
        $imageOptimizer = app('Approached\LaravelImageOptimizer\ImageOptimizer');
        $filepath = $image->handle($imageOptimizer);

        return $filepath;
    }

    /**
     * @test
     */
    public function it_allows_to_use_service()
    {
        $this->assertNotEmpty(
            app('Approached\LaravelImageOptimizer\ImageOptimizer')
        );
    }
}
