<?php namespace Pjtitle\Controllers;

use BaseController;
use Illuminate\Support\Facades\Response;
use View;
use PjtitleData\VcConnector\Repositories\PrimeRepository;

class StatusUpdateUtilityController extends BaseController {

    /**
     * Class Constructor
     *
     * @param PrimeRepository $prime
     */
    public function __construct(PrimeRepository $prime)
    {
        $this->prime = $prime;
    }

    /**
     * Index View
     *
     * @return View
     */
    public function index()
    {
        return View::make('status/index');
    }

    public function execute()
    {
        $primes = $this->prime->createModel()
            ->has('migrationStatus', '=', 0)
            ->take(100)
            ->with('priorReferences')
            ->with('migrationStatus')
            ->get();

        if (count($primes) <= 0)
        {
            return Response::make("Congratulations! We've finished.", 404);
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

        return Response::make('Success', 200);
    }
}