<?php

namespace App\Bundles\Contragent\Observers;

use App\Bundles\Contragent\Models\Contragent;

class ContragentObserver
{
    public function creating(Contragent $contragent): void
    {
        $this->applyTitleForDocument($contragent);
    }

    public function saving(Contragent $contragent): void
    {
        $this->applyTitleForDocument($contragent);
    }

    public function updating(Contragent $contragent): void
    {
        $this->applyTitleForDocument($contragent);
    }

    protected function applyTitleForDocument(Contragent $contragent): void
    {
        if (! $contragent->title_for_document) {
            $contragent->title_for_document = $contragent->title;
        }
    }
}
