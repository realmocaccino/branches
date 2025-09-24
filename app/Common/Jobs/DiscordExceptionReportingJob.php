<?php
namespace App\Common\Jobs;

use App\Common\Clients\CurlClient;
use App\Common\DTOs\DiscordMessageDto;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};

use Exception;

class DiscordExceptionReportingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    private $client;
    private $data;

    private $code;
    private $file;
    private $line;
    private $message;
    private $trace;

    public function __construct(Exception $exception)
    {
        $this->code = $exception->getCode();
        $this->file = $exception->getFile();
        $this->line = $exception->getLine();
        $this->message = $exception->getMessage();
        $this->trace = $exception->getTraceAsString();
    }

    public function handle(CurlClient $client, DiscordMessageDto $data)
    {
        if($this->isLocal()) return null;
        
        $this->client = $client;
        $this->data = $data;

        $this->client->post(
            $url = config('discord.webhooks.exception_reporting'),
            $data = $this->getData(),
            $headers = [
                'Content-type: application/json'
            ]
        );
    }

    private function getData()
    {
        $this->data->setTitle($this->message);
        $this->data->setDescription($this->trace);
        $this->data->setFields([
            [
                'name' => 'Arquivo',
                'value' => $this->getRelativePath($this->file),
                'inline' => true
            ],
            [
                'name' => 'Linha',
                'value' => $this->line,
                'inline' => true
            ]
        ]);

        return json_encode($this->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function getRelativePath($path)
    {
        return str_replace(base_path() . '/', '', $path);
    }

    private function isLocal()
    {
        return app()->isLocal();
    }
}