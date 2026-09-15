<?php

namespace App\Services\Reports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VehicleDetailSelectionService
{
    public function selectForDate(string $date, int $target): array
    {
        $rows = $this->loadRows($date);
        $selectedIds = $this->selectDetailIds($rows, $date, $target);
        $groups = $rows->groupBy('enter_id');
        $availableCount = $rows->count();
        $parentCount = $groups->count();

        if ($availableCount === 0) {
            return $this->result([], $target, $availableCount, $parentCount, 'Insufficient Data');
        }

        if ($availableCount < $target) {
            return $this->result($selectedIds, $target, $availableCount, $parentCount, 'Insufficient Data');
        }

        if ($availableCount === $target) {
            return $this->result($selectedIds, $target, $availableCount, $parentCount, 'Matched');
        }

        return $this->result(
            $selectedIds,
            $target,
            $availableCount,
            $parentCount,
            count($selectedIds) === $target ? 'Matched' : 'Mismatch'
        );
    }

    private function selectDetailIds(Collection $rows, string $date, int $target): array
    {
        if ($target <= 0) {
            return [];
        }

        $availableCount = $rows->count();

        if ($availableCount <= $target) {
            return $rows->pluck('enter_detail_id')->map(function ($id) {
                return (int) $id;
            })->values()->all();
        }

        $orderedGroups = $this->orderedParentGroups($rows, $date);
        $parentLimit = min($target, $orderedGroups->count());
        $selectedGroups = $orderedGroups->take($parentLimit);
        $selectedIds = [];

        foreach ($selectedGroups as $group) {
            $firstDetail = $this->sortedDetails($group, $date)->first();

            if ($firstDetail) {
                $selectedIds[] = (int) $firstDetail->enter_detail_id;
            }
        }

        $remaining = $target - count($selectedIds);

        if ($remaining > 0) {
            foreach ($selectedGroups as $group) {
                $details = $this->sortedDetails($group, $date)->slice(1);

                foreach ($details as $detail) {
                    if ($remaining <= 0) {
                        break 2;
                    }

                    $selectedIds[] = (int) $detail->enter_detail_id;
                    $remaining--;
                }
            }
        }

        sort($selectedIds);

        return $selectedIds;
    }

    private function orderedParentGroups(Collection $rows, string $date): Collection
    {
        return $rows
            ->groupBy('enter_id')
            ->sortBy(function (Collection $group) use ($date) {
                $first = $group->first();

                return sprintf(
                    '%010d|%s',
                    $group->count(),
                    $this->stableScore($date, $first->enter_id, 0, $first->com_id)
                );
            })
            ->values();
    }

    private function loadRows(string $date): Collection
    {
        return DB::table('beta_enter as e')
            ->join('beta_enter_detail as ed', 'ed.enter_id', '=', 'e.enter_id')
            ->leftJoin('beta_company_group as c', 'c.com_id', '=', 'e.com_id')
            ->leftJoin('beta_t_type as t', 't.t_type_id', '=', 'ed.t_model')
            ->where('e.status', 'SUCCESS')
            ->whereDate('e.date_make', $date)
            ->select([
                'e.enter_id',
                'e.enter_number',
                'e.com_id',
                'e.date_make',
                'c.com_name',
                'ed.enter_detail_id',
                'ed.plate_number',
                'ed.p_import',
                'ed.weight',
                'ed.t_model',
                't.t_type_name',
            ])
            ->orderBy('e.date_make')
            ->orderBy('e.enter_id')
            ->orderBy('ed.enter_detail_id')
            ->get();
    }

    private function sortedDetails(Collection $group, string $date): Collection
    {
        return $group->sortBy(function ($detail) use ($date) {
            return $this->stableScore($date, $detail->enter_id, $detail->enter_detail_id, $detail->com_id);
        })->values();
    }

    private function stableScore(string $date, $enterId, $detailId, $companyId): string
    {
        return hash('sha256', implode('|', [
            $date,
            (string) $companyId,
            (string) $enterId,
            (string) $detailId,
        ]));
    }

    private function result(array $selectedIds, int $target, int $availableCount, int $parentCount, string $status): array
    {
        $selectedCount = count($selectedIds);

        return [
            'selected_ids' => $selectedIds,
            'target' => $target,
            'available_count' => $availableCount,
            'parent_count' => $parentCount,
            'min_possible' => $parentCount,
            'selected_count' => $selectedCount,
            'shortage' => max(0, $target - $selectedCount),
            'difference' => $selectedCount - $target,
            'status' => $status,
        ];
    }
}
