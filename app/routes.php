<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('status/index');
});

Route::get('tools/status-update-utility', 'Pjtitle\Controllers\StatusUpdateUtilityController@index');
Route::get('tools/status-update-utility/execute', 'Pjtitle\Controllers\StatusUpdateUtilityController@execute');
Route::get('tools/status-update-utility/logs', 'Pjtitle\Controllers\StatusUpdateUtilityController@logs');
Route::get('tools/status-update-utility/getLog', 'Pjtitle\Controllers\StatusUpdateUtilityController@getLog');


Route::get('search', function()
{
    $input = [
        'cwlId' => ['pNXUM+INSmyOwlFwFoyGbwdwdwdw']
    ];

    Input::merge($input);

    $service = new \PjtitleData\SearchApi\Api\Services\AlfrescoSearchService(Input::all());

    return $service->getResults();
});

Route::get('vcdata', function() {

    $primes = App::make('\PjtitleData\VcConnector\Repositories\PrimeRepository');

    $primes = $primes->createModel()
        ->has('migrationStatus', '=', 0)
        ->take(100)
        ->with('priorReferences')
        ->with('migrationStatus')
        ->get();

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
});