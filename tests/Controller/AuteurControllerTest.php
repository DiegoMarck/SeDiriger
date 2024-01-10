<?php

namespace App\Test\Controller;

use App\Entity\Auteur;
use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuteurControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private AuteurRepository $repository;
    private string $path = '/auteur/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Auteur::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Auteur index');

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
            'auteur[nom]' => 'Testing',
            'auteur[prenom]' => 'Testing',
            'auteur[entreprise]' => 'Testing',
            'auteur[dateDeNaissance]' => 'Testing',
            'auteur[article]' => 'Testing',
        ]);

        self::assertResponseRedirects('/auteur/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auteur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setEntreprise('My Title');
        $fixture->setDateDeNaissance('My Title');
        $fixture->setArticle('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Auteur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auteur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setEntreprise('My Title');
        $fixture->setDateDeNaissance('My Title');
        $fixture->setArticle('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'auteur[nom]' => 'Something New',
            'auteur[prenom]' => 'Something New',
            'auteur[entreprise]' => 'Something New',
            'auteur[dateDeNaissance]' => 'Something New',
            'auteur[article]' => 'Something New',
        ]);

        self::assertResponseRedirects('/auteur/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getEntreprise());
        self::assertSame('Something New', $fixture[0]->getDateDeNaissance());
        self::assertSame('Something New', $fixture[0]->getArticle());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Auteur();
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setEntreprise('My Title');
        $fixture->setDateDeNaissance('My Title');
        $fixture->setArticle('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/auteur/');
    }
}
