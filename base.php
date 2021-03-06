<?php


class DB{
    private $dsn="mysql:host=localhost;charset=utf8;dbname=db_story";
    private $root='root';
    private $password='12345';
    private $table;
    private $pdo;

    public function __construct($table){
        $this->table=$table;
        $this->pdo=new PDO($this->dsn,$this->root,$this->password);
    }

    public function all(...$arg){
        $sql="select * from $this->table ";
        // $arg=[]  or [陣列],[SQL字串],[陣列,SQL字串],

        if(isset($arg[0])){
            if(is_array($arg[0])){
                //["欄位"=>"值","欄位"=>"值"]
                //where `欄位`='值' && `欄位`='值'
                //"欄位"=>"值" ====> `欄位`='值'

                foreach($arg[0] as $key => $value){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);
                }
                    $sql=$sql . " where " . implode(" && ",$tmp);
            }else{
                //當它是字串
                $sql=$sql . $arg[0];
            }

            if(isset($arg[1])){
                //當它是字串
                $sql=$sql . $arg[1];
            }

        }

        //echo $sql;
        return $this->pdo->query($sql)->fetchAll();

    }

    // count() 計數函式

    public function count(...$arg){
        $sql="select count(*) from $this->table ";

        if(isset($arg[0])){
            if(is_array($arg[0])){
                foreach($arg[0] as $key => $value){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);
                }
                    $sql=$sql . " where " . implode(" && ",$tmp);
            }else{
 
                $sql=$sql . $arg[0];
            }

            if(isset($arg[1])){
                 $sql=$sql . $arg[1];
            }
        }

        //echo $sql;
        return $this->pdo->query($sql)->fetchColumn();

    }

    // 取得單筆資料find()函式功能
    public function find($id){
        $sql="select * from $this->table ";

        
            if(is_array($id)){
                foreach($id as $key => $value){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);
                }
                    $sql=$sql . " where " . implode(" && ",$tmp);
            }else{
 
                $sql=$sql . " where `id`='$id'";
            }

        //echo $sql;
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

    }

    // 刪除資料功能del()

    public function del($id){
        $sql="delete from $this->table ";
            if(is_array($id)){
                foreach($id as $key => $value){
                    $tmp[]=sprintf("`%s`='%s'",$key,$value);
                }
                    $sql=$sql . " where " . implode(" && ",$tmp);
            }else{
 
                $sql=$sql . " where `id`='$id'";
            }

        //echo $sql;
        return $this->pdo->exec($sql);

    }

    // update和insert功能
    public function save($array){
        if(isset($array['id'])){
            //update
                foreach($array as $key => $value){
                    if($key!='id'){
                        $tmp[]=sprintf("`%s`='%s'",$key,$value);
                    }
                }

            $sql="update $this->table set ".implode(',',$tmp)." where `id`='{$array['id']}'";
        }else{
            //insert
            // `name`,`addr`,`tel`
            $sql="insert into $this->table 
                    (`".implode("`,`",array_keys($array))."`) values
                    ('".implode("','",$array)."')";
        }

        //echo $sql;
        return $this->pdo->exec($sql);
    }

}

function to($url){
    header("location:".$url);
}


/* $Store=new DB("stories");


echo "<pre>";
print_r($Store->save([
                       'name'=>'Uber Eat',
                       'intro_chinese'=>'吳伯益',
                       'file'=>'bg06.jpg',
                       'intro_english'=>"buy something good to eat",
                       'visible'=>'Y'
                    ]));
echo "</pre>"; */

/* echo "<pre>";
print_r($User->count(" where name='amy' "));
echo "</pre>";

echo "<pre>";
print_r($User->count(" where `visible`='Y' " , " order by `id` DESC"));
echo "</pre>";
 */

?>