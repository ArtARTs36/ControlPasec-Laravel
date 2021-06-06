<?php

namespace App\Bundles\Supply\Services;

use App\Bundles\Supply\Repositories\SupplyStatusRepository;
use App\Bundles\Supply\Repositories\SupplyStatusTransitionRuleRepository;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Graphp\GraphViz\GraphViz;
use Illuminate\Support\Str;

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
            $vertexes[$status->id]->setAttribute('graphviz.fontname', 'Calibri');
        }

        foreach ($rules as $rule) {
            $process = $graph->createVertex($rule->title, true);
            $process->setAttribute('graphviz.shape', 'record');
            $process->setAttribute('graphviz.style', 'filled');
            $process->setAttribute('graphviz.fontname', 'Calibri');

            if ($rule === $rules->first()) {
                $process->setAttribute('graphviz.fillcolor', '#afd8e5');
                $process->setAttribute('graphviz.color', '#50595b');
            }

            if ($rule->from_status_id === null) {
                $process->createEdgeTo($vertexes[$rule->to_status_id]);
            } else {
                $vertexes[$rule->from_status_id]->createEdgeTo($process);

                $this->createEdgeWhenMissing($process, $vertexes[$rule->to_status_id]);
            }
        }

        //

        return $this->graphViz->createImageFile($graph);
    }

    protected function createEdgeWhenMissing(Vertex $root, Vertex $vertex)
    {
        if (! $root->hasEdgeTo($vertex)) {
            $root->createEdgeTo($vertex);
        }
    }
}
