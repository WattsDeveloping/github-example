<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\RepoData;
use GuzzleHttp\Client;

class SearchController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Instantiate a new SearchController instance.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * getSearchResults
     * @param Request $searchRequest
     * @return Application|Factory|View
     *
     * Function used to get the users profile information
     * @throws GuzzleException
     */
    public function getSearchResults(Request $searchRequest)
    {
            $resUser = $this->client->request('GET', 'https://api.github.com/users/' . $searchRequest->searchTerm);
            $userInfo = json_decode($resUser->getBody()->getContents());

            if ($userInfo) {
                $username = $userInfo->login;
                $html_url = $userInfo->html_url;
                $avatar_url = $userInfo->avatar_url;
                $user_id = $userInfo->id;

                $resStarred = $this->client->request('GET', 'https://api.github.com/users/' . $searchRequest->searchTerm . '/starred');
                $results = json_decode($resStarred->getBody()->getContents());

                if (!$results) {
                    return view('pages.results-empty');
                }

                foreach ($results as $result) {
                    $duplicationCheck = RepoData::where('id',$result->id)->first();
                    if ($duplicationCheck){
                        $duplicationCheck->id = $result->id;
                        $duplicationCheck->user_id = $user_id;
                        $duplicationCheck->name = $result->name;
                        $duplicationCheck->description = $result->description;
                        $duplicationCheck->stargazers_count = $result->stargazers_count;
                        $duplicationCheck->html_url = $result->html_url;
                        $duplicationCheck->save();
                    } else {
                        $repoData = new RepoData();
                        $repoData->id = $result->id;
                        $repoData->user_id = $user_id;
                        $repoData->name = $result->name;
                        $repoData->description = $result->description;
                        $repoData->stargazers_count = $result->stargazers_count;
                        $repoData->html_url = $result->html_url;
                        $repoData->save();
                    }
                }

                $results = RepoData::where('user_id', $user_id)->orderBy('stargazers_count', 'desc')->take(5)->get();

            } else {
                return view('pages.results-empty');
            }

        return view('pages.results', compact('results', 'username', 'html_url', 'avatar_url'));
    }

}
