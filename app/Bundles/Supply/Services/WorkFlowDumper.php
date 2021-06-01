<?php

namespace App\Bundles\Supply\Services;

use App\Bundles\Supply\Repositories\SupplyStatusRepository;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRuleRepository;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Graphp\GraphViz\GraphViz;

class WorkFlowDumper
{
    protected $statuses;

    protected $transitionsRules;

    protected $graphViz;

    public function __construct(
        SupplyStatusRepository $statuses,
        SupplyStatusTransitionRuleRepository $transitionsRules,
        GraphViz $graphViz
    ) {
        $this->statuses = $statuses;
        $this->transitionsRules = $transitionsRules;
        $this->graphViz = $graphViz;
    }

    public function dump(): string
    {
        $statuses = $this->statuses->all();
        $rules = $this->transitionsRules->all();

        /** @var array<int, Vertex> $vertexes */
        $vertexes = [];
        $graph = new Graph();

        //

        foreach ($statuses as $status) {
            $vertexes[$status->id] = $graph->createVertex($status->title);
        }

        foreach ($rules as $rule) {
            $vertexes[$rule->from_status_id]->createEdgeTo($vertexes[$rule->to_status_id]);
        }

        //

        return $this->graphViz->createImageFile($graph);
    }
}
