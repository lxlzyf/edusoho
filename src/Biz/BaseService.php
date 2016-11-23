<?php

namespace Biz;

use Topxia\Service\User\CurrentUser;
use Codeages\Biz\Framework\Event\Event;
use Codeages\Biz\Framework\Dao\GeneralDaoInterface;
use Topxia\Common\Exception\ResourceNotFoundException;
use Codeages\Biz\Framework\Service\Exception\ServiceException;

class BaseService extends \Codeages\Biz\Framework\Service\BaseService
{
    /**
     * @param  $alias
     * @return GeneralDaoInterface
     */
    protected function createDao($alias)
    {
        return $this->biz->dao($alias);
    }

    /**
     * @return CurrentUser
     */
    protected function getCurrentUser()
    {
        return $this->biz['user'];
    }

    protected function getDispatcher()
    {
        return $this->biz['dispatcher'];
    }

    protected function dispatchEvent($eventName, $subject)
    {
        if ($subject instanceof Event) {
            $event = $subject;
        } else {
            $event = new Event($subject);
        }

        return $this->getDispatcher()->dispatch($eventName, $event);
    }

    protected function createResourceNotFoundService($resourceType, $resourceId)
    {
        return new ResourceNotFoundException($resourceType, $resourceId);
    }

    protected function createServiceException($message = '')
    {
        return new ServiceException($message);
    }
}
