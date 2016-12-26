<?php

namespace App\Repositories\Promotion;

use App\Repositories\BaseRepository;
use App\Repositories\Promotion\PromotionRepositoryInterface;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionRepository extends BaseRepository implements PromotionRepositoryInterface
{
    protected $model;
    /**
     * Promotion constructor.
     *
     * @param Promotion $model description
     *
     * @return void
     */
    public function __construct(Promotion $model)
    {
        $this->model = $model;
    }

    /**
    * Return promotions expired
    *
    * @param int      $val   Value id.
    * @param datetime $time  Time now.
    * @param int      $limit Limit promotion earch page.
    *
    * @return mixed
    */
    public function filterExpired($val, $time, $limit = null)
    {
        return $this->model->where([
            ['date_end', '<', $time],
            ['product_id', '=', $val],
        ])->paginate($limit);
    }

    /**
    * Return promotions present
    *
    * @param int      $val   Value id.
    * @param datetime $time  Time now.
    * @param int      $limit Limit promotion earch page.
    *
    * @return mixed
    */
    public function filterPresent($val, $time, $limit = null)
    {
        return $this->model->where([
            ['date_start', '<', $time],
            ['date_end', '>', $time],
            ['product_id', '=', $val],
        ])->paginate($limit);
    }

    /**
    * Return promotions future
    *
    * @param int      $val   Value id.
    * @param datetime $time  Time now.
    * @param int      $limit Limit promotion earch page.
    *
    * @return mixed
    */
    public function filterFuture($val, $time, $limit = null)
    {
        return $this->model->where([
            ['date_start', '>', $time],
            ['product_id', '=', $val],
        ])->paginate($limit);
    }

    /**
    * Return time
    *
    * @return time
    */
    public function getTime()
    {
        return date(config('date.format_timestamps'), time());
    }

    /**
    * Check input day start
    *
    * @param datetime $dateStart Time.
    *
    * @return boolean
    */
    public function checkDateStart($dateStart)
    {
        if ($dateStart < $this->getTime()) {
            return true;
        }
    }

    /**
    * Check error day start
    *
    * @param datetime $dateStart Time.
    *
    * @return string
    */
    public function errorDateStart($dateStart)
    {
        if ($this->checkDateStart($dateStart)) {
            return config('promotion.ERROR_DATE_START');
        }
    }

    /**
    * Check input day end
    *
    * @param datetime $dateEnd   Time.
    * @param datetime $dateStart Time.
    *
    * @return boolean
    */
    public function checkDateEnd($dateEnd, $dateStart)
    {
        if ($dateEnd <= $dateStart) {
            return true;
        }
    }

    /**
    * Check error day end
    *
    * @param datetime $dateEnd   Time.
    * @param datetime $dateStart Time.
    *
    * @return string
    */
    public function errorDateEnd($dateEnd, $dateStart)
    {
        if ($this->checkDateEnd($dateEnd, $dateStart)) {
            return config('promotion.ERROR_DATE_END');
        }
    }

    /**
    * Check isset promotion
    *
    * @param int      $productId Product id.
    * @param datetime $val       Time.
    *
    * @return boolean
    */
    public function checkIssetPromotion($productId, $val)
    {
        $promotions= $this->findBy('product_id', $productId);
        foreach ($promotions as $value) {
            if ($value['date_start']< $val && $value['date_end'] > $val) {
                return true;
                break;
            }
        }
    }

    /**
    * Get error isset promotion
    *
    * @param datetime $dateStart Time.
    * @param int      $productId Product id.
    *
    * @return string
    */
    public function errorIssetPromotion($dateStart, $productId)
    {
        if ($this->checkIssetPromotion($productId, $dateStart)) {
            return config('promotion.ERROR_ISSET');
        }
    }

    /**
    * Get error when submit
    *
    * @param datetime $dateStart Time.
    * @param datetime $dateEnd   Time.
    * @param int      $productId Product id.
    *
    * @return array
    */
    public function getError($dateStart, $dateEnd, $productId)
    {
        return array($this->errorDateStart($dateStart), $this->errorDateEnd($dateEnd, $dateStart), $this->errorIssetPromotion($dateStart, $productId));
    }

    /**
     * Get limit 4 promotions which being sale off
     * If not, promotions.date_end neartest
     *
     * @return array Categories
     */
    public function getNeartest()
    {
        $now = Carbon::now();
        $list = $this->model->with('product.voteProducts')
        ->where('promotions.date_end', '>=', $now)
        ->take(config('constants.LIMIT_PROMOTION_INDEX'))->get();
        if (count($list) < config('constants.LIMIT_PROMOTION_INDEX')) {
            $list = $this->model->with('product.voteProducts')
            ->latest()->take(config('constants.LIMIT_PROMOTION_INDEX'))->get();
        }
        return $list;
    }
}
