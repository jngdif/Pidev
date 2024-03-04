<?php

// src/Controller/SmsController.php

namespace App\Controller;

use App\Service\SmsGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmsController extends AbstractController
{
    //La vue du formulaire d'envoie du sms
    #[Route('/envoyer sms', name: 'app_sms')]
    public function index(): Response
    {
        return $this->render('sms/index.html.twig',['smsSent'=>false]);
    }

    //Gestion de l'envoie du sms
    #[Route('/sendSms', name: 'send_sms', methods:'POST')]
    public function sendSms(Request $request, SmsGenerator $smsGenerator): Response
    {
        $number = $request->request->get('number');
        
        // Définition des valeurs par défaut pour le nom de l'expéditeur et le texte du message
        $name = 'Notreatment';
        $text = 'Message de confirmation';

        $number_test = $_ENV['twilio_to_number']; // Numéro vérifié par Twilio. Un seul numéro autorisé pour la version de test.

        // Appel du service
        $smsGenerator->sendSms($number_test, $name, $text);

        return $this->render('sms/index.html.twig', ['smsSent' => true]);
    }
}