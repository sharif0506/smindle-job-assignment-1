<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessSubscriptionOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $item;

    /**
     * Create a new job instance.
     */
    public function __construct(array $item)
    {
        $this->item = $item;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //initiate the payload
        $payload = [
            'ProductName' => $this->item['name'],
            'Price' => $this->item['price'],
            'Timestamp' => now()->toDateTimeString(),
        ];

        //send the subscription order
        try {
            $response = Http::post('https://very-slow-api.com/orders', $payload);

            if ($response->failed()) {
                Log::error('Failed to send subscription order', [
                    'item' => $this->item,
                    'response' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending subscription order', [
                'item' => $this->item,
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
