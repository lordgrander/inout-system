<?php

namespace App\Http\Controllers;

use App\Models\beta_enter;
use App\Models\beta_enter_road_detail;
use App\Models\beta_feed_back;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CoreTestingController extends Controller
{
    public function index(Request $request, string $scope = 'success')
    {
        $this->ensureTestingAccess();
        
        return view('test.coreWork', $this->buildWorkspaceData($scope, trim((string) $request->query('search', ''))));
    }

    public function accept(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        $check = DB::select('SELECT * FROM beta_enter WHERE enter_id = ?', [$request->id]);
        if (!$check) {
            return response()->json(['status' => 404, 'message' => 'Not found'], 404);
        }

        if ($check[0]->status === 'WAITING') {
            if ($check[0]->date_sign) {
                beta_enter::where('enter_id', $request->id)->update([
                    'status' => 'POINTING',
                ]);
            } else {
                $year = date('Y');
                $latestRecord = DB::select('SELECT * FROM beta_enter WHERE YEAR(date_make) = ? ORDER BY enter_number DESC LIMIT 1', [$year]);

                if ($latestRecord) {
                    $latestNumber = (int) $latestRecord[0]->enter_number;
                    $latestNumber++;
                    $latestNumber = str_pad((string) $latestNumber, 5, '0', STR_PAD_LEFT);
                } else {
                    $latestNumber = '00001';
                }

                beta_enter::where('enter_id', $request->id)->update([
                    'status' => 'POINTING',
                    'enter_number' => $latestNumber,
                ]);
            }

            $this->writeFeedback($request->id, 'ສົ່ງເອກະສານໄປລະບຸປາຍທາງ');
        }

        return $this->workflowOk($request->id);
    }

    public function sendCompany(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate([
            'id' => 'required|integer',
            'take' => 'nullable|string|max:255',
        ]);

        beta_enter::where('enter_id', $request->id)->update([
            'status' => 'SUCCESS',
            'take' => $request->take,
        ]);

        $this->writeFeedback($request->id, 'ສົ່ງເອກະສານໃຫ້ບໍລິສັດສຳເລັດ');

        return $this->workflowOk($request->id);
    }

    public function back(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        $checkData = DB::select('SELECT * FROM beta_enter WHERE enter_id = ?', [$request->id]);
        if (!$checkData) {
            return response()->json(['status' => 404, 'message' => 'Not found'], 404);
        }

        if ($checkData[0]->date_sign) {
            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'WAITING',
            ]);
        } else {
            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'WAITING',
                'enter_number' => '0',
            ]);
        }

        $this->writeFeedback($request->id, 'ດຶງຄືນເອກະສານກັບຈາກການລະບຸເສັ້ນທາງ');

        return $this->workflowOk($request->id);
    }

    public function backBossSign(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        $checkData = DB::select('SELECT * FROM beta_enter WHERE enter_id = ?', [$request->id]);
        if (!$checkData) {
            return response()->json(['status' => 404, 'message' => 'Not found'], 404);
        }

        if ($checkData[0]->date_sign) {
            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'SIGNING',
            ]);
        } else {
            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'SIGNING',
                'sign_url' => '',
                'date_sign' => null,
                'date_confirm' => null,
            ]);
        }

        $this->writeFeedback($request->id, 'ຍົກເລີກເຊັນ');

        return $this->workflowOk($request->id);
    }

    public function backToSign(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        $checkData = DB::select('SELECT * FROM beta_enter WHERE enter_id = ?', [$request->id]);
        if (!$checkData) {
            return response()->json(['status' => 404, 'message' => 'Not found'], 404);
        }

        if ($checkData[0]->date_sign) {
            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'SIGNING',
                'mark' => '0',
            ]);
        } else {
            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'SIGNING',
                'sign_url' => '',
                'date_sign' => null,
                'date_confirm' => null,
                'mark' => '0',
            ]);
        }

        $this->writeFeedback($request->id, 'ຕີກັບໄປເຊັນ');

        return $this->workflowOk($request->id);
    }

    public function pointing(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate([
            'id' => 'required|integer',
            'main_road' => 'required|integer',
            'formdata' => 'required|array|min:1',
            'formdata.*' => 'integer',
            'details' => 'nullable|string|max:255',
        ]);

        beta_enter_road_detail::where('enter_id', $request->id)->delete();

        foreach ($request->formdata as $roadId) {
            $checkData = DB::select(
                'SELECT * FROM beta_enter_road_detail WHERE enter_id = ? AND road_id = ?',
                [$request->id, $roadId]
            );

            if (!$checkData) {
                $roadDetail = new beta_enter_road_detail();
                $roadDetail->road_id = $roadId;
                $roadDetail->enter_id = $request->id;
                $roadDetail->save();
            }
        }

        beta_enter::where('enter_id', $request->id)->update([
            'status' => 'SIGNING',
            'feed_back_msg' => $request->details,
            'main_road_id' => $request->main_road,
        ]);

        $this->writeFeedback($request->id, 'ລະບຸເສັ້ນທາງສຳເລັດ ກຳລັງລໍຖ້າເຊັນ');

        return $this->workflowOk($request->id);
    }

    public function backPointing(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate([
            'id' => 'required|integer',
            'log' => 'required|string|max:255',
        ]);

        $checkData = DB::select('SELECT * FROM beta_enter WHERE enter_id = ?', [$request->id]);
        if (!$checkData) {
            return response()->json(['status' => 404, 'message' => 'Not found'], 404);
        }

        if ($checkData[0]->date_sign) {
            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'WAITING',
            ]);
        } else {
            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'WAITING',
                'enter_number' => '0',
            ]);
        }

        beta_enter_road_detail::where('enter_id', $request->id)->delete();

        $this->writeFeedback($request->id, 'ເອກະສານຕີກັບ : ສາເຫດທີ່ຕີກັບ "' . $request->log . '"');

        return $this->workflowOk($request->id);
    }

    public function backSigning(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        beta_enter::where('enter_id', $request->id)->update([
            'status' => 'POINTING',
        ]);

        $this->writeFeedback($request->id, 'ດຶງຄືນເອກະສານກັບຈາກການຢືນເຊັນ');

        return $this->workflowOk($request->id);
    }

    public function sign(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        $signUrl = DB::select('SELECT * FROM beta_sign WHERE user_id = ?', [Auth::id()]);
        $currentUser = DB::select('SELECT * FROM users WHERE id = ?', [Auth::id()]);
        $bossId = ($currentUser && $currentUser[0]->itn == '1') ? $currentUser[0]->id : 0;

        if (session('command') === 'off') {
            $defaultSign = null;
            if ((string) Auth::id() === '13') {
                $defaultSign = '/sign/13/default_sign.png';
            }

            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'SIGNINED',
                'sign_url' => $defaultSign,
                'boss_id' => $bossId,
                'date_sign' => Carbon::now('Asia/Bangkok'),
                'date_confirm' => Carbon::now('Asia/Bangkok'),
                'mark' => '0',
            ]);
        } else {
            beta_enter::where('enter_id', $request->id)->update([
                'status' => 'SIGNINED',
                'boss_id' => $bossId,
                'sign_url' => $signUrl[0]->sign_url ?? null,
                'date_confirm' => Carbon::now('Asia/Bangkok'),
                'date_sign' => Carbon::now('Asia/Bangkok'),
                'mark' => '0',
            ]);
        }

        $this->writeFeedback($request->id, 'ເຊັນແລ້ວ ເອກະສານຢູ່ນຳລະບຸສານທາງ');

        return $this->workflowOk($request->id);
    }

    public function backBoss(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate([
            'id' => 'required|integer',
            'log' => 'required|string|max:255',
        ]);

        beta_enter::where('enter_id', $request->id)->update([
            'status' => 'POINTING',
        ]);

        $this->writeFeedback($request->id, 'ເອກະສານຕີກັບ ຈາກການເຊັນ : ສາເຫດທີ່ຕີກັບ "' . $request->log . '"');

        return $this->workflowOk($request->id);
    }

    public function readyBack(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        beta_enter::where('enter_id', $request->id)->update([
            'status' => 'SIGNINED',
        ]);

        $this->writeFeedback($request->id, 'ຕີເອກະສານກັບໄປຫາສາຍທາງ ແຕ່ເຊັນແລ້ວ');

        return $this->workflowOk($request->id);
    }

    public function successBack(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        beta_enter::where('enter_id', $request->id)->update([
            'status' => 'READY',
        ]);

        $this->writeFeedback($request->id, 'ດຶງກັບເອກະສານຈາກບໍລິສັດ ແຕ່ເຊັນແລ້ວ');

        return $this->workflowOk($request->id);
    }

    public function cancel(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate([
            'id' => 'required|integer',
            'log' => 'required|string|max:255',
        ]);

        beta_enter::where('enter_id', $request->id)->update([
            'status' => 'CANCEL',
            'sign_url' => '',
            'cancel_log' => $request->log,
        ]);

        $this->writeFeedback($request->id, 'ຍົກເລີກ : ສາເຫດທີ່ຍົກເລີກ "' . $request->log . '"', 'CheckingEnter & Cancel');

        return $this->workflowOk($request->id);
    }

    public function reroll(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        beta_enter_road_detail::where('enter_id', $request->id)->delete();

        beta_enter::where('enter_id', $request->id)->update([
            'status' => 'WAITING',
            'main_road_id' => '0',
            'sign_url' => '',
        ]);

        $this->writeFeedback($request->id, 'ດຶງເອກະສານກັບຈາກຍົກເລີກ');

        return $this->workflowOk($request->id);
    }

    public function ready(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate(['id' => 'required|integer']);

        beta_enter::where('enter_id', $request->id)->update([
            'status' => 'READY',
        ]);

        $this->writeFeedback($request->id, 'ເຊັນແລ້ວ ລະບຸສາຍທາງສົ່ງໃຫ້ ຂາເຂົ້າຂາອອກ');

        return $this->workflowOk($request->id);
    }

    public function updatePaper(Request $request): JsonResponse
    {
        $this->ensureTestingAccess();
        $request->validate([
            'detail_id' => 'required|integer',
            'value' => 'required|in:yes,no',
        ]);

        $updated = DB::table('beta_enter_detail')
            ->where('enter_detail_id', $request->detail_id)
            ->update([
                'is_paper' => $request->value,
            ]);

        if (!$updated) {
            return response()->json([
                'status' => 404,
                'message' => 'Detail row not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'updated',
            'detail_id' => (int) $request->detail_id,
            'value' => $request->value,
        ]);
    }

    private function buildWorkspaceData(string $scope, string $search = ''): array
    {
        $scope = $this->normalizeScope($scope);

        $entriesQuery = DB::table('beta_enter as e')
            ->select('c.com_name', 'c.com_phone', 'u.name', 'u.email', 'e.*', 'm.main_road_name')
            ->leftJoin('beta_company_group as c', 'e.com_id', '=', 'c.com_id')
            ->leftJoin('users as u', 'e.user_id', '=', 'u.id')
            ->leftJoin('beta_main_road as m', 'e.main_road_id', '=', 'm.main_road_id');

        if ($scope === 'success') {
            $entriesQuery
                ->where('e.status', 'SUCCESS')
                ->whereDate('e.date_make', '>=', now()->subDays(30)->toDateString())
                ->whereDate('e.date_make', '<=', now()->toDateString())
                ->orderBy('e.enter_number', 'DESC');
        } elseif ($scope === 'cancel') {
            $entriesQuery
                ->where('e.status', 'CANCEL')
                ->orderBy('e.enter_id', 'DESC');
        } else {
            $entriesQuery
                ->whereNotIn('e.status', ['CANCEL', '', 'DRAFT', 'QWAIT', 'QSIGNING'])
                ->orderBy('e.enter_id', 'DESC');
        }

        if ($search !== '') {
            $entriesQuery->where(function ($query) use ($search) {
                $query->where('c.com_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('e.address', 'LIKE', '%' . $search . '%')
                    ->orWhere('e.district', 'LIKE', '%' . $search . '%')
                    ->orWhere('e.province', 'LIKE', '%' . $search . '%')
                    ->orWhere('e.enter_number', 'LIKE', '%' . $search . '%');
            });
        }

        $entries = $entriesQuery->paginate(50)->appends([
            'scope' => $scope,
            'search' => $search,
        ]);

        $entryIds = $entries->pluck('enter_id')->all();

        $detailsByEnterId = collect();
        $roadsByEnterId = collect();
        $filesByEnterId = collect();

        if (!empty($entryIds)) {
            $detailsByEnterId = DB::table('beta_enter_detail as ed')
                ->select('ed.*', 't.t_type_name')
                ->leftJoin('beta_t_type as t', 'ed.t_model', '=', 't.t_type_id')
                ->whereIn('ed.enter_id', $entryIds)
                ->orderBy('ed.enter_id')
                ->orderBy('ed.plate_number')
                ->get()
                ->groupBy('enter_id');

            $roadsByEnterId = DB::table('beta_enter_road_detail as r')
                ->select('r.*', 'rn.road_name')
                ->leftJoin('beta_road_select as rn', 'r.road_id', '=', 'rn.road_id')
                ->whereIn('r.enter_id', $entryIds)
                ->orderBy('r.enter_id')
                ->orderBy('r.road_id')
                ->get()
                ->groupBy('enter_id');

            $filesByEnterId = DB::table('beta_enter_file as f')
                ->whereIn('f.enter_id', $entryIds)
                ->orderBy('f.enter_id')
                ->orderBy('f.file_id')
                ->get()
                ->groupBy('enter_id');
        }

        return [
            'scope' => $scope,
            'search' => $search,
            'entries' => $entries,
            'detailsByEnterId' => $detailsByEnterId,
            'roadsByEnterId' => $roadsByEnterId,
            'filesByEnterId' => $filesByEnterId,
            'mainRoads' => DB::table('beta_main_road')->orderBy('main_road_name')->get(),
            'roadOptions' => DB::table('beta_road_select')->orderBy('road_name')->get(),
        ];
    }

    private function ensureTestingAccess(): void
    {
        $allowed = ['0', '2', '3', '4', '5'];
        abort_unless(in_array((string) Auth::user()->is_admin, $allowed, true), 403);
    }

    private function normalizeScope(string $scope): string
    {
        $scope = strtolower($scope);

        return in_array($scope, ['success', 'cancel', 'all'], true) ? $scope : 'success';
    }

    private function workflowOk(int $id): JsonResponse
    {
        return response()->json([
            'status' => 200,
            'message' => $id,
        ]);
    }

    private function writeFeedback(int $refId, string $message, string $pointer = 'CheckingEnter'): void
    {
        $feedback = new beta_feed_back();
        $feedback->user_id = Auth::id();
        $feedback->date = date('Y-m-d');
        $feedback->time = Carbon::now()->format('h:i:s');
        $feedback->feed_back_msg = $message;
        $feedback->ref_id = $refId;
        $feedback->pointer = $pointer;
        $feedback->save();
    }
}
