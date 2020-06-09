<?php declare(strict_types=1);

namespace App\Application\Actions\Cup\GuestBook;

use App\Domain\Service\GuestBook\GuestBookService;

class GuestBookDeleteAction extends GuestBookAction
{
    protected function action(): \Slim\Http\Response
    {
        if ($this->resolveArg('uuid') && \Ramsey\Uuid\Uuid::isValid($this->resolveArg('uuid'))) {
            $guestBookService = GuestBookService::getWithContainer($this->container);
            $guestBookService->delete($this->resolveArg('uuid'));
        }

        return $this->response->withRedirect('/cup/guestbook');
    }
}
