<?php

namespace App\Http\Livewire\Job;

use App\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class AllJobsTable extends Component
{
    use WithPagination;

    public string $tab    = 'all';
    public string $search = '';

    public bool   $showSlideout = false;
    public ?array $selected     = null;

    protected $queryString = ['tab', 'search'];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingTab(): void    { $this->resetPage(); $this->closeSlideout(); }

    public function show(string $source, $id): void
    {
        $this->selected    = $this->loadDetail($source, (int) $id);
        $this->showSlideout = true;
    }

    public function closeSlideout(): void
    {
        $this->showSlideout = false;
        $this->selected     = null;
    }

    public function retryFailed(int $id): void
    {
        Artisan::call('queue:retry ' . $id);
        DB::table('failed_jobs')->where('id', $id)->delete();
        $this->closeSlideout();
        session()->flash('success', 'Job has been re-queued successfully.');
    }

    public function deleteFailed(int $id): void
    {
        DB::table('failed_jobs')->where('id', $id)->delete();
        $this->closeSlideout();
        session()->flash('success', 'Job deleted.');
    }

    public function render()
    {
        return view('livewire.job.all-jobs-table', [
            'jobs'   => $this->buildJobList(),
            'counts' => $this->buildCounts(),
        ]);
    }

    // -------------------------------------------------------------------------
    // Query builders
    // -------------------------------------------------------------------------

    protected function buildJobList()
    {
        $perPage = 25;
        $search  = $this->search;

        if ($this->tab === 'pending') {
            return \App\Jobs::orderBy('id', 'desc')
                ->paginate($perPage)
                ->through(fn ($j) => $this->normalizePending($j));
        }

        if ($this->tab === 'failed') {
            $q = DB::table('failed_jobs')->orderBy('failed_at', 'desc');
            if ($search) {
                $q->where('queue', 'like', "%{$search}%");
            }
            return $q->paginate($perPage)->through(fn ($j) => $this->normalizeFailed($j));
        }

        if ($this->tab === 'history') {
            $q = DB::table('queue_monitor')->orderBy('started_at', 'desc');
            if ($search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('queue', 'like', "%{$search}%");
                });
            }
            return $q->paginate($perPage)->through(fn ($j) => $this->normalizeMonitor($j));
        }

        // 'all' tab — merge all three sources
        $failed  = DB::table('failed_jobs')->orderBy('failed_at', 'desc')->limit(100)->get()
                     ->map(fn ($j) => $this->normalizeFailed($j));

        $monitor = DB::table('queue_monitor')->orderBy('started_at', 'desc')->limit(100)->get()
                     ->map(fn ($j) => $this->normalizeMonitor($j));

        $pending = \App\Jobs::orderBy('id', 'desc')->limit(50)->get()
                     ->map(fn ($j) => $this->normalizePending($j));

        $all = $failed->merge($monitor)->merge($pending)
            ->when($search, fn ($c) => $c->filter(
                fn ($j) => str_contains(strtolower($j['name']), strtolower($search))
                        || str_contains(strtolower($j['queue']), strtolower($search))
            ))
            ->sortByDesc('sort_ts')
            ->values();

        $page = (int) (request()->get('page', 1) ?: 1);

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $all->forPage($page, $perPage)->values(),
            $all->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    protected function buildCounts(): array
    {
        return [
            'all'     => \App\Jobs::count() + DB::table('failed_jobs')->count() + DB::table('queue_monitor')->count(),
            'pending' => \App\Jobs::count(),
            'failed'  => DB::table('failed_jobs')->count(),
            'history' => DB::table('queue_monitor')->count(),
        ];
    }

    // -------------------------------------------------------------------------
    // Normalizers
    // -------------------------------------------------------------------------

    protected function normalizePending($job): array
    {
        $payload = json_decode($job->payload, true) ?? [];
        $command = $payload['data']['command'] ?? '';

        return [
            'source'            => 'pending',
            'id'                => $job->id,
            'name'              => class_basename($payload['displayName'] ?? 'Unknown'),
            'full_name'         => $payload['displayName'] ?? '',
            'uuid'              => $payload['uuid'] ?? '',
            'queue'             => $job->queue,
            'status'            => $job->reserved_at ? 'running' : 'waiting',
            'attempts'          => $job->attempts,
            'max_tries'         => $payload['maxTries'] ?? null,
            'backoff'           => $payload['backoff'] ?? null,
            'started_at'        => null,
            'elapsed'           => null,
            'exception'         => null,
            'exception_message' => null,
            'exception_class'   => null,
            'order_id'          => $this->extractOrderId($command),
            'sort_ts'           => $job->created_at,
            'created_at'        => \Carbon\Carbon::createFromTimestamp($job->created_at),
        ];
    }

    protected function normalizeFailed($job): array
    {
        $payload = json_decode($job->payload, true) ?? [];
        $command = $payload['data']['command'] ?? '';
        $lines   = explode("\n", $job->exception ?? '');
        $exMsg   = trim($lines[0] ?? '');

        return [
            'source'            => 'failed',
            'id'                => $job->id,
            'name'              => class_basename($payload['displayName'] ?? 'Unknown'),
            'full_name'         => $payload['displayName'] ?? '',
            'uuid'              => $payload['uuid'] ?? '',
            'queue'             => $job->queue,
            'status'            => 'failed',
            'attempts'          => 1,
            'max_tries'         => $payload['maxTries'] ?? null,
            'backoff'           => $payload['backoff'] ?? null,
            'started_at'        => null,
            'elapsed'           => null,
            'exception'         => $job->exception,
            'exception_message' => $exMsg,
            'exception_class'   => null,
            'order_id'          => $this->extractOrderId($command),
            'sort_ts'           => strtotime($job->failed_at),
            'created_at'        => \Carbon\Carbon::parse($job->failed_at),
        ];
    }

    protected function normalizeMonitor($job): array
    {
        if ($job->failed) {
            $status = 'failed';
        } elseif (is_null($job->finished_at)) {
            $status = 'running';
        } else {
            $status = 'completed';
        }

        return [
            'source'            => 'monitor',
            'id'                => $job->id,
            'name'              => class_basename($job->name ?? 'Unknown'),
            'full_name'         => $job->name ?? '',
            'uuid'              => $job->job_id ?? '',
            'queue'             => $job->queue ?? '',
            'status'            => $status,
            'attempts'          => $job->attempt,
            'max_tries'         => null,
            'backoff'           => null,
            'started_at'        => $job->started_at,
            'finished_at'       => $job->finished_at,
            'elapsed'           => $job->time_elapsed,
            'exception'         => null,
            'exception_message' => $job->exception_message,
            'exception_class'   => $job->exception_class,
            'order_id'          => null,
            'sort_ts'           => $job->started_at ? strtotime($job->started_at) : 0,
            'created_at'        => $job->started_at ? \Carbon\Carbon::parse($job->started_at) : null,
        ];
    }

    // -------------------------------------------------------------------------
    // Detail loader
    // -------------------------------------------------------------------------

    protected function loadDetail(string $source, int $id): array
    {
        if ($source === 'pending') {
            $job  = \App\Jobs::findOrFail($id);
            $data = $this->normalizePending($job);
        } elseif ($source === 'failed') {
            $job  = DB::table('failed_jobs')->where('id', $id)->first();
            if (! $job) abort(404);
            $data = $this->normalizeFailed($job);
        } else {
            $job = DB::table('queue_monitor')->where('id', $id)->first();
            if (! $job) abort(404);
            $data = $this->normalizeMonitor($job);
        }

        if ($data['order_id']) {
            $order = Order::with(['customer', 'status'])->find($data['order_id']);
            $data['order'] = $order ? [
                'id'           => $order->id,
                'details'      => $order->details,
                'status'       => optional($order->status)->name ?? 'Unknown',
                'status_id'    => $order->order_status_id,
                'company_name' => optional($order->customer)->company_name,
                'url'          => route('order.show', $order->id),
            ] : null;
        } else {
            $data['order'] = null;
        }

        return $data;
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    protected function extractOrderId(string $command): ?int
    {
        if (! $command || ! str_contains($command, 'App\Order')) {
            return null;
        }
        if (preg_match('/"App\\\\Order"[^}]*?"id";[a-z]:(\d+)/s', $command, $m)) {
            return (int) $m[1];
        }
        return null;
    }
}
