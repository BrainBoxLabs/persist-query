<?php 

namespace BrainBoxLabs\PersistQuery\Tests\Feature;

use Orchestra\Testbench\TestCase;

class PersistTest extends TestCase
{
    public function testUrlQueryIsPersisted()
    {
        $response = $this->get('persist-query/books');
        $response->assertExactJson([]);

        $response = $this->get('persist-query/books?name=invisible&author=Mark');
        $response->assertExactJson([
            'name' => 'invisible',
            'author' => 'Mark',
        ]);

        $response = $this->get('persist-query/home');
        $response->assertSeeText('home page');

        $response = $this->followingRedirects()->get('persist-query/books');
        $response->assertExactJson([
            'name' => 'invisible',
            'author' => 'Mark',
        ]);
    }
    
    public function testUrlQueryIsPersistedAfterRedirect()
    {
        $response = $this->get('persist-query/books');
        $response->assertExactJson([]);

        $response = $this->get('persist-query/books?name=invisible&author=Mark');
        $response->assertExactJson([
            'name' => 'invisible',
            'author' => 'Mark',
        ]);

        $response = $this->followingRedirects()->post('persist-query/contact-us', []);
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