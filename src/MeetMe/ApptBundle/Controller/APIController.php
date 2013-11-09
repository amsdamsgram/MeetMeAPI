<?php

namespace MeetMe\ApptBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View AS FOSView;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class APIController extends Controller
{
    CONST FORMAT = 'json';

    /**
     * GET /appointments
     * Get all the appointments
     *
     * @return FOSView
     */
    public function getAppointmentsAction(){
        $view = FOSView::create();
        $view->setFormat(APIController::FORMAT);
        $data = $this->getDoctrine()->getRepository('MeetMeApptBundle:Appointment')->findAll();
        $view->setStatusCode(200)->setData($data);
        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * GET /appointments/id
     * Get an appointment by id
     *
     * @param integer $id appointment id
     * @return FOSView
     */
    public function getAppointmentAction($id){
        $view = FOSView::create();
        $view->setFormat(APIController::FORMAT);
        $data = $this->getDoctrine()->getRepository('MeetMeApptBundle:Appointment')->findOneBy(array('id' => $id));
        if($data)
            $view->setStatusCode(200)->setData($data);
        else
            $view->setStatusCode(404);
        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * POST /appointments
     * Create a new appointment
     *
     * TODO: Handle errors
     *
     * @param ParamFetcher $paramFetcher
     *
     * @RequestParam(name="title", default="New Appointment", description="Title")
     * @RequestParam(name="start_time", default="", description="Start Time")
     * @RequestParam(name="end_time", default="", description="End Time")
     * @RequestParam(name="name", nullable=true, default="", description="Name")
     * @RequestParam(name="description", nullable=true, default="", description="Description")
     *
     * @return FOSView
     */
    public function postAppointmentsAction(ParamFetcher $paramFetcher){
        $view = FOSView::create();
        $view->setFormat(APIController::FORMAT);

        $appt = $this->getDoctrine()->getRepository('MeetMeApptBundle:Appointment')
            ->createUpdateAppointment($paramFetcher->get('title'),
                                    $paramFetcher->get('start_time'),
                                    $paramFetcher->get('end_time'),
                                    $paramFetcher->get('name'),
                                    $paramFetcher->get('description'));
        if($appt)
            $view->setStatusCode(200)->setData($appt);
        else
            $view->setStatusCode(500);
        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * PUT /appointments/id
     * Update an appointment
     *
     * @param integer $id appointment id
     * @return FOSView
     */
    public function putAppointmentsAction($id){
        $view = FOSView::create();
        $view->setFormat(APIController::FORMAT);
        $request = $this->getRequest();
        $name = $request->get('name')?$request->get('name'):null;
        $description = $request->get('description')?$request->get('description'):null;

        $appt = $this->getDoctrine()->getRepository('MeetMeApptBundle:Appointment')
            ->createUpdateAppointment($request->get('title'),
                                    $request->get('start_time'),
                                    $request->get('end_time'),
                                    $name,
                                    $description,
                                    $id);
        if($appt)
            $view->setStatusCode(200)->setData($appt);
        else
            $view->setStatusCode(500);
        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * DELETE /appointments/id
     * Remove an appointment
     * @param integer $id appointment id
     * @return bool
     */
    public function deleteAppointmentsAction($id){
        $view = FOSView::create();
        $view->setFormat(APIController::FORMAT);
        $data = $this->getDoctrine()->getRepository('MeetMeApptBundle:Appointment')->removeAppointmentById($id);
        if($data)
            $view->setStatusCode(200)->setData($data);
        else
            $view->setStatusCode(404);
        return $this->get('fos_rest.view_handler')->handle($view);
    }
}
