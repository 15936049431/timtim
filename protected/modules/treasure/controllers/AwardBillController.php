<?php

/* 
 * @author: 三氧化二砷 waitfox@qq.com
 * @Created:2015-8-28 13:37:05
 * @version:0.01
 * @desc:
 * 我只为你回眸一笑，即使不够倾国倾城，我只为你付出此生，换来生再次相守
 */

class AwardBillController extends BController {
    
    public function actionList() {
        $model = AwardBill::model();
        $total_count = $model->count();
        $page = new Pagination($total_count, 10);
        $page_list = $page->fpage(array(4, 5, 6));
        $page_list = $total_count <= $page->limitnum ? "" : $page_list;
        $list = $model->findAll(array(
            'limit' => $page->limitnum,
            'offset' => $page->offset,
        ));
        $this->render('list', array(
            'model' => $model,
            'list' => $list,
            'page_list' => $page_list,
        ));
    }
}