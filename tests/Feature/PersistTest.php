<?php 

namespace BrainBoxLabs\PersistQuery\Tests\Feature;

use Orchestra\Testbench\TestCase;

class PersistTest extends TestCase
{
    public function testUrlQueryIsPersisted()
    {
        $response = $this->get('testing/books');
        $response->assertExactJson([]);

        $response = $this->get('testing/books?name=invisible&author=Mark');
        $response->assertExactJson([
            'name' => 'invisible',
            'author' => 'Mark',
        ]);

        $response = $this->get('testing/home');
        $response->assertSeeText('home page');

        $response = $this->followingRedirects()->get('testing/books');
        $response->assertExactJson([
            'name' => 'invisible',
            'author' => 'Mark',
        ]);
    }
    
    public function testUrlQueryIsPersistedAfterRedirect()
    {
        $response = $this->get('testing/books');
        $response->assertExactJson([]);

        $response = $this->get('testing/books?name=invisible&author=Mark');
        $response->assertExactJson([
            'name' => 'invisible',
            'author' => 'Mark',
        ]);

        $response = $this->followingRedirects()->post('testing/contact-us', []);
        $response->assertExactJson([
            'name' => 'invisible',
            'author' => 'Mark',
        ]);
        $response->assertSessionHas('success', 'Thanks for reaching out!');
    }

    protected function getPackageProviders($app)
    {
        return [
            \BrainBoxLabs\PersistQuery\TestingServiceProvider::class,
        ];
    }
}