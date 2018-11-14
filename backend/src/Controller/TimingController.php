<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Timing;
use App\Request\Timing\AddTimingRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TimingController.
 *
 * @Route("/api/timing")
 */
class TimingController extends ApiController
{
    /**
     * todo: Добавить связь Timing с User.
     *
     * @return JsonResponse
     *
     * @Route(name="api_timing_index", methods={"GET"})
     */
    public function index()
    {
        $items = $this->getDoctrine()->getRepository(Timing::class)->findBy([], [
            'startedAt' => 'desc',
        ]);

        return $this->apiResponse($items, ['frontend']);
    }

    /**
     * @param AddTimingRequest $request
     *
     * @return JsonResponse
     *
     * @Route(name="api_timing_add_timing", methods={"POST"})
     */
    public function add(AddTimingRequest $request)
    {
        $task = $this->getDoctrine()->getRepository(Task::class)->find($request->taskId);

        $timing = new Timing();
        $timing->setTask($task);
        $timing->setStartedAt(new \DateTime('@'.$request->startedAt));
        $timing->setEndedAt(new \DateTime('@'.$request->endedAt));

        $em = $this->getDoctrine()->getManager();

        $em->persist($timing);

        $em->flush();

        return $this->apiResponse($timing, ['frontend'], Response::HTTP_CREATED);
    }
}
