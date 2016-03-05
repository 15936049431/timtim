<?php
/**
 * 
 * @author Ly@Treasure.news
 * @7pointer @ www.7pointer.com
 * @version V1.0
 * @desc 惜食惜衣非为惜财缘惜福 , 求名求利但须求己莫求人 。
 */
class Pagination {
		private $total; //数据表中总记录数
		private $listRows; //每页显示行数
		private $limit;
                public  $offset,$limitnum;
		private $uri;
		private $pageNum; //页数
		private $config=array('header'=>"个记录", "prev"=>"上一页", "next"=>"下一页", "first"=>"首 页", "last"=>"尾 页");
		private $listNum=8;
		/*
		 * $total 
		 * $listRows
		 */
		public function __construct($total, $listRows=10, $pa=""){
			$this->total=$total;
			$this->listRows=$listRows;
			$this->uri=$this->getUri($pa);
			$this->page=!empty($_GET["page"]) ? intval($_GET["page"]) : 1;
			$this->pageNum=ceil($this->total/$this->listRows);
			$this->limit=$this->setLimit();
                        $this->offset = ($this->page-1)*$this->listRows;
                        $this->limitnum = "{$this->listRows}";
		}

		private function setLimit(){
			return "Limit ".($this->page-1)*$this->listRows.", {$this->listRows}";
		}
                
		private function getUri($pa){
			$url=$_SERVER["REQUEST_URI"].(strpos($_SERVER["REQUEST_URI"], '?')?'':"?").$pa;
			$parse=parse_url($url);

			if(isset($parse["query"])){
				parse_str($parse['query'],$params);
				unset($params["page"]);
                                unset($params["total_"]);
				$url=$parse['path'].'?'.http_build_query($params);
				
			}

			return $url;
		}

		function __get($args){
			if($args=="limit")
				return $this->limit;
			else
				return null;
		}

		private function start(){
			if($this->total==0)
				return 0;
			else
				return ($this->page-1)*$this->listRows+1;
		}

		private function end(){
			return min($this->page*$this->listRows,$this->total);
		}

		private function first(){
                        $html='';
			if($this->page==1)
				$html.='';
			else
				$html.="&nbsp;&nbsp;<li><a href='{$this->uri}&total_={$this->total}&page=1'>{$this->config["first"]}</a></li>&nbsp;&nbsp;";

			return $html;
		}

		private function prev(){
                        $html='';
			if($this->page==1)
				$html.='';
			else
				$html.="&nbsp;&nbsp;<li><a href='{$this->uri}&total_={$this->total}&page=".($this->page-1)."'>{$this->config["prev"]}</a></li>&nbsp;&nbsp;";

			return $html;
		}

		private function pageList(){
			$linkPage="";
			
			$inum=floor($this->listNum/2);
		
			for($i=$inum; $i>=1; $i--){
				$page=$this->page-$i;

				if($page<1)
					continue;

				$linkPage.="&nbsp;<li><a href='{$this->uri}&total_={$this->total}&page={$page}'>{$page}</a></li>&nbsp;";

			}
		
			$linkPage.="&nbsp;<li class='active'><a href='#'>{$this->page}</a></li>&nbsp;";
			

			for($i=1; $i<=$inum; $i++){
				$page=$this->page+$i;
				if($page<=$this->pageNum)
					$linkPage.="&nbsp;<li><a href='{$this->uri}&total_={$this->total}&page={$page}'>{$page}</a></li>&nbsp;";
				else
					break;
			}

			return $linkPage;
		}

		private function next(){
                        $html='';
			if($this->page==$this->pageNum)
				$html.='';
			else
				$html.="&nbsp;&nbsp;<li><a href='{$this->uri}&total_={$this->total}&page=".($this->page+1)."'>{$this->config["next"]}</a></li>&nbsp;&nbsp;";

			return $html;
		}

		private function last(){
                        $html='';
			if($this->page==$this->pageNum)
				$html.='';
			else
				$html.="&nbsp;&nbsp;<li><a href='{$this->uri}&total_={$this->total}&page=".($this->pageNum)."'>{$this->config["last"]}</a></li>&nbsp;&nbsp;";

			return $html;
		}

		private function goPage(){
			return '&nbsp;&nbsp;<input type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>'.$this->pageNum.')?'.$this->pageNum.':this.value;location=\''.$this->uri.'&page=\'+page+\'\'}" value="'.$this->page.'" style="width:25px"><input type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>'.$this->pageNum.')?'.$this->pageNum.':this.previousSibling.value;location=\''.$this->uri.'&page=\'+page+\'\'">&nbsp;&nbsp;';
		}
		function fpage($display=array(0,1,2,3,4,5,6,7,8)){
			$html[0]="<li>&nbsp;&nbsp;共有{$this->total}</b>{$this->config["header"]}&nbsp;&nbsp;</li>";
			$html[1]="&nbsp;&nbsp;每页显示".($this->end()-$this->start()+1)."条，本页{$this->start()}-{$this->end()}条&nbsp;&nbsp;";
			$html[2]="<li>&nbsp;&nbsp;{$this->page}/{$this->pageNum}页&nbsp;&nbsp;</li>";
			
			$html[3]=$this->first();
			$html[4]=$this->prev();
			$html[5]=$this->pageList();
			$html[6]=$this->next();
			$html[7]=$this->last();
			$html[8]=$this->goPage();
			$fpage='';
			foreach($display as $index){
				$fpage.=$html[$index];
			}

			return $fpage;

		}

	
	}