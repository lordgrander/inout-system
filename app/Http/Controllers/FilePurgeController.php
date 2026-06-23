<?php
// app/Http/Controllers/FilePurgeController.php
namespace App\Http\Controllers;

use App\Models\beta_enter_file;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FilePurgeController extends Controller
{
    public function destroyByMonthYear(Request $request)
    {
        $year  = (int) $request->input('year', 2023);
        $month = (int) $request->input('month', 7);
        $disk  = $request->input('disk', 'my_files');
        $chunk = 500;

        $totalRows   = 0;
        $totalFiles  = 0;
        $failedFiles = 0;
        $dirsTouched = [];

        beta_enter_file::whereYear('date', $year)
            // ->whereMonth('date', $month)
            ->select('file_id', 'file_url')
            ->orderBy('file_id') // order by the same key you chunk on
            ->chunkById($chunk, function ($rows) use ($disk, &$totalRows, &$totalFiles, &$failedFiles, &$dirsTouched) {

                $file_idsToDelete = [];

                foreach ($rows as $row) {
                    $totalRows++;

                    $key = ltrim($row->file_url, '/');
                    $dir = Str::beforeLast($key, '/'); // ✅ simpler and works in all versions
                    if ($dir) $dirsTouched[$dir] = true;

                    try {
                        if ($key && Storage::disk($disk)->exists($key)) {
                            if (Storage::disk($disk)->delete($key)) {
                                $totalFiles++;
                            } else {
                                $failedFiles++;
                                Log::warning('File deletion returned false', [
                                    'file_id' => $row->file_id,
                                    'key' => $key,
                                    'disk' => $disk
                                ]);
                            }
                        }
                    } catch (\Throwable $e) {
                        $failedFiles++;
                        Log::warning('File deletion error', [
                            'file_id' => $row->file_id,
                            'key' => $key,
                            'disk' => $disk,
                            'error' => $e->getMessage(),
                        ]);
                    }

                    $file_idsToDelete[] = $row->file_id;
                }

                if ($file_idsToDelete) {
                    beta_enter_file::whereIn('file_id', $file_idsToDelete)->delete();
                }
            }, 'file_id'); // 👈 tell chunkById which column to use

        // Optional: cleanup empty directories
        foreach (array_keys($dirsTouched) as $dir) {
            $stillHasRows = beta_enter_file::where('file_url', 'like', $dir.'/%')->exists();
            if ($stillHasRows) continue;

            try {
                $filesLeft = Storage::disk($disk)->allFiles($dir);
                if (empty($filesLeft)) {
                    Storage::disk($disk)->deleteDirectory($dir);
                }
            } catch (\Throwable $e) {
                Log::info('Directory cleanup skipped', [
                    'dir' => $dir,
                    'disk' => $disk,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return response()->json([
            'ok'            => true,
            'message'       => "Purged files and rows for {$year}-{$month}.",
            'rows_seen'     => $totalRows,
            'files_deleted' => $totalFiles,
            'files_failed'  => $failedFiles,
            'disk'          => $disk,
        ]);
    }
}
