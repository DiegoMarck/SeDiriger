<?php

namespace App\Test\Controller;

use App\Entity\Parcours;
use App\Repository\ParcoursRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ParcoursControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ParcoursRepository $repository;
    private string $path = '/parcours/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Parcours::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Parcour index');

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
            'parcour[nom]' => 'Testing',
            'parcour[description]' => 'Testing',
            'parcour[lieuDeDepart]' => 'Testing',
            'parcour[lieu_d_arrivee]' => 'Testing',
            'parcour[heure_de_depart]' => 'Testing',
            'parcour[heure_d_arrivee]' => 'Testing',
        ]);

        self::assertResponseRedirects('/parcours/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Parcours();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLieuDeDepart('My Title');
        $fixture->setLieu_d_arrivee('My Title');
        $fixture->setHeure_de_depart('My Title');
        $fixture->setHeure_d_arrivee('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Parcour');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Parcours();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLieuDeDepart('My Title');
        $fixture->setLieu_d_arrivee('My Title');
        $fixture->setHeure_de_depart('My Title');
        $fixture->setHeure_d_arrivee('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'parcour[nom]' => 'Something New',
            'parcour[description]' => 'Something New',
            'parcour[lieuDeDepart]' => 'Something New',
            'parcour[lieu_d_arrivee]' => 'Something New',
            'parcour[heure_de_depart]' => 'Something New',
            'parcour[heure_d_arrivee]' => 'Something New',
        ]);

        self::assertResponseRedirects('/parcours/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getLieuDeDepart());
        self::assertSame('Something New', $fixture[0]->getLieu_d_arrivee());
        self::assertSame('Something New', $fixture[0]->getHeure_de_depart());
        self::assertSame('Something New', $fixture[0]->getHeure_d_arrivee());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Parcours();
        $fixture->setNom('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLieuDeDepart('My Title');
        $fixture->setLieu_d_arrivee('My Title');
        $fixture->setHeure_de_depart('My Title');
        $fixture->setHeure_d_arrivee('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/parcours/');
    }
}
