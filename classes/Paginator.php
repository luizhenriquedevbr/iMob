<?php

/**
* Paginator
*/
class Paginator
{
	private $db;
	private $query;
	private $totalCount;
	private $pageRange = 5;
	private $numItemsPerPage = 5;

	public function __construct($db)
	{
		$this->db = $db;
	}

	private function buildQuery($query, $orderBy = null){

		/*$fields = [];
		$fields[] = 'COUNT(*) OVER() AS total';
		$fields[] = 'ROW_NUMBER () OVER (ORDER BY (SELECT NULL)) AS RowNum';
		if(! empty($queryParts['select'])){
			if(is_array($queryParts['select'])){
				$fields = join(array_merge($fields, $queryParts['select']), ', ');
			}else{
				$fields[] = $queryParts['select'];
				$fields = join($fields, ', ');
			}
		}
		$query = [];
		$query[] = 'SELECT';
		$query[] = $fields;
		$query[] = 'FROM';
		$query[] = $queryParts['from'];
		if($join){
			$query[] = $join;
		}
		if($where){
			$query[] = 'WHERE';
			$query[] = $where;
		}
		if($order){
			$query[] = 'ORDER';
			$query[] = $order;
		}
		$query[] = '';*/

		if(strpos($query, '*')){
			throw new Exception("You must specify every single field of your query. * is not acceptable");
		}

		$formatedQuery = str_ireplace(
			'SELECT',
			sprintf('SELECT COUNT(*) OVER() AS total, ROW_NUMBER () OVER (ORDER BY %s) AS RowNum,', $orderBy ? $orderBy : '(SELECT NULL)'),
			$query
		);

		$sql = "
			WITH pagination AS
			(
				" . $formatedQuery . "
			)
			SELECT
				*
			FROM pagination
			WHERE
				(RowNum BETWEEN :start and :end)
			ORDER BY RowNum
		";

		return $sql;
	}

	public function setLimit($numItemsPerPage){
		$this->numItemsPerPage = $numItemsPerPage;

		return $this;
	}

	public function paginate($query, $page = 1, $orderBy = null){
		$query = $this->buildQuery($query, $orderBy);

		$range = $this->getPageRange($page);
		$result = $this->execute($query, $range);

		if(empty($result)){
			return array();
		}

		$this->totalCount = $result[0]['total'];
		$this->currentPageNumber = $page;

		return $this->getPaginationData($result);
	}

	private function getPaginationData($result){
		$pageCount = $this->getPageCount();
        $current = $this->currentPageNumber;

        if ($pageCount < $current) {
            $this->currentPageNumber = $current = $pageCount;
        }

		if ($this->pageRange > $pageCount) {
            $this->pageRange = $pageCount;
        }

		$delta = ceil($this->pageRange / 2);

        if ($current - $delta > $pageCount - $this->pageRange) {
            $pages = range($pageCount - $this->pageRange + 1, $pageCount);
        } else {
            if ($current - $delta < 0) {
                $delta = $current;
            }
            $offset = $current - $delta;
            $pages = range($offset + 1, $offset + $this->pageRange);
        }

 		$proximity = floor($this->pageRange / 2);

        $startPage  = $current - $proximity;
        $endPage    = $current + $proximity;

        if ($startPage < 1) {
            $endPage = min($endPage + (1 - $startPage), $pageCount);
            $startPage = 1;
        }

        if ($endPage > $pageCount) {
            $startPage = max($startPage - ($endPage - $pageCount), 1);
            $endPage = $pageCount;
        }

        $viewData = array(
            'last'              => $pageCount,
            'current'           => $current,
            'numItemsPerPage'   => $this->numItemsPerPage,
            'first'             => 1,
            'pageCount'         => $pageCount,
            'totalCount'        => $this->totalCount,
            'pageRange'         => $this->pageRange,
            'startPage'         => $startPage,
            'endPage'           => $endPage,
            'items' => $result
        );

        if ($current > 1) {
            $viewData['previous'] = $current - 1;
        }

        if ($current < $pageCount) {
            $viewData['next'] = $current + 1;
        }

        $viewData['pagesInRange'] = $pages;
        $viewData['firstPageInRange'] = min($pages);
        $viewData['lastPageInRange']  = max($pages);

        return $viewData;
	}

	private function execute($query, $params){
		$stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
	}

	private function getPageRange($page){
		return array('start' => ( ($page - 1) * $this->numItemsPerPage + 1), 'end' => ($page * $this->numItemsPerPage));
	}

	public function getPageCount(){
		return intval(ceil($this->totalCount / $this->numItemsPerPage));
	}
}
