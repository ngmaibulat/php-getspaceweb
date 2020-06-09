<?php declare(strict_types=1);

namespace App\Domain\Service\GuestBook;

use Alksily\Entity\Collection;
use App\Domain\AbstractService;
use App\Domain\Entities\GuestBook;
use App\Domain\Repository\GuestBookRepository;
use App\Domain\Service\GuestBook\Exception\EntryNotFoundException;
use App\Domain\Service\GuestBook\Exception\MissingEmailValueException;
use App\Domain\Service\GuestBook\Exception\MissingMessageValueException;
use App\Domain\Service\GuestBook\Exception\MissingNameValueException;
use Ramsey\Uuid\Uuid;

class GuestBookService extends AbstractService
{
    /**
     * @var GuestBookRepository
     */
    protected $service;

    protected function init(): void
    {
        $this->service = $this->entityManager->getRepository(GuestBook::class);
    }

    /**
     * @param array $data
     *
     * @throws MissingNameValueException
     * @throws MissingEmailValueException
     * @throws MissingMessageValueException
     *
     * @return GuestBook
     */
    public function create(array $data = []): GuestBook
    {
        $default = [
            'name' => '',
            'email' => '',
            'message' => '',
            'response' => '',
            'status' => \App\Domain\Types\GuestBookStatusType::STATUS_MODERATE,
            'date' => 'now',
        ];
        $data = array_merge($default, $data);

        if (!$data['name']) {
            throw new MissingNameValueException();
        }
        if (!$data['email']) {
            throw new MissingEmailValueException();
        }
        if (!$data['message']) {
            throw new MissingMessageValueException();
        }

        $file = (new GuestBook)
            ->setName($data['name'])
            ->setEmail($data['email'])
            ->setMessage($data['message'])
            ->setResponse($data['response'])
            ->setStatus($data['status'])
            ->setDate($data['date']);

        $this->entityManager->persist($file);
        $this->entityManager->flush();

        return $file;
    }

    /**
     * @param array $data
     *
     * @throws EntryNotFoundException
     *
     * @return Collection|GuestBook
     */
    public function read(array $data = [])
    {
        $default = [
            'uuid' => '',
            'email' => '',
            'status' => '',
        ];
        $data = array_merge($default, static::$default_read, $data);

        if ($data['uuid']) {
            switch (true) {
                case $data['uuid']:
                    $entry = $this->service->findOneByUuid((string) $data['uuid']);

                    break;
            }

            if (empty($entry)) {
                throw new EntryNotFoundException();
            }

            return $entry;
        }

        $criteria = [];

        if ($data['email'] !== '') {
            $criteria['email'] = $data['email'];
        }
        if ($data['status'] !== '') {
            $criteria['status'] = $data['status'];
        }

        return collect($this->service->findBy($criteria, $data['order'], $data['limit'], $data['offset']));
    }

    /**
     * @param GuestBook|string|Uuid $entity
     * @param array            $data
     *
     * @throws EntryNotFoundException
     *
     * @return GuestBook
     */
    public function update($entity, array $data = []): GuestBook
    {
        switch (true) {
            case is_string($entity) && Uuid::isValid($entity):
            case is_object($entity) && is_a($entity, Uuid::class):
                $entity = $this->service->findOneByUuid((string) $entity);

                break;
        }

        if (is_object($entity) && is_a($entity, GuestBook::class)) {
            $default = [
                'name' => '',
                'email' => '',
                'message' => '',
                'response' => '',
                'status' => '',
                'date' => '',
            ];
            $data = array_merge($default, $data);

            if ($data !== $default) {
                if ($data['name']) {
                    $entity->setName($data['name']);
                }
                if ($data['email']) {
                    $entity->setEmail($data['email']);
                }
                if ($data['message']) {
                    $entity->setMessage($data['message']);
                }
                if ($data['response']) {
                    $entity->setResponse($data['response']);
                }
                if ($data['status']) {
                    $entity->setStatus($data['status']);
                }
                if ($data['date']) {
                    $entity->setDate($data['date']);
                }

                $this->entityManager->flush();
            }

            return $entity;
        }

        throw new EntryNotFoundException();
    }

    /**
     * @param GuestBook|string|Uuid $entity
     *
     * @throws EntryNotFoundException
     *
     * @return bool
     */
    public function delete($entity): bool
    {
        switch (true) {
            case is_string($entity) && Uuid::isValid($entity):
            case is_object($entity) && is_a($entity, Uuid::class):
                $entity = $this->service->findOneByUuid((string) $entity);

                break;
        }

        if (is_object($entity) && is_a($entity, GuestBook::class)) {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();

            return true;
        }

        throw new EntryNotFoundException();
    }
}
