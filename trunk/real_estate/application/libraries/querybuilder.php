<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Querybuilder {

    private $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    public function GenerateLikeQuery($keyword, $type) {
        $aBuiltKeyword = $this->BuildKeyword($keyword);
        if (count($aBuiltKeyword) == 0)
            return "";

        $strLikeQuery['query'] = "";
        for ($i = 0; $i < count($aBuiltKeyword); $i++) {
            if ($strLikeQuery['query'] != "")
                $strLikeQuery['query'].=" $type ";
            if (isset($aBuiltKeyword[$i]['val']))
                $strLikeQuery['query'].="(lower(description) like lower ('" . '%' . $aBuiltKeyword[$i]['val'] . ' ' . $aBuiltKeyword[$i]['key'] . "%'))";
            else
                $strLikeQuery['query'].="(lower(description) like lower ('" . '%' . $aBuiltKeyword[$i]['key'] . "%'))";
        }
        $strLikeQuery['count'] = count($aBuiltKeyword);
        return $strLikeQuery;
    }

    public function BuildKeyword($keyword) {

        $this->CI->load->library('xml');
        if ($this->CI->xml->load(base_url() . "xml/datadictionary")) {
            $aKeyword = $this->CI->xml->parse();
        }

        $j = 0;
        $aBuiltKeyword = array();
        $str1 = (strtoupper($keyword));
        for ($i = 0; $i < count($aKeyword['dictionary'][0]['keyword']); $i++) {
            $str2 = (strtoupper($aKeyword['dictionary'][0]['keyword'][$i]));
            $pos = strpos($str1, $str2);
            if (strpos($str1, $str2) !== false) {
                $aBuiltKeyword[$j]['key'] = $str2;


                $aTempSplitWords = explode($str2, $str1);
                $aSplitWords = explode(" ", $aTempSplitWords[0]);

                for ($k = count($aSplitWords) - 1; $k >= 0; $k--)
                    if ($k == 0) {
                        if (is_numeric($aSplitWords[$k])) {
                            $aBuiltKeyword[$j]['val'] = $aSplitWords[$k];
                            break;
                        }
                    } else {
                        if (is_numeric($aSplitWords[$k]) && !is_numeric($aSplitWords[$k - 1])) {
                            $aBuiltKeyword[$j]['val'] = $aSplitWords[$k];
                            break;
                        }
                    }


                $j++;
            }
        }

        return $aBuiltKeyword;
    }

    public function BuildQueryStatement($aParameter) {
        $query = "SELECT distinct(R.*), st_asgeojson(R.geom) as location,(SELECT url FROM photo p WHERE p.realestateid = r.realestateid LIMIT 1) as url  FROM REALESTATE R";


        $condition = "";

        if ($aParameter["districtID"] != "") {
            $condition .= "R.districtid=" . $aParameter['districtID'];
        } else {
            if ($aParameter["cityID"] != "") {
                $query .= ", DISTRICT D";
                $condition .= "D.DistrictID = R.DISTRICTID and D.CityID=" . $aParameter["cityID"];
            }
        }

        if ($aParameter["categoryID"] != "") {
            if ($condition != "")
                $condition .= " and categoryid=" . $aParameter['categoryID'];
            else
                $condition .= " categoryid=" . $aParameter['categoryID'];
        }

        if ($aParameter["transaction"] != "") {
            if ($condition != "")
                $condition .= " and lower(transaction)=lower('" . $aParameter['transaction'] . "') ";
            else
                $condition .= " lower(transaction)=lower('" . $aParameter['transaction'] . "') ";
        }

        if (isset($aParameter['direction'])) {
            if ($aParameter['direction'] != "")
                if ($condition != "")
                    $condition .= " and lower(direction)=lower('" . $aParameter['direction'] . "') ";
                else
                    $condition .= " lower(direction)=lower('" . $aParameter['direction'] . "') ";
        }

        if (isset($aParameter['area'])) {
            if ($aParameter['area'] != "") {
                switch ($aParameter['area']) {
                    case "1":
                        $area = " area <= 100 ";
                    case "2":
                        $area = " ( area > 100 and area <= 500) ";
                    case "3":
                        $area = " area > 500 ";
                    default :
                        break;
                }
                if ($condition != "")
                    $condition .= " and " . $area;
                else
                    $condition .= $area;
            }
        }

        if (isset($aParameter['startPrice'])) {
            if ($aParameter['startPrice'] != "") {
                if ($condition != "")
                    $condition.= " and price >= " . $aParameter['startPrice'];
                else
                    $condition.= " price >= " . $aParameter['startPrice'];
            }
        }

        if (isset($aParameter['endPrice'])) {
            if ($aParameter['endPrice'] != "") {
                if ($condition != "")
                    $condition.= " and price <= " . $aParameter['endPrice'];
                else
                    $condition.= " price <= " . $aParameter['endPrice'];
            }
        }

        if (isset($aParameter['currency'])) {
            if ($aParameter['currency'] != "") {
                if ($condition != "")
                    $condition.= " and lower(currency) = lower('" . $aParameter['currency'] . "')";
                else
                    $condition.= " lower(currency) = lower('" . $aParameter['currency'] . "')";
            }
        }




        //spatial query
        if (isset($aParameter['spatialQuery'])) {

            if ($condition != "") {
                $oldQuery = $query . " WHERE " . $condition;
                $query = $oldQuery;
            } else {
                $oldQuery = $query;
            }


            if (isset($aParameter['hospitalDis'])) {
                if ($aParameter['hospitalDis'] != "") {
                    $newQuery = "";
                    $query = "SELECT distinct(R.*), st_asgeojson(R.geom) as location,(SELECT url FROM photo p WHERE p.realestateid = r.realestateid LIMIT 1) as url  FROM";
                    $query.= " (" . $oldQuery . ") as R";
                    $newQuery .= ",( SELECT the_geom from diavat where  lower(diavat.ten_dvatnd) like lower('Bệnh Viện%')) as dv1";
                    $newQuery.= " Where ST_Distance(ST_Transform(R.geom,900913),ST_transform(dv1.the_geom,900913)) <= " . $aParameter['hospitalDis'];
                    $query.=$newQuery;
                    $oldQuery = $query;
                }
            }

            if (isset($aParameter['schoolDis'])) {
                if ($aParameter['schoolDis'] != "") {
                    $newQuery = "";
                    $query = "SELECT distinct(R.*), st_asgeojson(R.geom) as location,(SELECT url FROM photo p WHERE p.realestateid = r.realestateid LIMIT 1) as url  FROM";
                    $query.= "(" . $oldQuery . ") as R";
                    $newQuery .= ",( SELECT the_geom from diavat where lower(diavat.ten_dvatnd) like lower('Trường%')) as dv2";
                    $newQuery.= " Where ST_Distance(ST_Transform(R.geom,900913),ST_transform(dv2.the_geom,900913)) <= " . $aParameter['schoolDis'];
                    $query.=$newQuery;
                    $oldQuery = $query;
                }
            }

            if (isset($aParameter['marketDis'])) {
                if ($aParameter['marketDis'] != "") {
                    $newQuery = "";
                    $query = "SELECT distinct(R.*), st_asgeojson(R.geom) as location,(SELECT url FROM photo p WHERE p.realestateid = r.realestateid LIMIT 1) as url  FROM";
                    $query.= "(" . $oldQuery . ") as R";
                    $newQuery .= ",( SELECT the_geom from diavat where lower(diavat.ten_dvatnd) like lower('Chợ%')) as dv2";
                    $newQuery.= " Where ST_Distance(ST_Transform(R.geom,900913),ST_transform(dv2.the_geom,900913)) <= " . $aParameter['marketDis'];
                    $query.=$newQuery;
                    $oldQuery = $query;
                }
            }

            if (isset($aParameter['streetName'])) {
                if ($aParameter['streetName'] != "" && $aParameter['streetDis'] != "") {
                    $newQuery = "";
                    $query = "SELECT distinct(R.*), st_asgeojson(R.geom) as location,(SELECT url FROM photo p WHERE p.realestateid = r.realestateid LIMIT 1) as url  FROM";
                    $query.= "(" . $oldQuery . ") as R";
                    $newQuery .= ",( SELECT the_geom from dgt where lower(dgt.ten_dgt) like lower('%" . $aParameter['streetName'] . "%')) as street";
                    $newQuery.= " where ST_Within(ST_Transform(r.geom,900913),ST_Buffer(ST_Transform(street.the_geom,900913)," . $aParameter['streetDis'] . ",'endcap=round join=round'))=true";
                    $query.=$newQuery;
                    $oldQuery = $query;
                }
            }


            return $query;
        } else
        if ($condition != "")
            $query .= " WHERE " . $condition;

        return $query;
    }

    public function BuildQueryStatementForSearch($aParameter) {
        $query = $this->BuildQueryStatement($aParameter);

        $resultQuery = $this->GenerateLikeQuery($aParameter['keyword'], "and");
        $resultQuery2 = $this->GenerateLikeQuery($aParameter['keyword'], "or");

        if ($resultQuery == "")
            return $query;

        $pos = substr_count(strtolower($query), 'where');

        if ($resultQuery['count'] == 1)
            if ($pos == 2)
                $fullQuery = $query . " and " . $resultQuery['query'];
            else
                $fullQuery = $query . " where " . $resultQuery['query'];
        else
        if ($pos == 2)
            $fullQuery = $query . " and " . $resultQuery['query'] . " union " . $query . " and " . $resultQuery2['query'];
        else
            $fullQuery = $query . " where " . $resultQuery['query'] . " union " . $query . " where " . $resultQuery2['query'];

        return $fullQuery;
    }

    public function BuildQueryStatementForSeachWithGeom($aParameter) {
        $query = $this->BuildQueryStatement($aParameter);
        $point1 = $aParameter['x'] . " " . $aParameter['y'];
        $point2 = $aParameter['z'] . " " . $aParameter['y'];
        $point3 = $aParameter['z'] . " " . $aParameter['t'];
        $point4 = $aParameter['x'] . " " . $aParameter['t'];

        $pos = substr_count(strtolower($query), 'where');
        if ($pos == 2) {
            $query .= " and ST_WithIn(geom,ST_GeomFromText('POLYGON(($point1,$point2,$point3,$point4,$point1))',4326))=true";
        }
        else
            $query .= " where ST_WithIn(geom,ST_GeomFromText('POLYGON(($point1,$point2,$point3,$point4,$point1))',4326))=true";

        $resultQuery = $this->GenerateLikeQuery($aParameter['keyword'], "and");
        $resultQuery2 = $this->GenerateLikeQuery($aParameter['keyword'], "or");
        if ($resultQuery == "")
            return $query;

        $pos = substr_count(strtolower($query), 'where');

        if ($resultQuery['count'] == 1) {
            if ($pos >= 2)
                $fullQuery = $query . " and " . $resultQuery['query'];
            else
                $fullQuery = $query . " where " . $resultQuery['query'];
        } else {
            if ($pos >= 2)
                $fullQuery = $query . " and " . $resultQuery['query'] . " union " . $query . " and " . $resultQuery2['query'];
            else
                $fullQuery = $query . " where " . $resultQuery['query'] . " union " . $query . " where " . $resultQuery2['query'];
        }

        return $fullQuery;
    }

    public function BuildQueryStatementForAdvancedSearch($aParameter) {
        $oldQuery = $this->BuildQueryStatement($aParameter);
        $query = "SELECT distinct(R.*), st_asgeojson(R.geom) as location,(SELECT url FROM photo p WHERE p.realestateid = r.realestateid LIMIT 1) as url  FROM";
        $query.= "(" . $oldQuery . ") as R";

        $resultQuery = $this->GenerateLikeQuery($aParameter['keyword'], "and");
        $resultQuery2 = $this->GenerateLikeQuery($aParameter['keyword'], "or");

        if ($resultQuery == "")
            return $query;


        if ($resultQuery['count'] == 1) {
            $countWhere = 1;
            $fullQuery = $query . " where " . $resultQuery['query'];
        } else
        if ($countWhere == 1)
            $fullQuery = $query . " and " . $resultQuery['query'] . " union " . $query . " and " . $resultQuery2['query'];
        else
            $fullQuery = $query . " where " . $resultQuery['query'] . " union " . $query . " where " . $resultQuery2['query'];

        return $fullQuery;
    }

    public function BuildQueryStatementForAdvancedSeachWithGeom($aParameter) {
        $oldQuery = $this->BuildQueryStatement($aParameter);
        $query = "SELECT distinct(R.*), st_asgeojson(R.geom) as location,(SELECT url FROM photo p WHERE p.realestateid = r.realestateid LIMIT 1) as url  FROM";
        $query.= "(" . $oldQuery . ") as R";

        $point1 = $aParameter['x'] . " " . $aParameter['y'];
        $point2 = $aParameter['z'] . " " . $aParameter['y'];
        $point3 = $aParameter['z'] . " " . $aParameter['t'];
        $point4 = $aParameter['x'] . " " . $aParameter['t'];

        $query .= " where ST_WithIn(geom,ST_GeomFromText('POLYGON(($point1,$point2,$point3,$point4,$point1))',4326))=true";

        $resultQuery = $this->GenerateLikeQuery($aParameter['keyword'], "and");
        $resultQuery2 = $this->GenerateLikeQuery($aParameter['keyword'], "or");
        if ($resultQuery == "")
            return $query;

        $pos = substr_count(strtolower($query), 'where');

        if ($resultQuery['count'] == 1) {

            $fullQuery = $query . " and " . $resultQuery['query'];
        } else {

            $fullQuery = $query . " and " . $resultQuery['query'] . " union " . $query . " and " . $resultQuery2['query'];
        }

        return $fullQuery;
    }

    public function GenerateQueryStatementForSearch($query, $limit, $offset) {
        if ($limit != "" && $offset != "")
            $query .= " LIMIT $limit OFFSET $offset";
        return $query;
    }

}

?>
