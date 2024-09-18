<?php
namespace App\Controller\Core;

use App\Entity\Dr;
use App\Entity\Perimeter;
use App\Form\Core\FormErrorFormatter;
use App\Repository\NationalRepository;
use App\Repository\PerimeterRepository;
use App\Service\Perimeter\PerimeterHierarchy;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class  ApiController extends AbstractController
{
    protected const METHOD_GET    = 'GET';
    protected const METHOD_POST   = 'POST';
    protected const METHOD_PUT    = 'PUT';
    protected const METHOD_DELETE = 'DELETE';
    protected const METHOD_PATCH  = 'PATCH';

    /**
     * @var PerimeterRepository
     */
    private $perimeterRepository;

    /**
     * @var NationalRepository
     */
    private $nationalRepository;

    /**
     * @var TokenStorageInterface
     */
    private $token;

    /**
     * @var PerimeterHierarchy
     */
    private $perimeterHierarchy;

    /**
     * ApiController constructor.
     *
     * @param PerimeterRepository   $perimeterRepository
     * @param NationalRepository    $nationalRepository
     * @param TokenStorageInterface $token
     * @param PerimeterHierarchy    $perimeterHierarchy
     */
    public function __construct(
        PerimeterRepository $perimeterRepository,
        NationalRepository $nationalRepository,
        TokenStorageInterface $token,
        PerimeterHierarchy $perimeterHierarchy
    ) {
        $this->perimeterRepository = $perimeterRepository;
        $this->nationalRepository  = $nationalRepository;
        $this->token               = $token;
        $this->perimeterHierarchy  = $perimeterHierarchy;
    }

    /**
     * @param Request $request
     *
     * @return Dr[]
     */
    public function getAllowedDrs(Request $request): array
    {
        $perimeterHeader = $request->headers->get('perimeter');

        if ($perimeterHeader !== null) {
            $perimeterHeader = $this->perimeterRepository->findOneOr404(['code' => $perimeterHeader]);
        }

        /** @var Dr[] $allowedDrs */
        // @var $user User
        /** @noinspection NullPointerExceptionInspection */
        $user       = $this->token->getToken()->getUser();
        $national   = current($this->nationalRepository->findAll());
        $allowedDrs = [];

        if ($perimeterHeader instanceof Dr || $user->getNativePerimeter() !== $national) {
            foreach ($user->getPerimeters() as $perimeter) {
                /** @var Perimeter $p */
                foreach ($this->perimeterHierarchy->getChildrenPerimeters($perimeter) as $p) {
                    if ($p instanceof Dr) {
                        if ($perimeterHeader->getId() !== $p->getId()) {
                            continue;
                        }

                        $allowedDrs[$p->getId()] = $p;
                    }
                }
            }
        }

        return $allowedDrs;
    }

    /**
     * @param Request       $request
     * @param FormInterface $form
     * @param string        $method
     * @param array         $decodeFields
     */
    protected function processFormAction(Request $request, FormInterface $form, string $method = 'POST', array $decodeFields = []): void
    {
        if ($method === self::METHOD_GET) {
            $data = $request->query->all();
        } else {
            $data = $request->request->all();
        }

        foreach ($decodeFields as $decodeField) {
            if (isset($data[$decodeField])) {
                if (is_array($data[$decodeField])) {
                    $data[$decodeField] = array_map('urldecode', $data[$decodeField]);
                } else {
                    $data[$decodeField] = urldecode($data[$decodeField]);
                }
            }
        }

        /** Permet de contrer le fonctionnement des formulaires transformant le bool false en null */
        $data = array_map(static function ($field) {
            if ($field === false) {
                return 'false';
            }

            if ($field === 0) {
                return '0';
            }

            return $field;
        }, $data);

        $form->submit($data);
    }

    /**
     * @param FormInterface      $form
     * @param FormErrorFormatter $formErrorFormatter
     *
     * @return ApiController|bool|View
     */
    protected function checkForm(FormInterface $form, FormErrorFormatter $formErrorFormatter)
    {
        if (!$form->isSubmitted() || !$form->isValid()) {
            $errors = $formErrorFormatter::getErrors($form);
            $data   = [
                'code'    => '400',
                'message' => 'formValidationError',
                'errors'  => $errors,
            ];

            return View::create($data, 400);
        }

        return true;
    }
}
