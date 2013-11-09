<?php

namespace MeetMe\ApptBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AppointmentController extends Controller
{
    /**
     * @Route("/", name="_appt")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
