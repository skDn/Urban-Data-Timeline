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
    const SECTIONS = 'sections';

    const SECOND = 'second';

    const RESPONSE_FIRST = 'responseFirst';

    const FIRST = 'first';

    const ID = 'id';

    const EVENTS = 'events';

    const RESPONSE_SECOND = 'responseSecond';

    public function getSectionToPopulate(Request $request)
    {

//        $cacheTag = 'fullResponse'; //config timeline twitter

        $cacheKey = '';

        $requestParameters = array_values($request->all());
        $id = array_pop($requestParameters);
        array_pop($requestParameters);

        foreach ($requestParameters as $value) {
            $cacheKey .= $value;
        }

        $fullResponse = Cache::get($cacheKey);


        if (array_key_exists(self::SECTIONS, $fullResponse)) {
            foreach ($fullResponse[self::SECTIONS] as $section) {
                if ($section[self::ID] === $id) {
                    return json_encode($section[self::EVENTS]);
                }
            }
        } else if (array_key_exists(self::RESPONSE_FIRST, $fullResponse)) {
            $returnJson = array(
                self::FIRST => null,
                self::SECOND => null
            );
            foreach ($fullResponse[self::RESPONSE_FIRST][self::SECTIONS] as $section) {
                if ($section[self::ID] === $id) {
                    $returnJson[self::FIRST] = $section[self::EVENTS];
                }
            }
            foreach ($fullResponse[self::RESPONSE_SECOND][self::SECTIONS] as $section) {
                if ($section[self::ID] === $id) {
                    $returnJson[self::SECOND] = $section[self::EVENTS];
                }
            }
            return json_encode($returnJson);
        }
        return '';
    }
}