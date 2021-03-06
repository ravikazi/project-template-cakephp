<?php
namespace App\Event\Controller\Api;

use App\Event\EventName;
use Cake\Datasource\QueryInterface;
use Cake\Datasource\ResultSetInterface;
use Cake\Event\Event;
use Cake\Utility\Hash;

class IndexActionListener extends BaseActionListener
{
    /**
     * Returns a list of all events that the API Index endpoint will listen to.
     *
     * @return array
     */
    public function implementedEvents() : array
    {
        return [
            (string)EventName::API_INDEX_BEFORE_PAGINATE() => 'beforePaginate',
            (string)EventName::API_INDEX_AFTER_PAGINATE() => 'afterPaginate',
            (string)EventName::API_INDEX_BEFORE_RENDER() => 'beforeRender'
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function beforePaginate(Event $event, QueryInterface $query) : void
    {
        /** @var \Cake\Controller\Controller */
        $controller = $event->getSubject();

        /** @var \Psr\Http\Message\ServerRequestInterface&\Cake\Http\ServerRequest */
        $request = $controller->getRequest();

        /** @var \Cake\Datasource\RepositoryInterface&\Cake\ORM\Table */
        $table = $controller->loadModel();

        $this->filterByConditions($query, $event);

        $query->order($this->getOrderClause($request, $table));
    }

    /**
     * {@inheritDoc}
     */
    public function afterPaginate(Event $event, ResultSetInterface $resultSet) : void
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function beforeRender(Event $event, ResultSetInterface $resultSet) : void
    {
        if ($resultSet->isEmpty()) {
            return;
        }

        /** @var \Cake\Controller\Controller */
        $controller = $event->getSubject();

        /** @var \Psr\Http\Message\ServerRequestInterface&\Cake\Http\ServerRequest */
        $request = $controller->getRequest();

        /** @var \Cake\Datasource\RepositoryInterface&\Cake\ORM\Table */
        $table = $controller->loadModel();

        foreach ($resultSet as $entity) {
            $this->resourceToString($entity);

            static::FORMAT_PRETTY === $request->getQuery('format') ?
                $this->prettify($entity, $table) :
                $this->attachFiles($entity, $table);

            if ((bool)$request->getQuery(static::FLAG_INCLUDE_MENUS)) {
                $this->attachMenu($entity, $table, $controller->Auth->user());
            }
        }
    }

    /**
     * Method that filters ORM records by provided conditions.
     *
     * @param \Cake\Datasource\QueryInterface $query Query object
     * @param \Cake\Event\Event $event The event
     * @return void
     */
    private function filterByConditions(QueryInterface $query, Event $event) : void
    {
        /** @var \Cake\Controller\Controller */
        $controller = $event->getSubject();

        /** @var \Psr\Http\Message\ServerRequestInterface&\Cake\Http\ServerRequest */
        $request = $controller->getRequest();

        /** @var \Cake\Datasource\RepositoryInterface&\Cake\ORM\Table */
        $table = $controller->loadModel();

        $queryParam = Hash::get($request->getQueryParams(), 'conditions', []);
        if (empty($queryParam)) {
            return;
        }

        $conditions = [];
        foreach ($queryParam as $field => $value) {
            $conditions[$table->aliasField($field)] = $value;
        };

        $query->applyOptions(['conditions' => $conditions]);
    }
}
