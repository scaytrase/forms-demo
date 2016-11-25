<?php

namespace ScayTrase\Demo\Forms\Controller;

use Doctrine\ORM\EntityManager;
use ScayTrase\Demo\Forms\Entity\Editable;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EntityController
 *
 * @package ScayTrase\Demo\Forms\Controller
 * @Route("/entity/{alias}")
 */
class EntityController extends Controller
{
    /**
     * @Route("/{entity}/edit", name="entity_edit")
     * @Template()
     *
     * @param string $alias
     * @param string $entity
     *
     * @return array|Response
     */
    public function editAction(Request $request, $alias, $entity)
    {
        $manager  = $this->getDoctrine()->getManager();
        $obj      = $manager->find($alias, $entity);
        $metadata = $manager->getClassMetadata($alias);
        if (!$obj instanceof Editable) {
            throw new \LogicException('Entity "' . $alias . '" is not editable');
        }

        $form = $this->createForm($obj->getFormClass(), $obj, ['data_class' => $metadata->getName()]);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->flush();

            return $this->redirectToRoute('entity_list', ['alias' => $alias]);
        }

        return ['form' => $form->createView(), 'entity' => $obj, 'alias' => $alias];
    }

    /**
     * @Route("/create", name="entity_create")
     * @Template()
     *
     * @param string $alias
     *
     * @return array|Response
     */
    public function createAction(Request $request, $alias)
    {
        /** @var EntityManager $manager */
        $manager  = $this->getDoctrine()->getManager();
        $metadata = $manager->getClassMetadata($alias);

        $refl  = $metadata->getReflectionClass();
        $class = $metadata->getName();
        if (!$refl->implementsInterface(Editable::class)) {
            throw new \LogicException('Entity "' . $alias . '" is not editable');
        }

        $obj = $class::create();

        $form = $this->createForm($obj->getFormClass(), $obj, ['data_class' => $metadata->getName()]);
        $form->add('submit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $manager->persist($obj);
            $manager->flush();

            return $this->redirectToRoute('entity_list', ['alias' => $alias]);
        }

        return ['form' => $form->createView(), 'entity' => $obj, 'alias' => $alias];
    }

    /**
     * @Route(
     *     "/list.{_format}",
     *     name="entity_list",
     *     defaults={"_format": "html"},
     *     requirements={
     *          "_format":"html|json"
     *      }
     *     )
     * @Template()
     *
     * @param string $alias
     *
     * @return array|Response
     */
    public function listAction($alias)
    {
        $entities = $this->getDoctrine()->getManager()->getRepository($alias)->findAll();

        return [
            'alias'    => $alias,
            'entities' => $entities,
        ];
    }
}
