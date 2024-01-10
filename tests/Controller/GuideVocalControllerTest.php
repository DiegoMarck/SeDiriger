<?php

namespace App\Test\Controller;

use App\Entity\GuideVocal;
use App\Repository\GuideVocalRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GuideVocalControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private GuideVocalRepository $repository;
    private string $path = '/guide/vocal/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(GuideVocal::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('GuideVocal index');

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
            'guide_vocal[voix]' => 'Testing',
            'guide_vocal[niveau_accompagnement]' => 'Testing',
        ]);

        self::assertResponseRedirects('/guide/vocal/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new GuideVocal();
        $fixture->setVoix('My Title');
        $fixture->setNiveau_accompagnement('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('GuideVocal');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new GuideVocal();
        $fixture->setVoix('My Title');
        $fixture->setNiveau_accompagnement('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'guide_vocal[voix]' => 'Something New',
            'guide_vocal[niveau_accompagnement]' => 'Something New',
        ]);

        self::assertResponseRedirects('/guide/vocal/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getVoix());
        self::assertSame('Something New', $fixture[0]->getNiveau_accompagnement());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new GuideVocal();
        $fixture->setVoix('My Title');
        $fixture->setNiveau_accompagnement('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/guide/vocal/');
    }
}
