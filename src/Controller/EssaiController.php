<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Salle;
use App\Entity\Ordinateur;
use App\Entity\Logiciel;

class EssaiController extends AbstractController
{
    #[Route('/essai', name: 'app_essai')]
    public function index(): Response
    {
        return $this->render('essai/index.html.twig', [
            'controller_name' => 'EssaiController',
        ]);
    }
    public function test1()
    {
        $salleA = new Salle;
        $salleA->setBatiment('D');
        $salleA->setEtage(7);
        $salleA->setNumero(70);
        $this->getDoctrine()->getManager()->persist($salleA);
        $result = 'persist salleA: ' . $salleA . ' id :' . $salleA->getId() . '<br />';
        $salleB = new Salle;
        $salleB->setBatiment('D');
        $salleB->setEtage(7);
        $salleB->setNumero(69);
        $result .= 'salleB ... ' . $salleB . ' id :' . $salleB->getId() . '<br />';
        $this->getDoctrine()->getManager()->flush();
        $result .= 'flush –-- id salleA:' . $salleA->getId()
            . ' id salleB:' . $salleB->getId() . '<br />';
        $salle2A = $this->getDoctrine()->getRepository(Salle::class)
            ->find($salleA->getId());
        if ($salle2A !== null)
            $result .= 'find(' . $salleA->getId() . ') ' . $salle2A . '<br />';
        return new Response('<html><body>' . $result . '</body></html>');
    }
    public function test2()
    {
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(73);
        $em->persist($salle);
        $salle->setNumero($salle->getNumero() + 1);
        $em->flush();
        $salle2 = $this->getDoctrine()->getRepository(Salle::class)
            ->find($salle->getId());
        return new
            Response('<html><body>' . $salle2 . '</body></html>');
    }
    public function test3()
    {
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(75);
        $em->persist($salle);
        $result = 'persist ' . $salle . '<br />';
        $em->flush();
        $id = $salle->getId();
        $result .= 'flush id:' . $id . ' --- contains:' . $em->contains($salle)
            . '<br />';
        $em->clear();
        $result .= 'clear --- contains:' . $em->contains($salle) . '<br />';
        $repo = $em->getRepository(Salle::class);
        $salle = $repo->find($id);
        $result .= 'find(' . $id . ') --- contains(cette salle):'
            . $em->contains($salle) . '<br />';
        return new Response('<html><body>' . $result . '</body></html>');
    }
    public function test4()
    {
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(75);
        $em->persist($salle);
        $result = 'persist ' . $salle . '<br />';
        $em->flush();
        $id = $salle->getId();
        $result .= 'flush id de la salle:' . $id . '<br /> contains salle:'
            . $em->contains($salle) . '<br />';
        $em->detach($salle);
        $result .= 'detach salle ---> contains:' . $em->contains($salle) . '<br />';
        $salle = $this->getDoctrine()->getRepository(Salle::class)->find($id);
        $result .= 'find(' . $id . ') --- contains(cette salle):'
            . $em->contains($salle) . '<br />';
        return new Response('<html><body>' . $result . '</body></html>');
    }
    public function test5()
    {
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(76);
        $em->persist($salle);
        $result = 'persist ' . $salle . '<br />';
        $em->flush();
        $id = $salle->getId();
        $result .= 'flush ----- id:' . $id . '<br />';
        $repo = $this->getDoctrine()->getRepository(Salle::class);
        $salle = $repo->find($id);
        $result .= 'find(' . $id . ') --- salle:' . $salle . '<br />';
        $em->remove($salle);
        $em->flush();
        $result .= 'remove salle puis flush<br />' . 'find(' . $id . ')='
            . $repo->find($id) . '<br />' . 'contains(salle):' . $em->contains($salle);
        return new Response("<html><body>$result</body></html>");
    }
    public function test6() {
        $repo = $this->getDoctrine()->getRepository(Salle::class);
        $salle = $repo->find(1);
        dump($salle);
        return new Response('<html><body></body></html>');
        }
    public function test7() {
        $repo = $this->getDoctrine()->getManager()->getRepository(Salle::class);
        $salles = $repo->findAll();
        dump($salles);
        return new Response('<html><body></body></html>');
    }
    public function test8() {
        $repo = $this->getDoctrine()->getManager()->getRepository(Salle::class);
        $salles = $repo->findBy(array('etage'=>1),
        array('numero'=>'asc'), 2, 1);
        dump($salles);
        return new Response('<html><body></body></html>');
    }
    public function test9() {
        $repo = $this->getDoctrine()->getManager()
        ->getRepository(Salle::class);
        $salle = $repo->findOneBy(array('etage'=>1));
        dump($salle);
        return new Response('<html><body></body></html>');
    }
    public function test10() {
        $repo = $this->getDoctrine()->getManager()
        ->getRepository(Salle::class);
        $salles = $repo->findByBatiment('B');
        dump($salles);
        return new Response('<html><body></body></html>');
    }
    public function test11() {
        $repo = $this->getDoctrine()->getManager()
        ->getRepository(Salle::class);
        $salle = $repo->findOneByEtage(1);
        dump($salle);
        return new Response('<html><body></body></html>');
    }
    public function test12() {
        $repo = $this->getDoctrine()->getManager()->getRepository(Salle::class);
        $salles = $repo->findByBatimentAndEtageMax('D', 7);
        dump($salles);
        return new Response('<html><body></body></html>');
    }
    public function test13() {
        $repo = $this->getDoctrine()->getManager()->getRepository(Salle::class);
        $salles = $repo->findSalleBatAouB();
        dump($salles);
        return new Response('<html><body></body></html>');
    }
    public function test14() {
        $repo = $this->getDoctrine()->getManager()->getRepository(Salle::class);
        $result = $repo->plusUnEtage();
        return new Response('<html><body><a href="http://localhost/phpmyadmin">
        voir phpmyadmin</a></body></html>');
    }
    public function test16(){
        $repo = $this->getDoctrine()->getManager()->getRepository(Salle::class);
        $result = $repo->testGetResult();
        dump($result);
        return new Response('<html><body></body></html>');
    }
    public function test19() {
        $repo = $this->getDoctrine()->getManager()->getRepository(Salle::class);
        $result = $repo->testGetSingleScalarResult();
        dump($result);
        return new Response('<html><body></body></html>');
    }
    public function test23() {
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle;
        $salle->setBatiment('b'); // minuscule !
        $salle->setEtage(3);
        $salle->setNumero(63);
        $em->persist($salle);
        $em->flush();
        return $this->redirectToRoute('salle_tp_voir',
        array('id' => $salle->getId()));
        }
    public function test25() {
        $em = $this->getDoctrine()->getManager();
        $salle = $em->getRepository(Salle::class)->findOneBy(array('batiment'=>'D',
        'etage'=>1, 'numero'=>15));
        $ordi = new Ordinateur;
        $ordi->setNumero(702);
        $ordi->setIp('192.168.7.04');
        $ordi->setSalle($salle);
        $em->persist($ordi);
        $em->flush();
        dump($ordi);
        return new Response('<html><body></body></html>');
        }
    public function test26() {
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle;
        $salle->setBatiment('B');
        $salle->setEtage(0);
        $salle->setNumero(0);
        $ordi = new Ordinateur;
        $ordi->setNumero(701);
        $ordi->setIp('192.168.7.01');
        $ordi->setSalle($salle);
        $em->persist($ordi);
        $em->persist($salle);
        $em->flush();
        dump($ordi);
        return new Response('<html><body></body></html>');
        }
    public function test27() {
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle;
        $salle->setBatiment('B');
        $salle->setEtage(0);
        $salle->setNumero(1);
        $ordi = new Ordinateur;
        $ordi->setNumero(703);
        $ordi->setIp('192.168.7.05');
        $ordi->setSalle($salle);
        $em->persist($ordi);
        $em->flush();
        dump($ordi);
        return new Response('<html><body></body></html>');
        }
    public function test28() {
        $ordi = $this->getDoctrine()->getManager()
        ->getRepository(Ordinateur::class)
        ->findOneByNumero(703);
        dump($ordi);
        $batiment = $ordi->getSalle()->getBatiment();
        dump($batiment);
        dump($ordi);
        return new Response('<html><body></body></html>');
    }
    public function test29() {
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur;
        $ordi->setNumero(803);
        $ordi->setIp('192.168.8.03');
        $salle = new Salle ;
        $salle->setBatiment('D');
        $salle->setEtage(8);
        $salle->setNumero(03);
        $salle->addOrdinateur($ordi);
        $em->persist($ordi);
        $em->flush();
        $ordi = $salle = null;
        $ordi = $this->getDoctrine()->getManager()
        ->getRepository(Ordinateur::class)->findOneByNumero(803);
        dump($ordi);
        return new Response('<html><body></body></html>');
        }
    public function test30() {
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur;
        $ordi->setNumero(804);
        $ordi->setIp('192.168.8.04');
        $em->persist($ordi);
        $salle = new Salle ;
        $salle->setBatiment('D');
        $salle->setEtage(8);
        $salle->setNumero(8);
        $salle->addOrdinateur($ordi);
        $em->persist($salle);
        $em->flush();
        dump($ordi);
        return new Response('<html><body></body></html>');
        }
    public function test32() {
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur;
        $ordi->setNumero(805);
        $ordi->setIp('192.168.8.05');
        $em->persist($ordi);
        $salle = new Salle ;
        $salle->setBatiment('D');
        $salle->setEtage(8);
        $salle->setNumero(85);
        $salle->addOrdinateur($ordi);
        $em->persist($salle);
        $ordi2 = new Ordinateur;
        $ordi2->setNumero(806);
        $ordi2->setIp('192.168.8.06');
        $em->persist($ordi2);
        $salle->addOrdinateur($ordi2);
        $em->flush();
        $id = $salle->getId();
        $em->clear();
        $salleTrouve = $em->getRepository(Salle::class)->find($id);
        $result = "";
        foreach($salleTrouve ->getOrdinateurs() as $ordi)
        $result .= $ordi->getIp().' ';
        $ordinateurs = $salleTrouve->getOrdinateurs();
        dump($ordinateurs);
        return new Response('<html><body>'.$result.'</body></html>');
        }
    public function test33() {
        $em = $this->getDoctrine()
        ->getManager();
        $ordi = new Ordinateur;
        $ordi->setNumero(807);
        $ordi->setIp('192.168.8.07');
        $em->persist($ordi);
        $salle = new Salle ;
        $salle->setBatiment('D');
        $salle->setEtage(8);
        $salle->setNumero(87);
        $ordi->setSalle($salle);
        $em->persist($salle);
        $em->flush();
        dump($ordi);
        $ordi->setSalle(null);
        $em->flush();
        $ordi = $this->getDoctrine()->getManager()
        ->getRepository(Ordinateur::class)
        ->findOneByNumero(807);
        dump($ordi);
        return new Response('<html><body></body></html>');
    }
    public function test35() {
        $em = $this->getDoctrine()
        ->getManager();
        $ordi = new Ordinateur;
        $ordi->setNumero(808);
        $ordi->setIp('192.168.8.08');
        $em->persist($ordi);
        $salle = new Salle ;
        $salle->setBatiment('D');
        $salle->setEtage(8);
        $salle->setNumero(88);
        $ordi->setSalle($salle);
        $em->persist($salle);
        $em->flush();
        dump($ordi);
        $em->remove($ordi);
        $em->flush();
        return new Response('<html><body>'.$salle.'</body></html>');
        }
    public function test36() {
        $em = $this->getDoctrine()
        ->getManager();
        $salle = new Salle ;
        $salle->setBatiment('D');
        $salle->setEtage(9);
        $salle->setNumero(01);
        $ordi = new Ordinateur;
        $ordi->setNumero(901);
        $ordi->setIp('192.168.9.01');
        $em->persist($ordi);
        $ordi->setSalle($salle);
        $em->flush();
        dump($ordi);
        $em->remove($salle);
        $em->flush();
        return new Response('<html><body></body></html>');
        }
    public function test38() {
        $em = $this->getDoctrine()->getManager();
        $salle = new Salle ;
        $salle->setBatiment('D');
        $salle->setEtage(9);
        $salle->setNumero(04);
        $em->persist($salle);
        $ordi1 = new Ordinateur;
        $ordi1->setNumero(904);
        $ordi1->setIp('192.168.9.04');
        $em->persist($ordi1);
        $ordi1->setSalle($salle);
        $ordi2 = new Ordinateur;
        $ordi2->setNumero(905);
        $ordi2->setIp('192.168.9.05');
        $em->persist($ordi2);
        $ordi2->setSalle($salle);
        $em->flush();
        $idSalle = $salle->getId();
        $em->flush();
        dump($salle);
        $em->remove($salle);
        $em->flush();
        return new Response('<html><body>rechercher la salle D-9.04 puis
        les ordis 904 et 905 avec PhpMyAdmin</body></html>');
        }
    public function test39() {
        $entityManager = $this->getDoctrine()->getManager();
        $ordi1 = new Ordinateur;
        $ordi1->setNumero(1000);
        $ordi1->setIp('192.168.10.00');
        $salle = $entityManager->getRepository(Salle::class)
        ->findOneByBatiment('D');
        $ordi1->setSalle($salle);
        $ordi2 = new Ordinateur;
        $ordi2->setNumero(1001);
        $ordi2->setIp('192.168.10.01');
        $ordi2->setSalle($salle);
        $logicielF = new Logiciel ;
        $logicielF->setNom('Firefox');
        $entityManager->persist($logicielF);
        $logicielG = new Logiciel ;
        $logicielG->setNom('Gimp2.2');
        $entityManager->persist($logicielG);
        $logicielF->addMachineInstallee($ordi1);
        $logicielG->addMachineInstallee($ordi1);
        $logicielF->addMachineInstallee($ordi2);
        $ordi2->addLogicielInstalle($logicielG);
        $entityManager->flush();
        return new Response('<html><body></body></html>');
        }
        public function test40() {
            $em = $this->getDoctrine()->getManager();
            $repo = $em->getRepository(Logiciel::class);
            $logiciel = $repo->findOneByNom('Firefox');
            $result="";
            foreach ($logiciel->getMachineInstallees() as $ordi)
            $result.=" - ".$ordi->getIp();
            return new Response('<html><body>'.$result.'</body></html>');
            }
    public function test43() {
        $em = $this->getDoctrine()->getManager();
        $ordi = $em->getRepository(Ordinateur::class)
        ->findOneByIp('192.168.10.00');
        $em->remove($ordi);
        $em->flush();
        $repo = $em->getRepository(Logiciel::class);
        $logiciel = $repo->findOneByNom('Firefox');
        $result="";
        foreach ($logiciel->getMachineInstallees() as $ordi)
        $result.=" - ".$ordi->getIp();
        return new Response('<html><body>'.$result.'</body></html>');
        }
    public function test41() {
        $em = $this->getDoctrine()->getManager();
        $ordi = new Ordinateur;
        $ordi->setNumero(1000);
        $ordi->setIp('192.168.10.00');
        $repo = $em->getRepository(Logiciel::class);
        $ordi->addLogicielInstalle($repo->findOneByNom('Firefox'));
        $ordi->addLogicielInstalle($repo->findOneByNom('Gimp2.2'));
        $em->persist($ordi);
        $em->flush();
        $logiciels = $repo->findByOrdinateur('192.168.10.00');
        $result = ' ';
        foreach ($logiciels as $logiciel)
        $result .= $logiciel->getNom().' ';
        return new Response('<html><body>'.$result.'</body></html>');
        }
    public function test42() {
        $em = $this->getDoctrine()->getManager();
        $logicielC = new Logiciel ;
        $logicielC->setNom('Apache');
        $em->persist($logicielC);
        $em->flush();
        $repom = $em->getRepository(Logiciel::class);
        $logicielOrdis = $repom->getLogicielsEtEventuellementOrdinateurs();
        $result = ' ';
        foreach ($logicielOrdis as $logicielOrdi)
        $result .= $logicielOrdi['nom'].' : '.$logicielOrdi['ip'].'<br />';
        return new Response('<html><body>'.$result.'</body></html>');
        }
}
