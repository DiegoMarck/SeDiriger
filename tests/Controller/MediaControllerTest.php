<?php

namespace App\Test\Controller;

use App\Entity\Media;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MediaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private MediaRepository $repository;
    private string $path = '/media/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Media::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Medium index');

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
            'medium[nom]' => 'Testing',
            'medium[description]' => 'Testing',
            'medium[genre]' => 'Testing',
            'medium[date_de_creation]' => 'Testing',
            'medium[taille]' => 'Testing',
        ]);

        self::assertResponseRedirects('/media/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Media();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setGenre('My Title');
        $fixture->setDate_de_creation('My Title');
        $fixture->setTaille('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Medium');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Media();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setGenre('My Title');
        $fixture->setDate_de_creation('My Title');
        $fixture->setTaille('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'medium[nom]' => 'Something New',
            'medium[description]' => 'Something New',
            'medium[genre]' => 'Something New',
            'medium[date_de_creation]' => 'Something New',
            'medium[taille]' => 'Something New',
        ]);

        self::assertResponseRedirects('/media/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getGenre());
        self::assertSame('Something New', $fixture[0]->getDate_de_creation());
        self::assertSame('Something New', $fixture[0]->getTaille());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Media();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setGenre('My Title');
        $fixture->setDate_de_creation('My Title');
        $fixture->setTaille('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/media/');
    }
}
