<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class WebsocketsServer extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ws:serve';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Start the websocket server.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
        $server = IoServer::factory(
            new WsServer(
                new WebsocketHandler()
            ),
            8080
        );

        $this->info('Running Websocket Server!');

        $server->run();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(

		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(

		);
	}

}