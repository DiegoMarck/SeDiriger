<?php

namespace App\Test\Controller;

use App\Entity\Camera;
use App\Repository\CameraRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CameraControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CameraRepository $repository;
    private string $path = '/camera/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Camera::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Camera index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'camera[connexion]' => 'Testing',
            'camera[video]' => 'Testing',
            'camera[source]' => 'Testing',
            'camera[user]' => 'Testing',
            'camera[guideVocal]' => 'Testing',
        ]);

        self::assertResponseRedirects('/camera/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Camera();
        $fixture->setConnexion('My Title');
        $fixture->setVideo('My Title');
        $fixture->setSource('My Title');
        $fixture->setUser('My Title');
        $fixture->setGuideVocal('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Camera');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Camera();
        $fixture->setConnexion('My Title');
        $fixture->setVideo('My Title');
        $fixture->setSource('My Title');
        $fixture->setUser('My Title');
        $fixture->setGuideVocal('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'camera[connexion]' => 'Something New',
            'camera[video]' => 'Something New',
            'camera[source]' => 'Something New',
            'camera[user]' => 'Something New',
            'camera[guideVocal]' => 'Something New',
        ]);

        self::assertResponseRedirects('/camera/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getConnexion());
        self::assertSame('Something New', $fixture[0]->getVideo());
        self::assertSame('Something New', $fixture[0]->getSource());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getGuideVocal());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Camera();
        $fixture->setConnexion('My Title');
        $fixture->setVideo('My Title');
        $fixture->setSource('My Title');
        $fixture->setUser('My Title');
        $fixture->setGuideVocal('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/camera/');
    }
}
