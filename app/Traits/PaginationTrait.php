<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 04/08/19
 * Time: 10:08 ص
 */

namespace App\Traits;




trait PaginationTrait
{

    public function get_options($results , $filters = null)
    {

        $filters = $filters ? $filters : "";
        $data['current_page'] = $results->currentPage();
        $data['next_page_url'] = $results->nextPageUrl() ? $results->nextPageUrl()."".$filters:$results->nextPageUrl() ;
        $data['prev_page_url'] = $results->previousPageUrl() ? $results->previousPageUrl()."".$filters: $results->previousPageUrl();
        $data['first_page'] = $results->onFirstPage();
        $data['last_page'] = $results->lastPage();
        $data['count'] = $results->count();
        $data['per_page'] = $results->perPage();
        $data['total'] = $results->total();

        return $data;
    }


    public function get_options_v2($results , $filters = null)
    {

        $filters = $filters ? $filters : "";
        $data['pagination'] = $results->nextPageUrl() ? $results->nextPageUrl()."".$filters:$results->nextPageUrl() ;
        $data['page_count'] = $results->lastPage();
        $data['result_count'] = $results->total();

        return $data;
    }


}