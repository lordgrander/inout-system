<?php

namespace Tests\Unit;

use App\Services\Reports\VehicleDetailSelectionService;
use Illuminate\Support\Collection;
use ReflectionClass;
use Tests\TestCase;

class VehicleDetailSelectionServiceTest extends TestCase
{
    public function testTargetCountsDetailsAndCanRemoveWholeParents(): void
    {
        $rows = $this->exampleRows();
        $selectedIds = $this->selectDetailIds($rows, 4);
        $counts = $this->selectedCountsByEnter($rows, $selectedIds);

        $this->assertCount(4, $selectedIds);
        $this->assertSame(4, $counts->count());
        $this->assertSame(1, $counts->get(5));
        $this->assertSame(1, $counts->get(1));
        $this->assertSame(1, $counts->get(3));
        $this->assertSame(1, $counts->only([2, 4])->sum());
    }

    public function testTargetGivesEverySelectedParentOneThenAddsToSmallerGroupsFirst(): void
    {
        $rows = $this->exampleRows();
        $selectedIds = $this->selectDetailIds($rows, 6);
        $counts = $this->selectedCountsByEnter($rows, $selectedIds);

        $this->assertCount(6, $selectedIds);
        $this->assertSame(5, $counts->count());
        $this->assertSame(2, $counts->get(1));
        $this->assertSame(1, $counts->get(2));
        $this->assertSame(1, $counts->get(3));
        $this->assertSame(1, $counts->get(4));
        $this->assertSame(1, $counts->get(5));
    }

    private function selectDetailIds(Collection $rows, int $target): array
    {
        $reflection = new ReflectionClass(VehicleDetailSelectionService::class);
        $method = $reflection->getMethod('selectDetailIds');
        $method->setAccessible(true);

        return $method->invoke(new VehicleDetailSelectionService(), $rows, '2026-07-13', $target);
    }

    private function selectedCountsByEnter(Collection $rows, array $selectedIds): Collection
    {
        return $rows
            ->whereIn('enter_detail_id', $selectedIds)
            ->groupBy('enter_id')
            ->map(function (Collection $items) {
                return $items->count();
            });
    }

    private function exampleRows(): Collection
    {
        return collect([
            $this->row(1, 101),
            $this->row(1, 102),
            $this->row(2, 201),
            $this->row(2, 202),
            $this->row(2, 203),
            $this->row(2, 204),
            $this->row(2, 205),
            $this->row(3, 301),
            $this->row(3, 302),
            $this->row(3, 303),
            $this->row(3, 304),
            $this->row(4, 401),
            $this->row(4, 402),
            $this->row(4, 403),
            $this->row(4, 404),
            $this->row(4, 405),
            $this->row(5, 501),
        ]);
    }

    private function row(int $enterId, int $detailId): object
    {
        return (object) [
            'enter_id' => $enterId,
            'enter_detail_id' => $detailId,
            'com_id' => 10,
        ];
    }
}
