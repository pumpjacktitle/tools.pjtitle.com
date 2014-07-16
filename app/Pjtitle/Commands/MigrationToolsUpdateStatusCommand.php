<?php namespace Pjtitle\Commands;

use App;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpFoundation\FileBag;

class MigrationToolsUpdateStatusCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'migration_tools:status_update_utility';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Updates the legacy prime migration status.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

        $this->prime = App::make('\PjtitleData\VcConnector\Repositories\PrimeRepository');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
    {
        $primes = $this->prime->createModel()
            ->has('migrationStatus', '=', 0)
            ->take($this->option('take'))
            ->with('priorReferences')
            ->with('migrationStatus')
            ->get();

        $totalPrimes = count($primes);

        if ($totalPrimes <= 0)
        {
            exit;
        }

        foreach ($primes as $prime)
        {
            $statusUpdate = [
                'has_been_migrated'        => 0,
                'missing_prior_references' => 0
            ];

            $apiInput = ['oldCwlId' => $prime->old_cwl_id];

            $results = $service = (new \PjtitleData\SearchApi\Api\Services\AlfrescoSearchService($apiInput))->getResults();

            if ( count($results) >= 2 )
            {
                $statusUpdate['has_duplicates'] = 1;
            }

            if ( ! empty($results[0]) )
            {
                $statusUpdate['has_been_migrated'] = 1;
                $results = $results[0];

                $statusUpdate['date_migrated'] = (new \Carbon\Carbon("2013-10-15T23:14:51+0000"))->toDateTimeString();

                $shouldHavePriorReferences = ! empty($prime->getPriorReferencesArray());
                $migratedHasPriorReferences = ! empty($results['cwlvcda:priorReference']);

                if ( $shouldHavePriorReferences == true and $migratedHasPriorReferences == false )
                {
                    $statusUpdate['missing_prior_references'] = 0;
                }
            }

            $status = new \PjtitleData\VcConnector\Models\MigrationStatus($statusUpdate);

            $prime->migrationStatus()->save($status);
        }

        $finishTime = Carbon::now()->toDateTimeString();
        $filePath = base_path() . "/logs/statusUpdateCron.txt";

        File::append($filePath, "\n{$totalPrimes} were updated at {$finishTime}");

	}

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('take', null, InputOption::VALUE_OPTIONAL, 'Number to take', null),
        );
    }
}
