<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Salle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Form\Type\SalleType;

class SalleController extends AbstractController
{
    public function accueil(Session $session)
    {
        if ($session->has('nbreFois')) {
            $session->set('nbreFois', $session->get('nbreFois') + 1);
        } else
            $session->set('nbreFois', 1);
        return $this->render(
            'salle/accueil.html.twig',
            array('nbreFois' => $session->get('nbreFois'))
        );
    }
    public function afficher($numero)
    {
        return $this->render(
            'salle/afficher.html.twig',
            array('numero' => $numero)
        );
    }

    public function treize()
    {
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(1);
        $salle->setNumero(13);
        return $this->render(
            'salle/treize.html.twig',
            array('salle' => $salle)
        );
    }
    public function quatorze()
    {
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(1);
        $salle->setNumero(14);
        return $this->render(
            'salle/quatorze.html.twig',
            array('designation' => $salle->__toString())
        );
        //ou seulement $salle
    }
    public function voir($id)
    {
        $salle = $this->getDoctrine()->getRepository(Salle::class)->find($id);
        if (!$salle)
            throw $this->createNotFoundException('Salle[id=' . $id . '] inexistante');
        return $this->render(
            'salle/voir.html.twig',
            array('salle' => $salle)
        );
    }
    public function ajouter($batiment, $etage, $numero)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $salle = new Salle;
        $salle->setBatiment($batiment);
        $salle->setEtage($etage);
        $salle->setNumero($numero);
        $entityManager->persist($salle);
        $entityManager->flush();
        return $this->redirectToRoute(
            'salle_tp_voir',
            array('id' => $salle->getId())
        );
    }
    public function ajouter2(Request $request)
    {
        $salle = new Salle;
        $form = $this->createForm(
            SalleType::class,
            $salle,
            ['action' => $this->generateUrl('salle_tp_ajouter2')]
        );
        $form->add('submit', SubmitType::class, array('label' => 'Ajouter'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salle);
            $entityManager->flush();
            return $this->redirectToRoute(
                'salle_tp_voir',
                array('id' => $salle->getId())
            );
        }
        return $this->render(
            'salle/ajouter2.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }
    public function navigation()
    {
        $salles = $this->getDoctrine()
            ->getRepository(Salle::class)->findAll();
        return $this->render(
            'salle/navigation.html.twig',
            array('salles' => $salles)
        );
    }
    public function modifier($id)
    {
        $salle = $this->getDoctrine()->getRepository(Salle::class)->find($id);
        if (!$salle)
            throw $this->createNotFoundException('Salle[id=' . $id . '] inexistante');
        $form = $this->createForm(
            SalleType::class,
            $salle,
            [
                'action' => $this->generateUrl(
                    'salle_tp_modifier_suite',
                    array('id' => $salle->getId())
                )
            ]
        );
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        return $this->render(
            'salle/modifier.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }
    public function modifierSuite(Request $request, $id)
    {
        $salle = $this->getDoctrine()->getRepository(Salle::class)->find($id);
        if (!$salle)
            throw $this->createNotFoundException('Salle[id=' . $id . '] inexistante');
        $form = $this->createForm(
            SalleType::class,
            $salle,
            [
                'action' => $this->generateUrl(
                    'salle_tp_modifier_suite',
                    array('id' => $salle->getId())
                )
            ]
        );
        $form->add('submit', SubmitType::class, array('label' => 'Modifier'));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($salle);
            $entityManager->flush();
            $url = $this->generateUrl(
                'salle_tp_voir',
                array('id' => $salle->getId())
            );
            return $this->redirect($url);
        }
        return $this->render(
            'salle/modifier.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }
    // public function dix()
    // {
    //     return $this->redirectToRoute('salle_tp_afficher', array('numero' => 10));
    // }
}