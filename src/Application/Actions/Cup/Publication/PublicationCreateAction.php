<?php declare(strict_types=1);

namespace App\Application\Actions\Cup\Publication;

use App\Domain\Service\Publication\Exception\AddressAlreadyExistsException;
use App\Domain\Service\Publication\Exception\MissingTitleValueException;
use App\Domain\Service\Publication\Exception\TitleAlreadyExistsException;

class PublicationCreateAction extends PublicationAction
{
    protected function action(): \Slim\Psr7\Response
    {
        if ($this->isPost()) {
            try {
                $publication = $this->publicationService->create([
                    'user' => $this->request->getAttribute('user'),
                    'title' => $this->getParam('title'),
                    'address' => $this->getParam('address'),
                    'date' => $this->getParam('date'),
                    'category' => $this->publicationCategoryService->read([
                        'uuid' => $this->getParam('category'),
                    ]),
                    'content' => $this->getParam('content'),
                    'poll' => $this->getParam('poll'),
                    'meta' => $this->getParam('meta'),
                    'external_id' => $this->getParam('external_id'),
                ]);
                $publication = $this->processEntityFiles($publication);

                $this->container->get(\App\Application\PubSub::class)->publish('cup:publication:create', $publication);

                switch (true) {
                    case $this->getParam('save', 'exit') === 'exit':
                        return $this->response->withAddedHeader('Location', '/cup/publication')->withStatus(301);

                    default:
                        return $this->response->withAddedHeader('Location', '/cup/publication/' . $publication->getUuid() . '/edit')->withStatus(301);
                }
            } catch (MissingTitleValueException|TitleAlreadyExistsException $e) {
                $this->addError('title', $e->getMessage());
            } catch (AddressAlreadyExistsException $e) {
                $this->addError('address', $e->getMessage());
            }
        }

        return $this->respondWithTemplate('cup/publication/form.twig', ['list' => $this->publicationCategoryService->read()]);
    }
}
