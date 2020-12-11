<?php

namespace App\Models\Document;

use App\Bundles\Employee\Models\Employee;
use App\Bundles\Supply\Models\OneTForm;
use App\Bundles\Supply\Models\ProductTransportWaybill;
use App\Bundles\Supply\Models\QualityCertificate;
use App\Bundles\Supply\Models\ScoreForPayment;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Trait HasEntities
 * @package App\Models\Document
 */
trait HasEntities
{
    use \App\Based\ModelSupport\HasEntities;

    /**
     * @return MorphToMany
     */
    public function qualityCertificates(): MorphToMany
    {
        return $this->morphEntities(QualityCertificate::class);
    }

    /**
     * @return MorphToMany
     */
    public function oneTForms(): MorphToMany
    {
        return $this->morphEntities(OneTForm::class);
    }

    /**
     * @return MorphToMany
     */
    public function productTransportWaybills(): MorphToMany
    {
        return $this->morphEntities(ProductTransportWaybill::class);
    }

    /**
     * @return MorphToMany
     */
    public function scoreForPayments(): MorphToMany
    {
        return $this->morphEntities(ScoreForPayment::class);
    }

    /**
     * @return MorphToMany
     */
    public function employees(): MorphToMany
    {
        return $this->morphEntities(Employee::class);
    }

    /**
     * @return MorphToMany
     */
    public function children(): MorphToMany
    {
        return $this->morphEntities(Document::class);
    }

    /**
     * @return QualityCertificate|null
     */
    public function getQualityCertificate(): ?QualityCertificate
    {
        return $this->qualityCertificates->first();
    }

    /**
     * @return OneTForm|null
     */
    public function getOneTForm(): ?OneTForm
    {
        return $this->oneTForms->first();
    }

    /**
     * @return ProductTransportWaybill|null
     */
    public function getProductTransportWaybill(): ?ProductTransportWaybill
    {
        return $this->productTransportWaybills->first();
    }

    /**
     * @return ScoreForPayment|null
     */
    public function getScoreForPayment(): ?ScoreForPayment
    {
        return $this->scoreForPayments->first();
    }
}
