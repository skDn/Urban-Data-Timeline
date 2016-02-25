<?php
/**
 * Created by IntelliJ IDEA.
 * User: skDn
 * Date: 15/02/2016
 * Time: 02:13
 */

namespace Urban\Http\Controllers\REST;

use Illuminate\Http\Request;
use Urban\Http\Controllers\Controller;
use Validator;
use Cache;

class InfiniteScroll extends Controller
{
    public function getSectionToPopulate(Request $request)
    {

//        return json_encode(array('value'=>'test'));
//        $cacheTag = 'fullResponse'; //config timeline twitter

        $cacheKey = '';

        $requestParameters = array_values($request->all());
        $id = array_pop($requestParameters);
        array_pop($requestParameters);

        foreach ($requestParameters as $value) {
            $cacheKey .= $value;
        }

        $fullResponse = Cache::get($cacheKey);


        if (array_key_exists('sections', $fullResponse)) {
            foreach ($fullResponse['sections'] as $section) {
                if ($section['id'] === $id) {
                    return json_encode($section['events']);
                }
            }
        } else if (array_key_exists('responseFirst', $fullResponse)) {
            $returnJson = array(
                'first' => null,
                'second' => null
            );
            foreach ($fullResponse['responseFirst']['sections'] as $section) {
                if ($section['id'] === $id) {
                    $returnJson['first'] = $section['events'];
                }
            }
            foreach ($fullResponse['responseSecond']['sections'] as $section) {
                if ($section['id'] === $id) {
                    $returnJson['second'] = $section['events'];
                }
            }
            return json_encode($returnJson);
        }
        return '';
    }
}