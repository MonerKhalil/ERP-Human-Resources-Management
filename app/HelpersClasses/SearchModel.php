<?php

namespace App\HelpersClasses;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SearchModel
{
    private $request;
    private const DATATYPE_CHARS = ['char', 'varchar', 'binary', 'varbinary', 'text', 'tinytext', 'mediumtext', 'longtext', 'enum', 'set'];
    private const DATATYPE_DATE = ['date', 'timestamp', 'year'];
    private const DATATYPE_Time = ['datetime','time',];

    public function __construct()
    {
        $this->request = request();
    }

    /**
     * @param $queryBuilder
     * @param ?array $filter
     * @param bool|null $isAll
     * @param string|null $isFilterDate_SetColumn
     * @param callable|null $callback
     * @return mixed
     * @author moner khalil
     */
    public function getDataFilter($queryBuilder, array $filter = null
        ,bool $isAll = null,string $isFilterDate_SetColumn = null,callable $callback = null): mixed
    {
        $filterFinal = $this->filterSearchAttributes($filter);
        $tableName = $queryBuilder->getQuery()->from;
        foreach ($filterFinal as $key => $value){
            if (!is_null($value) && Schema::hasColumn($tableName,$key)){
                if (in_array($this->getTypeColumn($key,$tableName),self::DATATYPE_DATE)){
                    $temp = MyApp::Classes()->stringProcess->DateFormat($value);
                    $queryBuilder = $queryBuilder->where($key,"LIKE",$temp."%");
                }elseif (in_array($this->getTypeColumn($key,$tableName),self::DATATYPE_Time)) {
                    $queryBuilder = $queryBuilder->where($key,"LIKE",$value."%");
                }elseif (in_array($this->getTypeColumn($key,$tableName),self::DATATYPE_CHARS)){
                    $queryBuilder = $queryBuilder->where($key,"LIKE",$value."%");
                }else{
                    $queryBuilder = $queryBuilder->where($key,$value);
                }
            }
        }

        if (isset($filterFinal['start_date_filter']) && !is_null($filterFinal['start_date_filter']) &&
            isset($filterFinal['end_date_filter']) && !is_null($filterFinal['end_date_filter'])){
            $from = MyApp::Classes()->stringProcess->DateFormat($filterFinal['start_date_filter']);
            $to = MyApp::Classes()->stringProcess->DateFormat($filterFinal['end_date_filter']);
            if ( is_string($from) && is_string($to) && ($from <= $to) ){
                $isFilterDate_SetColumn = is_null($isFilterDate_SetColumn) ? "created_at" : $isFilterDate_SetColumn;
                $queryBuilder = $queryBuilder->whereBetween($isFilterDate_SetColumn,[$from,$to]);
            }
        }

        $queryBuilder = $queryBuilder->orderBy("updated_at","desc");

        if (!is_null($callback)){
            return $callback($queryBuilder);
        }

        if ($isAll){
            return $queryBuilder->get();
        }

        return $this->dataPaginate($queryBuilder);
    }

    /**
     * @param $queryBuilder
     * @return mixed
     * @author moner khalil
     */
    public function dataPaginate($queryBuilder): mixed
    {
        $tempCount = $this->countItemsPaginate();

        if ($tempCount === "all"){
            return $queryBuilder->get();
        }

        return $queryBuilder->paginate($tempCount);
    }

    /**
     * @return int|string
     * @author moner khalil
     */
    private function countItemsPaginate(): int|string
    {
        if ( isset($this->request->countItems) &&
            (
            (is_numeric($this->request->countItems) && $this->request->countItems > 10)
            ||
            ($this->request->countItems == 'all')
            )
           )
           return $this->request->countItems;
        return 10;
    }

    /**
     * @param $filter
     * @return mixed
     * @author moner khalil
     */
    private function filterSearchAttributes($filter): mixed
    {
        $finalFilter = [];
        if(!is_null($this->request->input("isClearFilter"))
            && $this->request->input("isClearFilter") === "true" ){
            return $finalFilter;
        }
        if (isset($filter)){
            $finalFilter = $filter;
        }
        if (isset($this->request->filter) && is_array($this->request->filter)){
            $finalFilter = array_merge($finalFilter,$this->request->filter);
        }
        return $finalFilter;
    }

    private function getTypeColumn($column,$table){
        return DB::table('INFORMATION_SCHEMA.COLUMNS')
            ->select('DATA_TYPE')
            ->where('TABLE_NAME', $table)
            ->where('COLUMN_NAME', $column)
            ->first()->DATA_TYPE ?? "";
    }
}
