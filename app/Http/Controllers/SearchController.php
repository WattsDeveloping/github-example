<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\RepoData;

class SearchController extends Controller
{

    /**
     * getSearchResults
     * @param Request $searchRequest
     * @return Application|Factory|View
     *
     * Function used to get the users profile information
     */
    public function getSearchResults(Request $searchRequest)
    {
        try {

            // curl request to get the users profile information
            $curl_url_user = 'https://api.github.com/users/' . $searchRequest->searchTerm;
            $curl_user = curl_init($curl_url_user);
            curl_setopt_array($curl_user, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_USERAGENT => env('GITHUB_USERNAME')));
            $output = curl_exec($curl_user);
            curl_close($curl_user);
            $userInfo = json_decode($output);

            // If we have found a user then we can get there starred repos
            if ($userInfo) {
                $username = $userInfo->login;
                $html_url = $userInfo->html_url;
                $avatar_url = $userInfo->avatar_url;
                $user_id = $userInfo->id;
                // curl request to handle getting the users most starred repos
                // IMPORTANT: this will get your own and what you have starred
                $curl_url = 'https://api.github.com/users/' . $searchRequest->searchTerm . '/starred';
                $curl = curl_init($curl_url);
                curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_USERAGENT => env('GITHUB_USERNAME')));
                $output = curl_exec($curl);
                curl_close($curl);
                $results = json_decode($output);

                if (!$results) {
                    return view('pages.results-empty');
                }

                /**
                 * Here we are adding to the database
                 * If a duplicate is found we replace it with fresh data
                 * This is used so we can use a model easily enough to get top 5 most starred
                 */
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

                //top 5 results based of the stargazers count
                $results = RepoData::where('user_id', $user_id)->orderBy('stargazers_count', 'desc')->take(5)->get();

            } else {
                return view('pages.results-empty');
            }
        } catch (\Exception $e) {
            // If I had more time I would put in error handling for curl
            dd($e);
        }
        // Return the view with the results found
        return view('pages.results', compact('results', 'username', 'html_url', 'avatar_url'));
    }

}
