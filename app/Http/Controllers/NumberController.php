<?php

namespace App\Http\Controllers;

use App\Contracts\NumberInterface;
use App\Models\Number;
use App\Transformers\NumberTransformer;
use App\Transformers\RomanNumberTransformer;
use Dingo\Api\Contract\Http\Request;
use Laravel\Lumen\Application;


class NumberController extends BaseApiController
{
    public $numberProvider;

    public function __construct(Application $app, NumberInterface $numberProvider)
    {
        parent::__construct($app);
        $this->numberProvider = $numberProvider;
        //$this->numberProvider->test();
    }

    /**
     *
     *
     * @author Dmitry Fedorov <klka1@live.ru>
     * @version 1.0 on 2016-10-17
     *
     * @return \Dingo\Api\Http\Response
     */
    public function recent()
    {
        $limit = $this->request->input('limit');
        $numbers = $this->numberProvider->getRecentNumbers($limit);
        return $this->response->collection($numbers, new NumberTransformer);
    }

    /**
     *
     *
     * @author Dmitry Fedorov <klka1@live.ru>
     * @version 1.0 on 2016-10-17
     *
     * @return \Dingo\Api\Http\Response
     */
    public function top()
    {
        $limit = $this->request->input('limit');
        $numbers = $this->numberProvider->getTopNumbers($limit);

        return $this->response->collection($numbers, new NumberTransformer);
    }

    /**
     * 2016-10-17
     *
     * @author Dmitry Fedorov <klka1@live.ru>
     * @version 1.0 on
     * @param $id
     *
     * @return \Dingo\Api\Http\Response|void
     */
    public function show($id)
    {
        $id = (int)$id;
        if ($id < 1 || $id > 3999) {
            return $this->response->errorBadRequest('ID must be between 1 and 3999');
        }

        $romanNumber = $this->numberProvider->createObjectFromInteger($id);


        return $this->response->item($romanNumber, new RomanNumberTransformer());
    }
}