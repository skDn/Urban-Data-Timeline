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

class InfiniteScroll extends Controller
{
    public function getSectionToPopulate(Request $request) {

        //return json_encode(array('value'=>'test'));
        return json_encode($request->all());
    }
}