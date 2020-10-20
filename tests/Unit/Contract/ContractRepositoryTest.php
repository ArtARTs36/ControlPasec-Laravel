<?php

namespace Tests\Unit\Contract;

use App\Bundles\Contract\Repositories\ContractRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group NewTest
 */
final class ContractRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Bundles\Contract\Repositories\ContractRepository::findByCustomer
     */
    public function testFindByCustomer(): void
    {
        $repo = $this->make();

        //

        self::assertTrue($repo->findByCustomer(1)->isEmpty());
    }

    private function make(): ContractRepository
    {
        return new ContractRepository();
    }
}
